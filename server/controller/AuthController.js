import bcrypt from 'bcrypt';
import { Users } from '../models/index.js';
import jwt from 'jsonwebtoken';
import dotenv from 'dotenv';
dotenv.config();

const index = (req, res) => {
    res.render('auth/index');
};

const login = async (req, res) => {
    const { email, password } = req.body;

    if (!email || !password) {
        console.error('Username dan Password tidak boleh kosong');
        return res.status(401).json({ success: false, message: 'Username dan Password tidak boleh kosong' });
    }

    try {
        const user = await Users.findOne({ where: { email } });

        if (!user) {
            console.error('Email tidak ditemukan');
            return res.status(401).json({ success: false, message: 'Email tidak ditemukan!' });
        }

        const match = await bcrypt.compare(password, user.password);

        if (match) {
            const payload = {
                id: user.id,
                role: user.role_id,
                email: user.email,
                status: user.status,
            }
            const secret = process.env.JWT_SECRET;
            const expiresIn = '24h';
            const token = jwt.sign(payload, secret, { expiresIn });

            return res.json({
                success: true,
                message: 'Selamat Datang ' + user.nama,
                data: {
                    id: user.id,
                    role: user.role_id,
                    email: user.email,
                    nama: user.nama,
                    alamat: user.alamat,
                    no_tlp: user.no_tlp,
                    status: user.status,
                },
                token: token
            });
        } else {
            console.error('Password salah');
            return res.status(401).json({ success: false, message: 'Password salah!' });
        }
    } catch (err) {
        console.error(err);
        return res.status(500).json({ success: false, message: 'Terjadi kesalahan' });
    }
};

const logout = (req, res) => {
    req.session.destroy((err) => {
        if (err) {
            console.error('Gagal logout:', err);
            return res.status(500).json({ success: false, message: 'Gagal logout' });
        }
    });
}

export { index, login, logout };
