/*var mysql = require('mysql');
var express = require('express');
var session = require('express-session');
var bodyParser = require('body-parser');
var path = require('path');

var connection = mysql.createConnection({
	host: "localhost",
	user: "root",
	password: "",
	database: "iotamp_db"
});

var app = express();
app.use(session({
	secret: 'secret',
	resave: true,
	saveUninitialized: true
}));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, 'css')));

app.get('/', function (request, response) {
	response.sendFile(path.join(__dirname + '/index.html'));
});

app.get('/admin', function (request, response) {
	response.sendFile(path.join(__dirname + '/admin.html'));
});

app.get('/adminPanel', function (request, response) {
	response.sendFile(path.join(__dirname + '/adminPanel.html'));
});

module.exports = app;

app.post('/auth', function (request, response) {
	var username = request.body.username;
	var password = request.body.password;
	if (username && password) {
		connection.query('SELECT * FROM users WHERE user_name = ? AND password = ?', [username, password], function (error, results, fields) {

			if (results.length > 0) {
				request.session.loggedin = true;
				request.session.username = username;
				response.redirect('/adminPanel');
			} else {
				response.send('Incorrect username/password!');
			}
			response.end();
		});
	} else {
		response.send('Please enter Username and Password!');
		response.end();
	}
});

app.get('/adminPanel', function (request, response) {
	if (request.session.loggedin) {
		response.render("adminPanel");
	} else {
		response.send('Please login to view this page!');
	}
	response.end();
});

app.listen(3000);

function createSensors() {
	let query = "SELECT id FROM sensors";
}

module.exports = {
	createSensors: createSensors,
}

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "X34G8gjNabFkcq",
    database: "iotamp_db"
});*/
// retrieve purchased iotas and display in header
function showPurchased() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("timer").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","./functions/dataService.php",true);
    xmlhttp.send();
}

function changeItem() {
    document.getElementById("fireFly").style.color = '#00F4C8';
    document.getElementById("trinityLogo").style.backgroundImage = "url(images/iota-miota-logo-blue.png)";
}// функция, которая сработает при наведении.
//она означает - выбрать элемент к Id у которого надо что-то изменить.
// когда в скобки где написано one-two добавите Id своего элемента
function rechangeItem() {
    document.getElementById("fireFly").style.color = '#FFFFFF';
    document.getElementById("trinityLogo").style.backgroundImage = "url(images/iota-miota-logo.png)";
}// тут всё также. но наобарот. протсес происходящий про отводе курсора.

function show(state) {
    document.getElementById('popUp').style.display = state;
    document.getElementById('gray').style.display = state;
}

function show2(state) {
    document.getElementById('popUp2').style.display = state;
    document.getElementById('gray2').style.display = state;
}

function show3(state) {
	document.getElementById('transactPopUp').style.display = state;
	document.getElementById('gray3').style.display = state;
}

function showAddSensor(state) {
	document.getElementById('popUpAddSensor').style.display = state;
	document.getElementById('grayAddSensor').style.display = state;
}

function goToPage(page) {
    window.location = page;
}

