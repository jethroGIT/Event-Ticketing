module.exports = (sequelize, DataTypes) => {
  const Events = sequelize.define('Events', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      allowNull: false,
      autoIncrement: true,
    },
    nama_event: {
      type: DataTypes.STRING(100),
      allowNull: false,
    },
    start_event: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    end_event: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    lokasi: {
      type: DataTypes.STRING(100),
      allowNull: true,
    },
    narasumber: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    poster_url: {
        type: DataTypes.STRING(255),
        allowNull: true,
    },
    deskripsi: {
      type: DataTypes.STRING(255),
      allowNull: true,
    },
    biaya_registrasi: {
      type: DataTypes.STRING(11),
      allowNull: true,
    },
    maks_peserta: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
    created_by: {
      type: DataTypes.INTEGER,
      allowNull: true,
    }
  }, {
    tableName: 'events',
    timestamps: true,
    createdAt: 'created_at',
    updatedAt: 'updated_at',
  });

  return Events;
}