// controllers/userController.js
const bcrypt = require('bcrypt');
const { Op } = require("sequelize");
const { Users, Roles } = require('../models');

const index = async (req, res) => {
  try {
    const { email } = req.query;

    const users = await Users.findAll({
      where: email ? {
        email: {
          [Op.like]: `%${email}%`
        }
      } : undefined,
      include: [{ 
        model: Roles,
        as: 'Role', 
        attributes: ['id', 'nama_role']
      }]
    });

    res.json(users);
    
  } catch (error) {
    console.error(error);
    res.status(500).send('Terjadi kesalahan saat mengambil data users.');
  }
};

const store = async (req, res) => {
    try {
        const { role_id, email, password, nama, alamat, no_tlp, status } = req.body;
    
        if (!email || !password || !nama || !alamat || !no_tlp || !status) {
        return res.status(400).json({message: 'Data tidak boleh kosong.'});
        }
    
        const existingUser = await Users.findOne({ where: { email } });
    
        if (existingUser) {
        return res.status(400).json({message: 'Email sudah ada dalam database.'});
        }
    
        await Users.create({ 
          role_id, 
          email, 
          password: bcrypt.hashSync(password, 10),
          nama, 
          alamat, 
          no_tlp, 
          status 
        });
    
        res.redirect('/users');
    } catch (error) {
        console.error(error);
        res.status(500).json({message: 'Gagal menyimpan user baru.'});
    }
}

// Menampilkan detail user berdasarkan ID
const show = async (req, res) => {
  const { id } = req.params;

  try {
    const user = await Users.findByPk(id);

    if (!user) {
      return res.status(404).json({
        success: false,
        message: 'User tidak ditemukan.'
      });
    }

    return res.json({
      success: true,
      data: user
    });

  } catch (error) {
    console.error('Show User Error', error);
    return res.status(500).json({
      success: false,
      message: 'Terjadi kesalahan saat mengambil detail user.'
    });
  }
};

const update = async (req, res) => {
  const { id } = req.params;
  const { role_id, email, password, nama, alamat, no_tlp, status } = req.body;

  try {
    const user = await Users.findByPk(id);

    if (!user) {
      return res.status(404).json('User tidak ditemukan.');
    }

    if (!role_id || !email || !password || !nama || !alamat || !no_tlp || !status) {
    return res.status(400).json({message: 'Data tidak boleh kosong.'});
    }

    const existingUser = await Users.findOne({ where: { email } });

    if (existingUser && existingUser.id !== user.id) {
    return res.status(400).json({message: 'Email sudah ada dalam database.'});
    }

    await user.update({ 
      role_id: req.body.role_id, 
      email: req.body.email, 
      password: bcrypt.hashSync(password, 10), 
      nama: req.body.nama, 
      alamat: req.body.alamat, 
      no_tlp: req.body.no_tlp, 
      status: req.body.status 
    });

    res.redirect('/users');
  } catch (error) {
    console.error(error);
    res.status(500).send('Gagal memperbarui user.');
  }
}

const destroy = async (req, res) => {
  const { id } = req.params;

  try {
    const user = await Users.findByPk(id);
    
    if (!user) {
      return res.status(404).json({message: 'User tidak ditemukan.'});
    }

    await user.destroy();

    res.status(200).json({message: 'User berhasil dihapus.'});

  } catch (error) {
    console.error(error);
    res.status(500).send('Gagal menghapus user.');
  }
}


module.exports = { 
  index, 
  store, 
  show, 
  update, 
  destroy 
};
