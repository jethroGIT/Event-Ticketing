const express = require('express');
const router = express.Router();
const { verifyToken } = require('../middleware/verifyToken');

const RolesController = require('../controller/RolesController');
const UserController = require('../controller/UsersController');
const AuthController = require('../controller/AuthController');
const EventsController = require('../controller/EventsController');
const EventSessionController = require('../controller/EventSessionController');
const RegistrasiController = require('../controller/RegistrasiController');

router.get('/login', AuthController.index);
router.post('/login', AuthController.login);
router.post('/logout', AuthController.logout);

router.get('/roles', verifyToken, RolesController.index);
router.post('/roles', RolesController.store);
router.get('/roles/:id', verifyToken, RolesController.show);
router.put('/roles/:id', RolesController.update);
router.delete('/roles/:id', RolesController.destroy);

router.get('/users', verifyToken, UserController.index);
router.post('/users', UserController.store);
router.get('/users/:id', UserController.show);
router.put('/users/:id', UserController.update);
router.delete('/users/:id', UserController.destroy);

router.get('/events', EventsController.index);
router.post('/events', EventsController.store);
router.get('/events/:id', EventsController.show);
router.put('/events/:id', EventsController.update);
router.delete('/events/:id', EventsController.destroy);

router.get('/events/:event_id/sessions', EventSessionController.getByEventId);
router.post('/events/:event_id/sessions', EventSessionController.store);
router.get('/events/sessions/:id', EventSessionController.show);
router.put('/events/sessions/:id', EventSessionController.update);
router.delete('/events/sessions/:id', EventSessionController.destroy);

router.get('/registrasi', RegistrasiController.EventTersedia);
router.post('/registrasi', RegistrasiController.RegistrasiEvent);
router.get('/registrasi/event/:event_id', RegistrasiController.Konfirmasi);
router.post('/registrasi/konfirmasi', RegistrasiController.konfirmasiPendaftaran);

module.exports = router;