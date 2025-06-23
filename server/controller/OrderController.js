const { Op } = require("sequelize");
const { Registrasi, Pembayaran, Tiket, EventSession, Events } = require('../models');

const getDetailPesanan = async (req, res) => {
    try {
        const user_id = req.query.user_id;

        const orders = await Registrasi.findAll({
            where: {
                user_id: {
                    [Op.eq]: user_id
                }
            },
            include: [
                {
                    model: Pembayaran,
                    as: 'Pembayaran',
                    attributes: ['id', 'tipe_pembayaran', 'status_pembayaran']
                },
                {
                    model: Tiket,
                    as: 'Tiket',
                    attributes: ['id', 'session_id'],
                    include: [
                        {
                            model: EventSession,
                            as: 'EventSessions',
                            attributes: ['id', 'nama_sesi', 'jam_mulai', 'jam_selesai'],
                            include: [
                                {
                                    model: Events,
                                    as: 'Events',
                                    attributes: ['id', 'nama_event', 'lokasi', 'biaya_registrasi','start_event', 'end_event']
                                }
                            ]
                        }
                    ]
                }
            ]
        });

        res.status(200).json(orders);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: 'Gagal mengambil detail pesanan' });
    }
};

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
    destroyPesanan
};