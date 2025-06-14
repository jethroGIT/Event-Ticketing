// middleware/verifyToken.js
import jwt from 'jsonwebtoken';
import dotenv from 'dotenv';
dotenv.config();

export function verifyToken(req, res, next) {
    const bearerHeader = req.headers['authorization'];

    if (typeof bearerHeader !== 'undefined') {
        const token = bearerHeader.split(' ')[1];

        const secret = process.env.JWT_SECRET;

        jwt.verify(token, secret, (err, decoded) => {
            if (err) {
                return res.status(403).json({ success: false, message: 'Token tidak valid' });
            }

            req.user = decoded; // user info dari token
            next();
        });
    } else {
        return res.status(401).json({ success: false, message: 'Token tidak ditemukan' });
    }
}
