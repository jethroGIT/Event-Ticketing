const express = require('express');
const router = express.Router();
const { verifyToken } = require('../middleware/verifyToken');

const RolesController = require('../controller/RolesController');
const UserController = require('../controller/UsersController');
const AuthController = require('../controller/AuthController');
const EventsController = require('../controller/EventsController');

router.get('/login', AuthController.index);
router.post('/login', AuthController.login);
router.post('/logout', AuthController.logout);

router.get('/roles', verifyToken, RolesController.index);
router.post('/roles', RolesController.store);
router.get('/roles/:id', RolesController.show);
router.put('/roles/:id', RolesController.update);
router.delete('/roles/:id', RolesController.destroy);

router.get('/users', verifyToken, UserController.index);
router.post('/users', UserController.store);
router.get('/users/:id', UserController.show);
router.put('/users/:id', UserController.update);
router.delete('/users/:id', UserController.destroy);

router.get('/events', verifyToken, EventsController.index);
router.post('/events', EventsController.store);
router.get('/events/:id', EventsController.show);
router.put('/events/:id', EventsController.update);
router.delete('/events/:id', EventsController.destroy);

module.exports = router;