-- SUPPRESSION SI BESOIN, CREATION ET SELECTION DU SCHEMA
DROP SCHEMA IF EXISTS Groupe10 CASCADE;
CREATE SCHEMA Groupe10;
SET search_path TO Groupe10;

\echo '\n\n*** INITIALISATION DES TABLES ***\<n></n>'

	\echo '|-Suppression des tables...\n' 

	DROP TABLE IF EXISTS Classifie;
	DROP TABLE IF EXISTS Comporte;
	DROP TABLE IF EXISTS Contribue;
	DROP TABLE IF EXISTS Document;

	DROP TABLE IF EXISTS Interne_UTC;
	DROP TABLE IF EXISTS Personne;

	DROP TABLE IF EXISTS Licence;
	DROP TABLE IF EXISTS Categorie;
	DROP TABLE IF EXISTS UV;
	DROP TABLE IF EXISTS Type;


	\echo '\n|-Creation des tables...\n'

	CREATE TABLE Type(
		intitule VARCHAR(20) PRIMARY KEY
	);

	CREATE TABLE UV(
		code CHAR(5) PRIMARY KEY,
		description VARCHAR(200) UNIQUE NOT NULL
	);

	CREATE TABLE Categorie(
		nom VARCHAR(20) PRIMARY KEY
	);

	CREATE TABLE Licence(
		nom VARCHAR(20) PRIMARY KEY
	);

	CREATE TABLE Personne(
		id SERIAL PRIMARY KEY,
		mail CHAR(200) NOT NULL UNIQUE CHECK (mail LIKE '%@%'),
		nom VARCHAR(20) NOT NULL,
		prenom VARCHAR(20) NOT NULL
	);

	CREATE TABLE Interne_UTC(
		login CHAR(8) PRIMARY KEY,
		is_admin BOOLEAN NOT NULL,
		role CHAR(10) NOT NULL,
		personne INTEGER REFERENCES Personne(id),
		CHECK (role = 'etudiant' OR role = 'enseignant')
	);

	CREATE TABLE Document(
		id SERIAL PRIMARY KEY,
		titre VARCHAR(20) NOT NULL,
		semestre CHAR(3) NOT NULL,
		date_publication DATE NOT NULL,
		archivage BOOLEAN NOT NULL,
		lien VARCHAR(200) UNIQUE NOT NULL,
		type VARCHAR(20) NOT NULL REFERENCES Type(intitule),
		uv CHAR(5) NOT NULL REFERENCES UV(code),
		proprietaire CHAR(8) NOT NULL REFERENCES Interne_UTC(login)   
	);

	CREATE TABLE Contribue(
		document INTEGER REFERENCES Document(id),
		personne INTEGER REFERENCES Personne(id),
		PRIMARY KEY(document, personne)
	);
	-- TODO

	CREATE TABLE Classifie(
		document INTEGER REFERENCES Document(id),
		categorie VARCHAR(20) REFERENCES Categorie(nom),
		PRIMARY KEY(document,categorie)
	);
	-- TODO

	CREATE TABLE Comporte(
		document INTEGER REFERENCES Document(id),
		licence VARCHAR(20) REFERENCES Licence(nom),
		PRIMARY KEY(document,licence)
	);
	-- TODO

\echo '\n\n*** FIN DE L''INITIALISATION DES TABLES ***'


\echo '\n\n*** REMPLISSAGE DES TABLES  ***\n'

	/* Remplissage type */
	\echo '|-Remplissage de la table Type ...\n'
	INSERT INTO Type VALUES ('Rapport de stage');
	INSERT INTO Type VALUES ('Rapport de TX');
	INSERT INTO Type VALUES ('Rapport de PR');
	INSERT INTO Type VALUES ('Projet d''UV');
	INSERT INTO Type VALUES ('Correction');

	/* Remplissage UVs */
	\echo '\n|-Remplissage de la table UV ...\n'
	INSERT INTO UV VALUES ('NA17', 'Conception de bases de données relationnelles et non-relationnelles (en autonomie)');
	INSERT INTO UV VALUES ('HT04', 'Théories technologiques et histoire des savoirs techniques');
	INSERT INTO UV VALUES ('TMI03', 'Ergonomie des situations de travail (apprentissage)');
	INSERT INTO UV VALUES ('TN09', 'Stage assistant.e-ingenieur.e');
	INSERT INTO UV VALUES ('LO01', 'Bases de la programmation');


	/* Remplissage Licences */
	\echo '\n|-Remplissage de la table Licence ...\n'
	INSERT INTO Licence VALUES ('CC BY-SA 4.0');
	INSERT INTO Licence VALUES ('GNU GPL');
	INSERT INTO Licence VALUES ('GFDL');


	/* Remplissage catégories*/
	\echo '\n|-Remplissage de la table Categorie ...\n'
	INSERT INTO Categorie VALUES ('Sciences');
	INSERT INTO Categorie VALUES ('Philosophie');
	INSERT INTO Categorie VALUES ('Mathématiques');
	INSERT INTO Categorie VALUES ('Informatique');
	INSERT INTO Categorie VALUES ('Biologie');
	INSERT INTO Categorie VALUES ('Mécanique');
	INSERT INTO Categorie VALUES ('Histoire');
	INSERT INTO Categorie VALUES ('Stage');
	INSERT INTO Categorie VALUES ('Autre');


	/* Remplissage Personne*/
	\echo '\n|-Remplissage de la table Personne ...\n'
	INSERT INTO Personne VALUES (DEFAULT, 'hapotter@gmail.com','harry','potter');
	INSERT INTO Personne VALUES (DEFAULT, 'jenkings@laposte.net','luroy','jenkings');
	INSERT INTO Personne VALUES (DEFAULT, 'rypotter@poudlard.org','harry','potter');
	INSERT INTO Personne VALUES (DEFAULT, 'jtiberla@gmail.com','justin','tiberlake');
	INSERT INTO Personne VALUES (DEFAULT, 'pisknemo@gmail.com','pisckle','nemo');
	INSERT INTO Personne VALUES (DEFAULT, 'safredon@lacomptee.com','sacker','fredon');
	INSERT INTO Personne VALUES (DEFAULT, 'smegolum@lacomptee.com','smeagold','golum');
	INSERT INTO Personne VALUES (DEFAULT, 'chupika1@pokemon.org','chu','pika');
	INSERT INTO Personne VALUES (DEFAULT, 'alexandre.brasseur@etu.utc.fr', 'Brasseur', 'Alexandre');
	INSERT INTO Personne VALUES (DEFAULT, 'eva.sodki@etu.utc.fr', 'Sodki', 'Eva');
	INSERT INTO Personne VALUES (DEFAULT, 'melanie.henaux@etu.utc.fr', 'Hénaux', 'Mélanie');
	INSERT INTO Personne VALUES (DEFAULT, 'aurelien.beranger@etu.utc.fr', 'Béranger', 'Aurélien');
	INSERT INTO Personne VALUES (DEFAULT, 'veronique.hedou@utc.fr', 'Hédou', 'Véronique');
	INSERT INTO Personne VALUES (DEFAULT, 'stephane.crozat@utc.fr', 'Crozat', 'Stéphane');
	INSERT INTO Personne VALUES (DEFAULT, 'guillaume.carnino@utc.fr', 'Carnino', 'Guillaume');



	/*Remplissage Interne_UTC*/
	\echo '\n|-Remplissage de la table Interne_UTC ...\n'
	INSERT INTO Interne_UTC VALUES ('abrasseu', true, 'etudiant', (SELECT id FROM Personne WHERE mail='alexandre.brasseur@etu.utc.fr'));
	INSERT INTO Interne_UTC VALUES ('esodkie', false, 'etudiant', (SELECT id FROM Personne WHERE mail='eva.sodki@etu.utc.fr'));
	INSERT INTO Interne_UTC VALUES ('henauxme', false, 'etudiant', (SELECT id FROM Personne WHERE mail='melanie.henaux@etu.utc.fr'));
	INSERT INTO Interne_UTC VALUES ('aberange', false, 'etudiant', (SELECT id FROM Personne WHERE mail='aurelien.beranger@etu.utc.fr'));
	INSERT INTO Interne_UTC VALUES ('verhedou', false, 'enseignant', (SELECT id FROM Personne WHERE mail='veronique.hedou@utc.fr'));
	INSERT INTO Interne_UTC VALUES ('stcrozat', true, 'enseignant', (SELECT id FROM Personne WHERE mail='stephane.crozat@utc.fr'));
	INSERT INTO Interne_UTC VALUES ('gcarnino', false, 'enseignant', (SELECT id FROM Personne WHERE mail='guillaume.carnino@utc.fr'));


	/* Remplissage de Document */
	\echo '\n|-Remplissage de la table Document ...\n'
	INSERT INTO Document VALUES (DEFAULT, 'rendu TN09 ','A15','2015-10-05', false, '/document/abrasseu/rendu_TN09.pdf','Rapport de stage','TN09','abrasseu');
	INSERT INTO Document VALUES (DEFAULT, 'memoire HT04', 'A16', '2017-01-05', false, '/document/aberange/memoire_HT04.pdf', 'Projet d''UV','HT04', 'aberange');
	INSERT INTO Document VALUES (DEFAULT, 'rendu LO01','A14','2014-05-20',true,'/document/aberange/rendu_LO01.pdf','Projet d''UV','LO01','aberange');
	INSERT INTO Document VALUES (DEFAULT, 'projet NA17', 'A14', '2014-11-18', false, '/document/sodkie/projetNA17.pdf','Projet d''UV', 'NA17', 'esodkie');
	INSERT INTO Document VALUES (DEFAULT, 'correctionFinal', 'A12', '2012-12-25', true, '/document/gcarnino/correctionFinal.otf','Correction', 'HT04', 'gcarnino');

	-- Vue permettant de récupérer l'id d'un interne à partir de son login
	CREATE VIEW vInterne AS
		(SELECT * FROM Interne_UTC INNER JOIN Personne ON Interne_UTC.personne = Personne.id); 


	\echo '\n|-Remplissage de la table Contribue ...\n'
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/abrasseu/rendu_TN09.pdf'),
								  (SELECT id FROM vInterne WHERE login='abrasseu'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/aberange/memoire_HT04.pdf'),
								  (SELECT id FROM vInterne WHERE login='aberange'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/aberange/rendu_LO01.pdf'),
								  (SELECT id FROM vInterne WHERE login='aberange'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/sodkie/projetNA17.pdf'),
								  (SELECT id FROM vInterne WHERE login='esodkie'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/gcarnino/correctionFinal.otf'),
								  (SELECT id FROM vInterne WHERE login='gcarnino'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/abrasseu/rendu_TN09.pdf'),
								  (SELECT id FROM vInterne WHERE login='stcrozat'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/abrasseu/rendu_TN09.pdf'),
								  (SELECT id FROM vInterne WHERE login='henauxme'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/gcarnino/correctionFinal.otf'),
								  (SELECT id FROM vInterne WHERE login='henauxme'));
	INSERT INTO Contribue VALUES ((SELECT id FROM Document WHERE lien='/document/gcarnino/correctionFinal.otf'),
								  (SELECT id FROM vInterne WHERE login='esodkie'));

	\echo '\n|-Remplissage de la table Classifie ...\n'
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/abrasseu/rendu_TN09.pdf'), 	'Stage');
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/abrasseu/rendu_TN09.pdf'), 	'Informatique');
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/aberange/memoire_HT04.pdf'), 	'Histoire');
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/aberange/memoire_HT04.pdf'), 	'Sciences');
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/aberange/memoire_HT04.pdf'), 	'Philosophie');
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/aberange/rendu_LO01.pdf'), 	'Informatique');
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/sodkie/projetNA17.pdf'), 		'Informatique');
	INSERT INTO Classifie VALUES ((SELECT id FROM Document WHERE lien='/document/gcarnino/correctionFinal.otf'),'Autre');

	\echo '\n|-Remplissage de la table Comporte ...\n'
	INSERT INTO Comporte VALUES((SELECT id FROM Document WHERE lien='/document/abrasseu/rendu_TN09.pdf'), 'CC BY-SA 4.0');
	INSERT INTO Comporte VALUES((SELECT id FROM Document WHERE lien='/document/aberange/memoire_HT04.pdf'), 'GNU GPL');
	INSERT INTO Comporte VALUES((SELECT id FROM Document WHERE lien='/document/aberange/rendu_LO01.pdf'), 'GFDL');
	INSERT INTO Comporte VALUES((SELECT id FROM Document WHERE lien='/document/sodkie/projetNA17.pdf'), 'CC BY-SA 4.0');
	INSERT INTO Comporte VALUES((SELECT id FROM Document WHERE lien='/document/sodkie/projetNA17.pdf'), 'GFDL');
	INSERT INTO Comporte VALUES((SELECT id FROM Document WHERE lien='/document/gcarnino/correctionFinal.otf'), 'GFDL');

\echo '\n\n*** FIN DU REMPLISSAGE DES TABLES ***\n'


\echo '\n\n*** CREATION DES VUES ***\n'

	-- Vues liées à l'héritage
	CREATE VIEW vAdministrateurs AS
		SELECT login FROM Interne_UTC WHERE is_admin=true;

	CREATE VIEW vEtudiants AS 
		SELECT login FROM Interne_UTC WHERE role='etudiant';
		
	CREATE VIEW vEnseignants AS 
		SELECT login FROM Interne_UTC WHERE role='enseignant';
		
	-- Vues liées aux document
	CREATE VIEW vNonArchive AS
		SELECT * FROM Document WHERE archivage=false;

	CREATE VIEW vArchives AS
		SELECT * FROM Document WHERE archivage=true;
		
\echo '\n\n*** FIN DE LA CREATION DES VUES ***\n'


\echo '\n\n*** AFFICHAGE DES DONNEES ***\n'

\echo '\n\n|-Login et mail des Administrateurs\n'
SELECT login, mail FROM vAdministrateurs;

\echo '\n\n|-Login et mail des Administrateurs\n'
SELECT login, mail FROM vAdministrateurs;

SELECT * FROM Document INNER JOIN Type ON Document.type=Type.intitule AND Document.type='Correction';

