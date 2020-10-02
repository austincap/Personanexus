module.exports = function(express, app, title, config){
	var router = express.Router();

	//default route
	router.get('/', function(req, res, next){
		res.render('index', {title:title, 'Welcome to personanexus'});
	})

	router.get('/submitpersona', securePages, function(req, res, next){
		res.render('submitpersona', {title: 'Submit persona', config:config})
	})

	router.get('/viewresults', securePages, function(req, res, next){
		res.render('viewresults', {title: 'View results', config:config})
	})

	router.get('/contributeopinions', securePages, function(req, res, next){
		res.render('contributeopinions', {title: 'Contribute opinions', config:config})
	})


	router.get
	app.use('/', router);
}