const express = require('express');
const router = express.Router();
const RolesController = require('../controller/RolesController');
const UserController = require('../controller/UsersController');
const AuthController = require('../controller/AuthController');
const EventsController = require('../controller/EventsController');

router.get('/roles', RolesController.index);
router.post('/roles', RolesController.store);
router.get('/roles/:id', RolesController.show);
router.put('/roles/:id', RolesController.update);
router.delete('/roles/:id', RolesController.destroy);

router.get('/users', UserController.index);
router.post('/users', UserController.store);
router.get('/users/:id', UserController.show);
router.put('/users/:id', UserController.update);
router.delete('/users/:id', UserController.destroy);

router.get('/events', EventsController.index);
router.post('/events', EventsController.store);

router.get('/login', AuthController.index);
router.post('/login', AuthController.login);
router.get('/events/:id', EventsController.show);
router.put('/events/:id', EventsController.update);
router.delete('/events/:id', EventsController.destroy);

module.exports = router;