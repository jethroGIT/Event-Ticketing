module.exports = (sequelize, DataTypes) => {
  const Tiket = sequelize.define('Tiket', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      allowNull: false,
      autoIncrement: true,
    },
    session_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
    regis_id: {
        type: DataTypes.INTEGER,
        allowNull: false
    }
  }, {
    tableName: 'tiket',
    timestamps: true,
    createdAt: 'created_at',
    updatedAt: 'updated_at',
  });
  
  return Tiket;
};