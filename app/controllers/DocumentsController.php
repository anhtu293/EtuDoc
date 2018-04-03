<?php
function ajouterDocument()
{
	if (
		   !isset($_POST["titre"]) 			|| empty($_POST["titre"])
		|| !isset($_POST["contributeurs"]) 	|| empty($_POST["contributeurs"])
		|| !isset($_POST["semestre"]) 		|| empty($_POST["semestre"])
		|| !isset($_POST["fichier"]) 		|| empty($_POST["fichier"])
	) {
		$message = "Veuillez remplir tous les champs.";
		return view('ajoutDocument_form',compact('message'));
	}

	$titre			= filter_input(INPUT_POST, "titre", FILTER_SANITIZE_STRING);
	$semestre		= filter_input(INPUT_POST, "semestre", FILTER_SANITIZE_STRING);
	$fichier		= filter_input(INPUT_POST, "fichier", FILTER_SANITIZE_STRING);
	// $contributeurs	= filter_input(INPUT_POST, "contributeurs", FILTER_SANITIZE_STRING);
	// $contributeurs	= $_POST["contributeurs"];

	$BDD = getDB();
	$login = $_SESSION["login"];
	$lien = "/document/$login/$fichier";

	$query = "
		DECLARE
		    refP REF TInterne_UTC;
		    refC1 REF TPersonne;
		BEGIN
		    SELECT REF(Interne) INTO refP
		    FROM Interne_UTC Interne
		    WHERE login='$login';

		    SELECT REF(Per) INTO refC1
			FROM Personne Per, Interne_UTC Interne
		    WHERE Per.email=Interne.email AND Interne.login='".$login."';

		    INSERT INTO Document VALUES ('$lien', '$titre', SYSDATE, '$semestre',0,refP,CollPersonne(RefPersonne(refC1)),CollLicence());
		END;";

	$doc = oci_parse($BDD, $query);
	oci_execute($doc);

	// Ajout des contributeurs
	foreach ($_POST["contributeurs"] as $contrib) {
		$contrib["email"] 	= filter_var($contrib["email"], FILTER_SANITIZE_EMAIL);
		$contrib["prenom"] 	= filter_var($contrib["prenom"], FILTER_SANITIZE_STRING);
		$contrib["nom"] 	= filter_var($contrib["nom"], FILTER_SANITIZE_STRING);

		// On voit s'il existe déjà
		$query = "SELECT prenom, nom, email FROM Personne WHERE email = '".$contrib['email']."'";
		$personne = oci_parse($BDD, $query);
		oci_execute($personne);

		// Si le contributeur n'existe pas on l'ajoute
		if (!$row = oci_fetch_array($personne, OCI_BOTH)) {
			$query = "INSERT INTO Personne VALUES ('". $contrib['email'] . "','". $contrib['prenom'] ."','". $contrib['nom'] ."')";
			$personne = oci_parse($BDD, $query);
			oci_execute($personne);
		}

		// On l'ajoute en contributeur
		$query = "DECLARE
				refP REF TPersonne;
			BEGIN
				SELECT REF(Per) INTO refP
				FROM Personne Per
				WHERE email='".$contrib['email']."';

				INSERT INTO THE (SELECT d.contributeurs FROM Document d WHERE d.lien='$lien') VALUES (refP);
			END;";
		$majDoc = oci_parse($BDD, $query);
		oci_execute($majDoc);
	}
	foreach ($_POST["licences"] as $licence) {
		// $licence = filter_var($licence, FILTER_SANITIZE_STRING);
		$query = "DECLARE
				refL REF TLicence;
			BEGIN
				SELECT REF(Lic) INTO refL
				FROM Licence Lic
				WHERE nom='$licence';

				INSERT INTO THE (SELECT d.licences FROM Document d WHERE d.lien='$lien') VALUES (refL);
			END;";
		$majDoc = oci_parse($BDD, $query);
		oci_execute($majDoc);
	}

	$message = "Votre document est bien enregistré";
	return view('ajoutDocument_form',compact('message'));
}

function ajouterLicence()
{
	$BDD=getDB();
	if (!isset($_POST["licence"]) || empty($_POST["licence"])){
		$message = 'Rentrez un nom de licence';
		return view('ajoutLicence_form',compact('message'));
	}

	$licence = filter_input(INPUT_POST, "licence", FILTER_SANITIZE_STRING);

	$query = "INSERT INTO Licence VALUES ('$licence')";
	$res = oci_parse($BDD, $query);
	oci_execute($res);

	$message = 'Licence créée';
	return view('ajoutLicence_form',compact('message'));
}

function archiverDocument()
{
	if (isset($_POST["document"]) && !empty($_POST["document"])) {
		$BDD = getDB();
		$document=$_POST["document"];
		$query = "UPDATE Document SET archivage=1 WHERE lien='".$document."'"; 
		$doc = oci_parse($BDD,$query);
		oci_execute($doc);
		$message = 'Document est archivé';
		return view('archiverDocument_form',compact('message'));
	}
	else {
		$message = "Choisissez le document";
		return view('archiverDocument_form',compact('message'));
	}
}
function supprimerDocument()
{
	if (!isset($_POST["document"]) || empty($_POST["document"])){
		$message = "Choisissez un document";
		return view('supprimeDocument_form',compact('message'));
	} else {
		if (isset($_POST["document"]) && !empty($_POST["document"]))
			$lien=$_POST["document"];
		$BDD = getDB();
		$query = "DELETE FROM Document d WHERE d.lien='".$lien."'"; 
		$doc = oci_parse($BDD,$query);
		oci_execute($doc);
		$message = "Le document est supprimé";
		return view('supprimeDocument_form',compact('message'));
	}
}

function getAllDocuments()
{
	$BDD = getDB();

	$query = "SELECT d.titre, d.lien, d.date_publication, d.proprietaire.login, d.proprietaire.prenom, d.proprietaire.nom FROM vNonArchive d";
	$list = oci_parse($BDD, $query);
	oci_execute($list);

	oci_close($BDD);
	return view('liste_documents', compact('list'));
}

function rechercherDocument()
{
	// Filtrage des données
	$TITRE 	  = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_STRING);
	$DATE 	  = filter_input(INPUT_POST, "date", FILTER_SANITIZE_STRING);
	$SEMESTRE = filter_input(INPUT_POST, "semestre", FILTER_SANITIZE_STRING);
	$LICENCE  = filter_input(INPUT_POST, "licence", FILTER_SANITIZE_STRING);
	$P_EMAIL  = filter_input(INPUT_POST, "proprio_email", FILTER_SANITIZE_EMAIL);
	$P_PRENOM = filter_input(INPUT_POST, "proprio_prenom", FILTER_SANITIZE_STRING);
	$P_NOM 	  = filter_input(INPUT_POST, "proprio_nom", FILTER_SANITIZE_STRING);
	$C_EMAIL  = filter_input(INPUT_POST, "contrib_email", FILTER_SANITIZE_EMAIL);
	$C_PRENOM = filter_input(INPUT_POST, "contrib_prenom", FILTER_SANITIZE_STRING);
	$C_NOM 	  = filter_input(INPUT_POST, "contrib_nom", FILTER_SANITIZE_STRING);

	$fromArr = array();
	$whereArr = array();

	// Construction de la requête
	array_push($fromArr, "Document d");

	if (!empty($TITRE))		array_push($whereArr, "d.titre=	'" . $TITRE . "'");
	if (!empty($DATE))		array_push($whereArr, "d.date_publication='" . $DATE . "'");
	if (!empty($SEMESTRE))	array_push($whereArr, "d.semestre='" . $SEMESTRE . "'");

	if (!empty($LICENCE)) {
		array_push($fromArr, "TABLE(d.licences) l");
		array_push($whereArr, "l.nom='" . $LICENCE . "'");
	}
	if (!empty($P_EMAIL) || !empty($P_PRENOM) || !empty($P_NOM)) {
		array_push($fromArr, "TABLE(d.proprietaire) p");
		if (!empty($P_EMAIL))	array_push($whereArr, "p.email='".$P_EMAIL."'");
		if (!empty($P_PRENOM))	array_push($whereArr, "p.prenom='".$P_PRENOM."'");
		if (!empty($P_NOM))		array_push($whereArr, "p.nom='".$P_NOM."'");
	}
	if (!empty($C_EMAIL) || !empty($C_PRENOM) || !empty($C_NOM)) {
		array_push($fromArr, "TABLE(d.contributeurs) c");
		if (!empty($C_EMAIL))	array_push($whereArr, "c.email='".$C_EMAIL."'");
		if (!empty($C_PRENOM))	array_push($whereArr, "c.prenom='".$C_PRENOM."'");
		if (!empty($C_NOM))		array_push($whereArr, "c.nom='".$C_NOM."'");
	}

	// Linéarisation de la requête
	$select = "d.titre, d.lien, d.date_publication, d.semestre, d.archivage, d.proprietaire.login, d.proprietaire.prenom, d.proprietaire.nom";
	$from  = implode(', ', $fromArr);
	$where = implode(', ', $whereArr);
	$fullQuery = "SELECT $select FROM $from WHERE $where";


	$BDD = getDB();
	$documents = oci_parse($BDD, $fullQuery);
	oci_execute($documents);
	oci_close($BDD);

	return view('recherche_result', compact('documents', 'fullQuery'));
}