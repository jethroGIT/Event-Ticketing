const { sequelize, Sequelize } = require('../config/mysql_db');
const Users = require('./Users')(sequelize, Sequelize.DataTypes);
const Roles = require('./Roles')(sequelize, Sequelize.DataTypes);
const Events = require('./Events')(sequelize, Sequelize.DataTypes);
const EventSession = require('./EventSession')(sequelize, Sequelize.DataTypes);
const Registrasi = require('./Registrasi')(sequelize, Sequelize.DataTypes);
const Pembayaran = require('./Pembayaran')(sequelize, Sequelize.DataTypes);
const Tiket = require('./Tiket')(sequelize, Sequelize.DataTypes);
const Kehadiran = require('./Kehadiran')(sequelize, Sequelize.DataTypes);
const Sertifikat = require('./Sertifikat')(sequelize, Sequelize.DataTypes);
console.log(sequelize.models);


Roles.hasMany(Users, { 
  foreignKey: 'role_id',
  as: 'Users' 
});

Users.belongsTo(Roles, { 
  foreignKey: 'role_id',
  as: 'Role'
});

// ================ //

Events.belongsTo(Users, {
  foreignKey: 'created_by',
  as: 'User'
});

Events.hasMany(EventSession, {
  foreignKey: 'event_id',
  as: 'EventSessions'
});

EventSession.belongsTo(Events, {
  foreignKey: 'event_id',
  as: 'Events'
});

// ================ //

Users.hasMany(Registrasi, {
  foreignKey: 'user_id',
  as: 'Registrasi'
});

Registrasi.belongsTo(Users, {
  foreignKey: 'user_id',
  as: 'User'
});

// ================ //

Registrasi.hasMany(Pembayaran, {
  foreignKey: 'regis_id',
  as: 'Pembayaran'
});

Pembayaran.belongsTo(Registrasi, {
  foreignKey: 'regis_id',
  as: 'Registrasi'
});

// ================ //

Registrasi.hasMany(Tiket, {
  foreignKey: 'regis_id',
  as: 'Tiket'
});

Tiket.belongsTo(Registrasi, {
  foreignKey: 'regis_id',
  as: 'Registrasi'
});

Tiket.belongsTo(EventSession, {
  foreignKey: 'session_id',
  as: 'EventSessions'
})

EventSession.hasMany(Tiket, {
  foreignKey: 'session_id',
  as: 'Tiket'
})

// ================ //

Kehadiran.belongsTo(Tiket, {
  foreignKey: 'tiket_id',
  as: 'Tiket'
});

Tiket.hasOne(Kehadiran, {
  foreignKey: 'tiket_id',
  as: 'Kehadiran'
});

// ================ //

Sertifikat.belongsTo(Kehadiran, {
  foreignKey: 'id_kehadiran',
  as: 'Kehadiran'
});

Kehadiran.hasOne(Sertifikat, {
  foreignKey: 'id_kehadiran',
  as: 'Sertifikat'
});

module.exports = {
  sequelize,  // Koneksi database
  Sequelize,  // Kelas Sequelize
  Roles,
  Users,
  Events,     
  EventSession,
  Registrasi,
  Tiket,
  Pembayaran,
  Kehadiran,
  Sertifikat
};