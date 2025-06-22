module.exports = (sequelize, DataTypes) => {
  const Pembayaran = sequelize.define('Pembayaran', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      allowNull: false,
      autoIncrement: true,
    },
    regis_id: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    tipe_pembayaran: {
        type: DataTypes.STRING(50),
        allowNull: false
    },
    status_pembayaran: {
        type: DataTypes.STRING(15),
        allowNull: false
    },
    bukti_pembayaran: {
        type:DataTypes.STRING(255),
        allowNull: true
    }
  }, {
    tableName: 'pembayaran',
    timestamps: true,
    createdAt: 'created_at',
    updatedAt: 'updated_at',
  });
  
  return Pembayaran;
};