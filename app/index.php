<?php
	session_start();
	ob_start();
	
	// Config
	$config = include 'config.php';
	define("DEBUG", $config["debug"]);

	// Clean URI
	$URI = $_SERVER['REQUEST_URI'];
	$cutter = strrpos($URI, $config["app_folder"]) + strlen($config["app_folder"]);

	// URL d'index.php (ex: http://localhost/app/)
	define("BASE_URL", (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' .$_SERVER['HTTP_HOST'] . substr($URI, 0, $cutter));

	// Arguments de l'url (ex: app/arg1/arg2/) : Not working on tuxa
	// $REQ_PARAMS = explode("/", substr($URI, $cutter, strlen($URI)));

	// var_dump(BASE_URL);
	// var_dump($REQ_PARAMS);

	// Helpers
	include 'helpers.php';
	
	// Routes
	include 'routes.php';
	ob_flush();

