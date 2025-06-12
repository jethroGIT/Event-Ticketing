const { Sequelize } = require('sequelize');

const sequelize = new Sequelize('event_tiket', 'root', 'password', {
    host: 'localhost',
    dialect: 'mysql',
    define: {
        timestamps: false
    }
});

module.exports = {
    sequelize,
    Sequelize
};