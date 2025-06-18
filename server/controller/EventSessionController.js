const { Op } = require("sequelize");
const { EventSession } = require('../models');

const getByEventId = async (req, res) => {
    const { event_id } = req.params;
    try {
        const eventSessions = await EventSession.findAll({
            where: { event_id }
        });
        
        if (eventSessions.length === 0) {
            return res.status(404).json({ 
                id: event_id,
                message: 'Tidak ada sesi yang ditemukan untuk event ini.' 
            });
        }

        res.json(eventSessions);

    } catch (error) {
    res.status(500).json({ message:'Gagal mengambil sesi berdasarkan event.' });
    }
};

const store = async (req, res) => {
    const { event_id } = req.params;
    const { nama_sesi, tanggal, jam_mulai, jam_selesai } = req.body;
    try {
        if (!event_id || !nama_sesi || !tanggal || !jam_mulai || !jam_selesai) {
            return res.status(400).json({ message: 'Semua field harus diisi.'});
        }

        const newSession = await EventSession.create({
            event_id,
            nama_sesi,
            tanggal,
            jam_mulai,
            jam_selesai
        });
        res.status(201).json(newSession);
    } catch (error) {
        res.status(500).json({ message: 'Gagal menyimpan sesi acara.' });
    }
}

const show = async (req, res) => {
    const { id } = req.params;
    try {
        const session = await EventSession.findByPk(id);
        if (!session) {
            return res.status(404).json({ message: 'Sesi tidak ditemukan.' });
        }
        res.json(session);
    } catch (error) {
        res.status(500).send({ message: 'Gagal mengambil sesi acara.' });
    }
}

const update = async (req, res) => {
    const { id } = req.params;
    const { nama_sesi, tanggal, jam_mulai, jam_selesai } = req.body;
    try {
        const session = await EventSession.findByPk(id);
        if (!session) {
            return res.status(404).json({ message: 'Sesi tidak ditemukan.' });
        };

        await session.update({
            nama_sesi,
            tanggal,
            jam_mulai,
            jam_selesai
        });

        res.json({ message: 'Sesi acara berhasil diperbarui.' });
    } catch (error) {
        res.status(500).send({ message: 'Gagal memperbarui sesi acara.' });
    }
};

const destroy = async (req, res) => {
    const { id } = req.params;
    try {
        const session = await EventSession.findByPk(id);
        if (!session) {
            return res.status(404).json({ message: 'Sesi tidak ditemukan.' });
        }

        await session.destroy();
        res.json({ message: 'Sesi acara berhasil dihapus.' });
    } catch (error) {
        res.status(500).send({ message: 'Gagal menghapus sesi acara.' });
    }
};

module.exports = {
    getByEventId,
    store,
    show,
    update,
    destroy
};

