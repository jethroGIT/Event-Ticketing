const { sequelize, Sequelize } = require('../config/mysql_db');
const Users = require('./Users')(sequelize, Sequelize.DataTypes);
const Roles = require('./Roles')(sequelize, Sequelize.DataTypes);
const Events = require('./Events')(sequelize, Sequelize.DataTypes);
console.log(sequelize.models);


Roles.hasMany(Users, { 
  foreignKey: 'role_id',
  as: 'Users' 
});

Users.belongsTo(Roles, { 
  foreignKey: 'role_id',
  as: 'Role'
});

Events.belongsTo(Users, {
  foreignKey: 'created_by',
  as: 'User'
});

  
module.exports = {
  sequelize,  // Koneksi database
  Sequelize,  // Kelas Sequelize
  Roles,
  Users,
  Events       // Model yang sudah di-inject
};