<?php 
	// Get Controllers
	include "controllers/LoginController.php";
	include "controllers/DocumentsController.php";

	$REQ_PARAMS = getReqParams();
	switch ($REQ_PARAMS[0]) {
		case '':
			view('accueil'); break;

		// ===== LOGIN, LOGOUT, INSCRIPTION
		case 'login':
			if ($_SERVER['REQUEST_METHOD'] === 'POST')
				login();
			else
				view('login_form');
			break;		
		case 'logout':
			logout(); break;
        case 'inscription':
			if ($_SERVER['REQUEST_METHOD'] === 'POST')
				ajouterPersonne();
			else
				view('inscription_form');
			break;	

		// ===== FONCTIONNALITÉS PUBLIQUES
		case 'documents':
			getAllDocuments(); break;
		case 'rechercher':
			if ($_SERVER['REQUEST_METHOD'] === 'POST')
				rechercherDocument();
			else
				view('recherche_form');
			break;


		// ===== FONCTIONNALITÉS UTILISATEUR
		case 'user':
			if (!isLoggued()) {		// Vérification si connecté
				view('login_form'); break;
			}
			switch ($REQ_PARAMS[1]) {
				case 'ajouterDocument' : 
					if ($_SERVER['REQUEST_METHOD'] === 'POST')
						ajouterDocument();
					else
						view('ajoutDocument_form');
					break;
				case 'supprimerDocument' : 
					if ($_SERVER['REQUEST_METHOD'] === 'POST')
						supprimerDocument();
					else
						view('supprimeDocument_form');
					break;
				default:
					view("errors/404"); break;
			}
			break;


		// ===== Fonctionnalités admin
		case 'admin':
			if (!isAdmin()) {	// Vérification si admin
				view("errors/503"); break;
			}

			switch ($REQ_PARAMS[1]) {
				case 'archiverDocument' : 
					if ($_SERVER['REQUEST_METHOD'] === 'POST')
						archiverDocument();
					else
						view('archiverDocument_form');
					break;
								case 'ajouterLicence' :
					if ($_SERVER['REQUEST_METHOD'] === 'POST')
						ajouterLicence();
					else
						view('ajoutLicence_form');
					break;
				
				default:
					view("errors/404"); break;
			}
			break;

		default:
			view("errors/404"); break;
	}
