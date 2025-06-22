const { Op, where } = require("sequelize");
const { Events, EventSession, Registrasi, Tiket, Pembayaran } = require('../models');

const EventTersedia = async (req, res) => {
    try {
        const { search } = req.query;

        const eventTersedia = await Events.findAll({
            where: search ? {
                nama_event: {
                    [Op.like]: `%${search}%`
                }
            } : undefined,
            include: [
                {
                    model: EventSession,
                    as: 'EventSessions',
                    attributes: ['id', 'nama_sesi', 'tanggal', 'jam_mulai', 'jam_selesai']
                }
            ]
        });

        res.json(eventTersedia);

    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Terjadi kesalahan saat mengambil data event.' });
    }
}

const RegistrasiEvent = async (req, res) => {
    try {
        const { user_id } = req.body
        const registrasiBaru = await Registrasi.create({ user_id })
        res.status(200).json({
            message: 'Registrasi berhasil',
            data: registrasiBaru.id
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({ message: 'Terjadi kesalahan saat melakukan registrasi' })
    }
}

const Konfirmasi = async (req, res) => {
    try {
        const event_id = req.params.event_id;

        const eventSessions = await EventSession.findAll({
            where: { event_id },
            include: [{
                model: Events,
                as: 'Events',
                attributes: ['id', 'nama_event']
            }],
        });

        res.status(200).json({ eventSessions })

    } catch (error) {
        console.error(error)
        res.status(500).json({ message: 'Terjadi kesalahan saat melakukan pembayaran' })
    }
}


const konfirmasiPendaftaran = async (req, res) => {
    try {
        const { regis_id, sesi_id, tipe_pembayaran, bukti_pembayaran } = req.body;

        if (!regis_id || !Array.isArray(sesi_id) || !tipe_pembayaran) {
            return res.status(400).json({ message: 'Data tidak lengkap' });
        }

        for (const sid of sesi_id) {
            await Tiket.create({
                session_id: sid,
                regis_id: regis_id
            });
        }

        await Pembayaran.create({
            regis_id: regis_id,
            tipe_pembayaran: tipe_pembayaran,
            bukti_pembayaran: bukti_pembayaran || null,
            status_pembayaran: 'pending'
        });

        return res.status(200).json({ message: 'Berhasil membuat tiket dan pembayaran' });

    } catch (error) {
        console.error(error)
        res.status(500).json({ message: 'Terjadi kesalah saat menyimpan data' })
    }
}


module.exports = {
    EventTersedia,
    RegistrasiEvent,
    Konfirmasi,
    konfirmasiPendaftaran
};