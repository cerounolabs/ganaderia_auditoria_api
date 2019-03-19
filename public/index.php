<?php
	session_start();

	$http_origin = $_SERVER['HTTP_ORIGIN'];

	if ($http_origin == 'http://auditoria.cerouno.com.py' || $http_origin == 'http://cliente.cerouno.com.py') {
		header("Access-Control-Allow-Origin: '.$http_origin.' ");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

		date_default_timezone_set('America/Asuncion');

		use \Psr\Http\Message\ServerRequestInterface as Request;
		use \Psr\Http\Message\ResponseInterface as Response;

		require __DIR__.'/../../slim/vendor/autoload.php';
		$settings = require __DIR__.'/../src/settings.php';

		$app = new \Slim\App($settings);
		require __DIR__.'/../src/dependencies.php';

		//ROUTES
		require __DIR__.'/../src/routes.php';
		
		$app->run();
	}