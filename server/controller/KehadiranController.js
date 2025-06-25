const { EventSession, Events, Registrasi, Tiket, Kehadiran, Sertifikat } = require('../models');

const validateQRCode = async (req, res) => {
    try {
        const { qr_token } = req.body;

        if (!qr_token) {
            return res.status(400).json({ message: 'QR token diperlukan' });
        }

        const tiket = await Tiket.findOne({
            where: { qr_token },
            attributes: ['id'],
            include: [
                {
                    model: EventSession,
                    as: 'EventSessions',
                    attributes: ['id', 'nama_sesi', 'jam_mulai', 'jam_selesai'],
                    include: [
                        {
                            model: Events,
                            as: 'Events',
                            attributes: ['nama_event']
                        }
                    ]
                }
            ]
        });

        if (!tiket) {
            return res.status(404).json({ message: 'QR tidak valid atau tidak ditemukan' });
        }

        // Cek apakah tiket sudah hadir sebelumnya
        const existing = await Kehadiran.findOne({
            where: { tiket_id: tiket.id }
        });

        if (existing) {
            return res.status(409).json({ message: 'Peserta sudah tercatat hadir sebelumnya' });
        }

        // Simpan data kehadiran
        await Kehadiran.create({
            tiket_id: tiket.id,
            status: 'hadir',
            waktu_kehadiran: new Date().toTimeString().split(' ')[0]
        });

        return res.status(200).json({
            message: 'QR valid dan peserta tercatat hadir',
            data: tiket
        });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: 'Terjadi kesalahan saat memvalidasi QR' });
    }
};

const sertifikatKehadiran = async (req, res) => {
    try {
        const { user_id, role } = req.query;

        let whereRegistrasi = {};
        if (role === '2') {
            // Hanya ambil registrasi milik user untuk role member
            whereRegistrasi = { user_id };
        }

        const semua_registrasi = await Registrasi.findAll({
            where: whereRegistrasi,
            attributes: ['id'],
            include: [
                {
                    model: Tiket,
                    as: 'Tiket',
                    attributes: ['id']
                }
            ]
        });

        const tiketIds = semua_registrasi.flatMap(reg => reg.Tiket.map(t => t.id));

        if (tiketIds.length === 0) {
            return res.status(404).json({ message: 'Tidak ada tiket ditemukan untuk pengguna ini' });
        }

        const kehadiran = await Kehadiran.findAll({
            where: { tiket_id: tiketIds },
            include: [
                {
                    model: Sertifikat,
                    as: 'Sertifikat',
                    attributes: ['id', 'sertifikat_url']
                },
                {
                    model: Tiket,
                    as: 'Tiket',
                    include: [
                        {
                            model: EventSession,
                            as: 'EventSessions',
                            include: [
                                {
                                    model: Events,
                                    as: 'Events'
                                }
                            ]
                        }
                    ]
                }
            ]
        });

        if (kehadiran.length === 0) {
            return res.status(404).json({ message: 'Tidak ada data kehadiran ditemukan' });
        }

        const sertifikatData = kehadiran.map(item => ({
            nama_event: item.Tiket?.EventSessions?.Events?.nama_event ?? '-',
            nama_sesi: item.Tiket?.EventSessions?.nama_sesi ?? '-',
            id_kehadiran: item.id,
            waktu_kehadiran: item.waktu_kehadiran,
            status: item.status,
            sertifikat_url: item.Sertifikat?.sertifikat_url ?? null
        }));

        return res.status(200).json({
            message: 'Data sertifikat kehadiran berhasil diambil',
            data: sertifikatData
        });

    } catch (error) {
        console.error(error);
        return res.status(500).json({
            message: 'Terjadi kesalahan saat memproses sertifikat kehadiran',
            error: error.message
        });
    }
};


const uploadSertifikat = async (req, res) => {
    try {
        const { id } = req.params; // id ini adalah id_kehadiran
        const { sertifikat_url } = req.body;

        if (!sertifikat_url) {
            return res.status(400).json({ message: 'URL sertifikat diperlukan' });
        }

        // Cari dulu apakah ada sertifikat yang sudah pernah diupload
        const existing = await Sertifikat.findOne({ where: { id_kehadiran: id } });

        let result;

        if (existing) {
            // Update jika sudah ada
            result = await Sertifikat.update(
                { sertifikat_url },
                { where: { id_kehadiran: id }, returning: true }
            );
        } else {
            // Buat baru jika belum ada
            result = await Sertifikat.create({ id_kehadiran: id, sertifikat_url });
        }

        res.status(200).json({
            message: 'Sertifikat berhasil disimpan',
            data: result
        });

    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Terjadi kesalahan saat menyimpan sertifikat' });
    }
};


module.exports = {
    validateQRCode,
    sertifikatKehadiran,
    uploadSertifikat
}