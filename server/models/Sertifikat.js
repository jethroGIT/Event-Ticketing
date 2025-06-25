module.exports = (sequelize, DataTypes) => {
    const Sertifikat = sequelize.define('Sertifikat', {
        id: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            allowNull: false,
            autoIncrement: true,
        },
        id_kehadiran: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        sertifikat_url: {
            type: DataTypes.STRING(255),
            allowNull: false
        } 
    }, {
        tableName: 'sertifikat',
        timestamps: true,
        createdAt: 'created_at',
        updatedAt: 'updated_at',
    });

    return Sertifikat;
};