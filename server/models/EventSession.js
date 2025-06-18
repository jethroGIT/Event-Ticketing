module.exports = (sequelize, DataTypes) => {
  const EventSessions = sequelize.define('EventSessions', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      allowNull: false,
      autoIncrement: true,
    },
    event_id: {
      type: DataTypes.INTEGER,
      allowNull: true
    },
    nama_sesi: {
      type: DataTypes.STRING(100),
      allowNull: true,
    },
    tanggal: {
      type: DataTypes.DATE,
      allowNull: true,
    },
    jam_mulai: {
      type: DataTypes.TIME,
      allowNull: true,
    },
    jam_selesai: {
      type: DataTypes.TIME,
      allowNull: true,
    }
  }, {
    tableName: 'event_session',
    timestamps: true,
    createdAt: 'created_at',
    updatedAt: 'updated_at',
  });

  return EventSessions;
}