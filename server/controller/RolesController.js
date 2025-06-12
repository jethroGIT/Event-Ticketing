const { Op } = require("sequelize");
const { Roles } = require('../models')  // import model roles dari index.js Sequelize

// Menampilkan semua role
const index = async (req, res) => {
  try {
    const { nama_role } = req.query;

    const roles = await Roles.findAll({
      where: nama_role ? {
        nama_role: {
          [Op.like]: `%${nama_role}%`
        }
      } : undefined
    });

    res.json(roles);

  } catch (error) {
    console.error(error);
    res.status(500).json({ message: 'Terjadi kesalahan saat mengambil data roles.' });
  }
};

// Menyimpan role baru
const store = async (req, res) => {
  try {

    const { nama_role } = req.body;

    if (!nama_role || nama_role.trim() === '') {
      return res.status(400).json({ message: 'Nama role tidak boleh kosong.' });
    }

    const existingRole = await Roles.findOne({ where: { nama_role } });

    if (existingRole) {
      return res.status(400).json({ message: 'Nama role sudah ada dalam database.' });
    }

    await Roles.create({ nama_role });

    res.redirect('/roles');
  } catch (error) {
    console.error(error);
    res.status(500).json({ message: 'Gagal menyimpan role baru.' });
  }
};


// Menampilkan detail role berdasarkan ID
const show = async (req, res) => {
  const { id } = req.params;

  try {
    const role = await Roles.findByPk(id);

    if (!role) {
      return res.status(404).json({
        success: false,
        message: 'Role tidak ditemukan.'
      });
    }

    return res.json({
      success: true,
      data: role
    });

  } catch (error) {
    console.error('Show Role Error', error);
    return res.status(500).json({
      success: false,
      message: 'Terjadi kesalahan saat mengambil detail role.'
    });
  }
};

//Mengupdate role
const update = async (req, res) => {
  const { id } = req.params;
  const { nama_role } = req.body;

  try {
    const role = await Roles.findByPk(id);

    if (!role) {
      return res.status(404).json({ message: 'Role tidak ditemukan.' });
    }

    const existingRole = await Roles.findOne({ where: { nama_role } });

    if (existingRole) {
      return res.status(400).json({ message: 'Nama role sudah ada dalam database.' });
    }

    await role.update({
      nama_role: req.body.nama_role
    });

    res.redirect('/roles');
  } catch (error) {
    console.error('Update Role Error', error);
    res.status(500).json({ message: 'Terjadi kesalahan saat mengupdate data role.' });
  }
};

// Menghapus role
const destroy = async (req, res) => {
  const { id } = req.params;

  try {
    const role = await Roles.findByPk(id);

    if (!role) {
      return res.status(404).json({ message: 'Role tidak ditemukan.' });
    }

    await role.destroy();
    
    res.status(200).json({ message: 'User berhasil dihapus.' });
    
  } catch (error) {
    console.error('Delete Role Error', error);
    res.status(500).json('Terjadi kesalahan saat menghapus data role.');
  }

};

// Export semua fungsi untuk digunakan di routes
module.exports = { index, store, show, update, destroy };
