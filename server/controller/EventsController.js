const { Op } = require("sequelize");
const { Events, Users } = require('../models');

const index = async (req, res) => {
  try {
    const { nama_event } = req.query;

    const events = await Events.findAll({
      where: nama_event ? {
        nama_event: {
          [Op.like]: `%${nama_event}%`
        }
      } : undefined,
    });

    res.json(events);
    
  } catch (error) {
    console.error(error);
    res.status(500).send('Terjadi kesalahan saat mengambil data events.');
  }
}

const store = async (req, res) => {
    try {
        const { nama_event, start_event, end_event, lokasi, narasumber, poster_url, deskripsi, biaya_registrasi, maks_peserta, created_by } = req.body;
    
        if (!nama_event || !start_event || !end_event || !lokasi || !narasumber || !poster_url || !deskripsi || !biaya_registrasi || !maks_peserta) {
        return res.status(400).json({ message: 'Data tidak boleh kosong.' });
        }
    
        await Events.create({ nama_event, start_event, end_event, lokasi, narasumber, poster_url, deskripsi, biaya_registrasi, maks_peserta, created_by });
        res.json({ message: 'Event berhasil dibuat.' });
        res.redirect('/events');
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Gagal menyimpan event baru.' });
    }
}

const show = async (req, res) => {
  const { id } = req.params;

  try {
    const event = await Events.findByPk(id, {
      include: [{
        model: Users,
        as: 'User',
        attributes: ['id', 'nama']
      }]
    });

    if (!event) {
      return res.status(404).json({ message: 'Event tidak ditemukan.' });
    }

    res.json({
      success: true,
      data: event
    });
    
  } catch (error) {
    console.error(error);
    res.status(500).send('Terjadi kesalahan saat mengambil data event.');
  }
}

const update = async (req, res) => {
    const { id } = req.params;
    const { nama_event, start_event, end_event, lokasi, narasumber, poster_url, deskripsi, biaya_registrasi, maks_peserta } = req.body;
    
    try {
        const event = await Events.findByPk(id);
    
        if (!event) {
        return res.status(404).json({ message: 'Event tidak ditemukan.' });
        }
    
        await event.update({ 
            nama_event, 
            start_event, 
            end_event, 
            lokasi, 
            narasumber, 
            poster_url, 
            deskripsi, 
            biaya_registrasi, 
            maks_peserta 
        });
    
        res.json({ message: 'Event berhasil diperbarui.' });
        
    } catch (error) {
        console.error(error);
        res.status(500).send('Terjadi kesalahan saat memperbarui data event.');
    }
}

const destroy = async (req, res) => {
    const { id } = req.params;
    
    try {
        const event = await Events.findByPk(id);
    
        if (!event) {
        return res.status(404).json({ message: 'Event tidak ditemukan.' });
        }
    
        await event.destroy();
    
        res.json({ message: 'Event berhasil dihapus.' });
        
    } catch (error) {
        console.error(error);
        res.status(500).send('Terjadi kesalahan saat menghapus data event.');
    }
}

module.exports = {
  index,
  store,
  show,
  update,
  destroy
};