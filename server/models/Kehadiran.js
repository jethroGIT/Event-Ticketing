module.exports = (sequelize, DataTypes) => {
  const Kehadiran = sequelize.define('Kehadiran', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      allowNull: false,
      autoIncrement: true,
    },
    tiket_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
    status: {
        type: DataTypes.STRING(20),
        allowNull: true
    },
    waktu_kehadiran: {
        type: DataTypes.TIME,
        allowNull: true,
    },
  }, {
    tableName: 'kehadiran',
    timestamps: true,
    createdAt: 'created_at',
    updatedAt: 'updated_at',
  });
  
  return Kehadiran;
};