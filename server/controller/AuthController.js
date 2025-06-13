import bcrypt from 'bcrypt';
import { Users } from '../models/index.js';

const index = (req, res) => {
    res.render('auth/index');
};

const login = async (req, res) => {
    const { email, password } = req.body;

    if (!email || !password) {
        console.error('Username dan Password tidak boleh kosong');
        return res.status(401).json({ success: false, message: 'Username dan Password tidak boleh kosong' });
        return res.redirect('/login');
    }

    try {
        const user = await Users.findOne({ where: { email } });

        if (!user) {
            console.error('Username atau Password salah');
            return res.redirect('/api/login');
        }

        const match = password === user.password;

        if (match) {
            return res.json({
                success: true,
                message: 'Selamat Datang ' + user.email,
                data: {
                    id: user.id,
                    email: user.email,
                    role: user.role_id,
                    nama: user.nama,
                    alamat: user.alamat,
                    no_tlp: user.no_tlp,
                    status: user.status,
                }
            });
        } else {
            console.error('Username atau Password salah');
            return res.status(401).json({ success: false, message: 'Username atau Password salah' });
        }
    } catch (err) {
        console.error(err);
        console.error('Terjadi kesalahan');
        return res.redirect('/api/login');
    }
};

const logout = (req, res) => {
    req.session.destroy((err) => {
        if (err) {
            console.error('Gagal logout:', err);
            return res.status(500).json({ success: false, message: 'Gagal logout' });
        }
        res.redirect('/login');
    });
}

export { index, login, logout };
