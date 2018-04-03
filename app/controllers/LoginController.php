<?php

function ajouterPersonne()
{
	if (
		   !isset($_POST["email"]) 	|| empty($_POST["email"])
		|| !isset($_POST["nom"]) 	|| empty($_POST["nom"])
		|| !isset($_POST["prenom"])  || empty($_POST["prenom"])
		|| !isset($_POST["role"]) 	|| empty($_POST["role"])
		|| !isset($_POST["login"]) 	|| empty($_POST["login"])
		|| !isset($_POST["password"])|| empty($_POST["password"])
	) {
		$message = "Veuillez remplir tous les champs";
		return view("inscription_form",compact('message'));
	}

	// Nettoyage des valeurs
	$email = 	filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
	$nom = 		filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING);	
	$prenom = 	filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_STRING);
	$role = 	filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);
	$login = 	filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
	$mdp = 		filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

	$BDD = getDB();

	// Verification si email déjà existant dans BDD
	$query = "SELECT email FROM Personne WHERE email='$email'";
	$doublon_mail = oci_parse($BDD,$query);
	oci_execute($doublon_mail);

	if ($row = oci_fetch_array($doublon_mail, OCI_BOTH)) {
		$message = "Cet email existe déjà dans la BDD";
		return view("inscription_form",compact('message'));		
	}

	// Verification si login déjà existant dans BDD
	$query = "SELECT login FROM Interne_UTC WHERE login = '$login'";
	$doublon_login = oci_parse($BDD,$query);
	oci_execute($doublon_login);

	if ($row = oci_fetch_array($doublon_login, OCI_BOTH)) {
		$message = "Ce login existe déjà dans la BDD";
		return view("inscription_form",compact('message'));		
	}

	$query = "INSERT INTO Interne_UTC VALUES ('$email', '$nom', '$prenom', '$login', '$mdp', '$role', 0)";
	$interne = oci_parse($BDD,$query);
	oci_execute($interne);

	$query = "INSERT INTO Personne VALUES ('$email', '$nom', '$prenom')";
	$personne = oci_parse($BDD,$query);
	oci_execute($personne);

	$message = "Vous vous êtes inscrit";
	return view("login_form" , compact('message'));
}

/*
|--------------------------------------------------------------------------
|	Login / Logout
|--------------------------------------------------------------------------
*/

function login() {
	if (isLoggued()) {
		$message = "Vous êtes déjà connecté";
		return view("accueil", compact('message'));
	}

	if (!isset($_POST["login"]) || empty($_POST["login"])) {
		$message = "Veuillez renseignez votre login";
		return view("login_form", compact('message'));
	}

	$BDD = getDB();
	$login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
	$mdp = 	 filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

	// Verification login mdp
	$query = "SELECT login, mdp FROM Interne_UTC WHERE login = '$login' AND mdp = '$mdp'";
	$user = oci_parse($BDD,$query);
	oci_execute($user);
	if (!$row = oci_fetch_array($user, OCI_BOTH)) {
		$message = "Mauvais login / mot de passe";
		return view("login_form", compact('message'));
	}

	// Stockage du login
	$_SESSION["login"] = $login;
	$message = "Vous êtes bien connecté";
	return view("accueil", compact('message'));
}

function logout() {
	unset($_SESSION["login"]);
	$message = "Vous êtes maintenant déconnecté";	
	return view("accueil", compact('message'));
}

/*
|--------------------------------------------------------------------------
|	isLoggued / isAdmin
|--------------------------------------------------------------------------
*/

function isLoggued() {
	return (isset($_SESSION["login"]) && !empty($_SESSION["login"]));
}

function isAdmin() {
	if (!isLoggued())
		return false;

	$BDD = getDB();
	$query = "SELECT login FROM vAdministrateurs WHERE login='".$_SESSION['login']."'";
	$isAdmin = oci_parse($BDD, $query);
	oci_execute($isAdmin);

	if ($row = oci_fetch_array($isAdmin, OCI_BOTH))
		return true;
	else
		return false;
}
