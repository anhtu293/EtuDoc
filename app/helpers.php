<?php

/*
|--------------------------------------------------------------------------
|	Config
|--------------------------------------------------------------------------
*/

// Renvoie la config
function config($query) {
	$config = include_once 'config.php';
	$queryArray = explode(".", $query);
	$prop = $config[$queryArray[0]];
	for ($i=1; $i < count($queryArray); $i++)
		$prop = $prop[$queryArray[$i]];
	return $prop;
}

// Dump and die values
function dd($value) {
	die(var_dump($value));
}


/*
|--------------------------------------------------------------------------
|	Routing
|--------------------------------------------------------------------------
*/

// Obtenir le tableau des paramètres route passés à l'url
function getReqParams() {
	return empty($_GET['route']) ? array('') : explode("/", $_GET['route']);
}

// Donne l'url vers une page
function route($link) {
	return BASE_URL . (($link == '') ? '' : "?route=" . $link);
}

function isRoute($route) {
	return (getReqParams()[0] == $route) ;
}

/*
|--------------------------------------------------------------------------
|	Files and views
|--------------------------------------------------------------------------
*/

function view($view, $variables = array()) {
	// Passage des valeurs pour la vue
	if(!empty($variables))
		foreach ($variables as $var => $value)
			$$var = $value;

	// $content = file_get_contents(getFile("views/$view.php"));
	include getFile("views/template/header.php");
	include getFile("views/$view.php");
	include getFile("views/template/footer.php");
}

// Donne le lien depuis la racine du projet
function getFile($path) {
	// return __DIR__.$path;	
	return config("base_folder").$path;	
}

function asset($link) {
	return BASE_URL ."assets/". $link;
}

function getDB() {
	return oci_connect('na17a006','7lAQoZfA','sme-oracle.sme.utc/nf26');
}