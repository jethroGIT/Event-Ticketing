module.exports = (sequelize, DataTypes) => {
  const Users = sequelize.define('Users', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      allowNull: false,
      autoIncrement: true,
    },
    role_id: {
        type: DataTypes.INTEGER,
        allowNull: true,
    },
    email: {
        type: DataTypes.STRING(100),
        allowNull: true,
    },
    password: {
        type: DataTypes.STRING(20),
        allowNull: true,
    },
    nama: {
        type: DataTypes.STRING(100),
        allowNull: true,
    },
    alamat: {
        type: DataTypes.STRING(255),
        allowNull: true,
    },
    no_tlp: {
        type: DataTypes.STRING(15),
        allowNull: true,
    },
    status: {
        type: DataTypes.STRING(13),
        allowNull: true,
    },
  }, {
    tableName: 'users',
    timestamps: true,
    createdAt: 'created_at',
    updatedAt: 'updated_at',
  });
  
  return Users;
};