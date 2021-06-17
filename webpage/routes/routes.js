const express = require('express');

const router = express.Router();

router.get('/', function (request, response) {
	response.render('index');
});

router.get('/admin', function (request, response) {
	response.render('admin');
});

router.get('/adminPanel', function (request, response) {
	response.render('adminPanel');
});

module.exports = router;