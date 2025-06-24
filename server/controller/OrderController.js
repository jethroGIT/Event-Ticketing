const { Op } = require("sequelize");
const { v4: uuidv4 } = require('uuid');
const QRCode = require('qrcode');
const { Registrasi, Pembayaran, Tiket, EventSession, Events } = require('../models');

const getDetailPesanan = async (req, res) => {
    try {
        const { user_id, role } = req.query;

        const whereClause = {};

        if (role !== 'admin' && role !== 'keuangan') {
            whereClause.user_id = { [Op.eq]: user_id };
        }

        const orders = await Registrasi.findAll({
            where: whereClause,
            include: [
                {
                    model: Pembayaran,
                    as: 'Pembayaran',
                    attributes: ['id', 'tipe_pembayaran', 'status_pembayaran']
                },
                {
                    model: Tiket,
                    as: 'Tiket',
                    attributes: ['id', 'session_id', 'qr_token', 'regis_id'],
                    include: [
                        {
                            model: EventSession,
                            as: 'EventSessions',
                            attributes: ['id', 'nama_sesi', 'jam_mulai', 'jam_selesai'],
                            include: [
                                {
                                    model: Events,
                                    as: 'Events',
                                    attributes: ['id', 'nama_event', 'lokasi', 'biaya_registrasi', 'start_event', 'end_event']
                                }
                            ]
                        }
                    ]
                }
            ]
        });

        // Tambahkan qr_image jika ada qr_token
        const enhancedOrders = await Promise.all(orders.map(async (order) => {
            const enhancedTiket = await Promise.all(order.Tiket.map(async (tiket) => {
                if (tiket.qr_token) {
                    const qr_image = await QRCode.toDataURL(tiket.qr_token);
                    return { ...tiket.toJSON(), qr_image };
                } else {
                    return { ...tiket.toJSON(), qr_image: null };
                }
            }));
            return {
                ...order.toJSON(),
                Tiket: enhancedTiket
            };
        }));

        res.status(200).json(enhancedOrders);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: 'Gagal mengambil detail pesanan' });
    }
};

const logTransaksi = async (req, res) => {
    try {
        const pembayaran = await Registrasi.findAll({
            include: [
                {
                    model: Pembayaran,
                    as: 'Pembayaran',
                    attributes: ['id', 'tipe_pembayaran', 'status_pembayaran', 'bukti_pembayaran'],
                },
                {
                    model: Tiket,
                    as: 'Tiket',
                    attributes: ['id', 'session_id']
                }
            ]
        });

        res.status(200).json(pembayaran);
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Terjadi kesalahan saat mengkonfirmasi pembayaran' });
    }
};

const updateTransaksi = async (req, res) => {
    try {
        const pembayaranId = req.params.id;
        const { status_pembayaran } = req.body;

        const pembayaran = await Pembayaran.findByPk(pembayaranId);
        if (!pembayaran) {
            return res.status(404).json({ message: 'Pembayaran tidak ditemukan' });
        }

        await pembayaran.update({
            status_pembayaran
        });

        if (status_pembayaran === 'confirmed') {
            const tiketList = await Tiket.findAll({
                where: { regis_id: pembayaran.regis_id }
            });

            if (tiketList.length > 0) {
                for (const tiket of tiketList) {
                    const qr_token = uuidv4();
                    await tiket.update({ qr_token });
                }

                return res.status(200).json({
                    message: `Status pembayaran dikonfirmasi dan ${tiketList.length} QR code berhasil dibuat`
                });
            }
        }

        res.status(200).json({ message: 'Status pembayaran berhasil diperbarui' });
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Terjadi kesalahan saat mengupdate transaksi' });
    }
}

const destroyPesanan = async (req, res) => {
    try {
        const regis_id = req.params.regis_id;

        const registrasi_data = await Registrasi.findByPk(regis_id);

        await registrasi_data.destroy();

        res.status(200).json({ message: 'Order tiket berhasil dibatalkan' })
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Terjadi kesalahan saat menghapus data' })
    }
}


module.exports = {
    getDetailPesanan,
    destroyPesanan,
    logTransaksi,
    updateTransaksi
};