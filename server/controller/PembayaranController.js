const { Op, where } = require("sequelize");
const { Registrasi, Pembayaran } = require('../models');

const store = async (req, res) => {
    try {
        const pembayaran = await Pembayaran.create()
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Terjadi kesalah saat melakukan pemabayaran' })
    }
}