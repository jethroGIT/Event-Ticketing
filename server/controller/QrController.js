const { Tiket, EventSession, Events } = require('../models');

const validateQRCode = async (req, res) => {
    try {
        const { qr_token } = req.body;

        if (!qr_token) {
            return res.status(400).json({ message: 'QR token diperlukan' });
        }

        const tiket = await Tiket.findOne({
            where: { qr_token },
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
        });

        if (!tiket) {
            return res.status(404).json({ message: 'QR tidak valid atau tidak ditemukan' });
        }

        return res.status(200).json({
            message: 'QR valid',
            data: tiket
        });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: 'Terjadi kesalahan saat memvalidasi QR' });
    }
};

module.exports = {
    validateQRCode
}