var express = require('express');
var app = express();
var http = require('http').Server(app);
var path = require('path');
var cookieParser = require('cookie-parser');
var	session = require('express-session');
var io = require('socket.io').listen(http);
var ConnectMongo = require('connect-mongo')(session);
var	mongoose = require('mongoose').connect("mongodb://austincapobianco:fucksluts10@ds037244.mongolab.com:37244/personanexus");

app.set('views', path.join(__dirname, 'views'));
app.engine('html', require('hogan-express'));
app.set('view engine', 'html');
app.use(express.static(path.join(__dirname, 'public'))); 
app.use(cookieParser());

var Connection = require('tedious').Connection;
var SQLconfig = {
	userName: 'austincapobianco',
	password: 'fucksluts',
	server: 'localhost',
	options: {
		database: 'personanexus',
		port: 3306
	}
};

var connection = new Connection(SQLconfig);
connection.on('connect', function(err) {
	if(err){
		console.log(err);
	} else {
// If no error, then good to proceed.
	console.log("Connected");
		//executeStatement();
	};
});


var Request = require('tedious').Request;
var TYPES = require('tedious').TYPES;

function executeStatement() {
    request = new Request("SELECT * FROM personanexus.pGLSQL;", function(err) {
    if (err) {
        console.log(err);}
    });
    var result = "";
    request.on('row', function(columns) {
        columns.forEach(function(column) {
          if (column.value === null) {
            console.log('NULL');
          } else {
            result+= column.value + " ";
          }
        });
        console.log(result);
        result ="";
    });

    request.on('done', function(rowCount, more) {
    console.log(rowCount + ' rows returned');
    });
    connection.execSql(request);
}

// app.get('/', function(req, res){
//   res.render('index', {title:'personanexus'});
// });

// io.sockets.on('connection', function(socket){
//   console.log('a user connected', socket);
//   socket.on('pressedEnter', function(){
//   		console.log('hi');
// 	  	app.get('/', function(req, res){
// 	  res.render('index', {title:'worked'});
// 	});

//   });

// });

http.listen(3000, function(){
  console.log('listening on localhost:3000');
});