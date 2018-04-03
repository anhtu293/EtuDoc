
DROP VIEW vAdministrateurs;
DROP VIEW vEtudiants;
DROP VIEW vEnseignants;
DROP VIEW vNonArchive;
DROP VIEW vArchives;

DROP TABLE Document;
DROP TABLE Licence;
DROP TABLE Personne;
DROP TABLE Interne_UTC;

DROP TYPE TInterne_UTC;
DROP TYPE CollPersonne;
DROP TYPE RefPersonne;
DROP TYPE TPersonne;
DROP TYPE CollLicence;
DROP TYPE RefLicence;
DROP TYPE TLicence;

/*création de type et table de Licence*/
CREATE OR REPLACE TYPE TLicence AS OBJECT (
    nom varchar2(15)
);
/
CREATE TABLE Licence OF TLicence (
    PRIMARY KEY (nom)
);
/
CREATE OR REPLACE TYPE RefLicence AS OBJECT (
    refLicence REF TLicence
);
/
CREATE OR REPLACE TYPE CollLicence AS TABLE OF RefLicence;
/
/*création de type et table de Personne*/
CREATE OR REPLACE TYPE  TPersonne AS OBJECT (
    email varchar2(50),
    nom varchar2(30),
    prenom varchar2(30)
) NOT FINAL;
/

CREATE TABLE Personne OF TPersonne (
    PRIMARY KEY(email),
    CHECK (email LIKE '%@%')
);
/

CREATE OR REPLACE TYPE RefPersonne AS OBJECT (
    refPersonne REF TPersonne
);
/
CREATE OR REPLACE TYPE CollPersonne AS TABLE OF RefPersonne;
/

/*création de type et table Interne_UTC*/
CREATE OR REPLACE TYPE TInterne_UTC UNDER TPersonne (
    login varchar2(8),
    mdp varchar2(30),
    rol varchar2(10),
    is_admin number(1)
);
/
CREATE TABLE Interne_UTC OF TInterne_UTC(
    PRIMARY KEY (login),
    UNIQUE (email),
    CHECK (rol IN ('etudiant', 'enseignant')),
    is_admin NOT NULL,
    mdp NOT NULL,
    CHECK (is_admin=1 OR is_admin=0)
);
/
/*création de type et table de Document*/
CREATE TABLE Document (
    lien varchar2(100) PRIMARY KEY,
    titre varchar2(50),
    date_publication date,
    semestre CHAR(3),
    archivage number(1),
    proprietaire REF TInterne_UTC,
    contributeurs CollPersonne,
    licences CollLicence,
    CHECK (archivage=1 OR archivage=0),
    SCOPE FOR (proprietaire) IS Interne_UTC
) NESTED TABLE contributeurs STORE AS Document_contributeurs
 NESTED TABLE licences STORE AS Document_licences;



/* Remplissage Personnes*/
INSERT INTO Personne VALUES ('hapotter@gmail.com','harry','potter');
INSERT INTO Personne VALUES ('jenkings@laposte.net','luroy','jenkings');
INSERT INTO Personne VALUES ('rypotter@poudlard.org','harry','potter');
INSERT INTO Personne VALUES ('jtiberla@gmail.com','justin','tiberlake');
INSERT INTO Personne VALUES ('pisknemo@gmail.com','pisckle','nemo');
INSERT INTO Personne VALUES ('safredon@lacomptee.com','sacker','fredon');
INSERT INTO Personne VALUES ('smegolum@lacomptee.com','smeagold','golum');
INSERT INTO Personne VALUES ('chupika1@pokemon.org','chu','pika');
INSERT INTO Personne VALUES ('alexandre.brasseur@etu.utc.fr', 'Brasseur', 'Alexandre');
INSERT INTO Personne VALUES ('eva.sodki@etu.utc.fr', 'Sodki', 'Eva');
INSERT INTO Personne VALUES ('melanie.henaux@etu.utc.fr', 'Hénaux', 'Mélanie');
INSERT INTO Personne VALUES ('aurelien.beranger@etu.utc.fr', 'Béranger', 'Aurélien');
INSERT INTO Personne VALUES ('veronique.hedou@utc.fr', 'Hédou', 'Véronique');
INSERT INTO Personne VALUES ('stephane.crozat@utc.fr', 'Crozat', 'Stéphane');
INSERT INTO Personne VALUES ('guillaume.carnino@utc.fr', 'Carnino', 'Guillaume');

/*Remplissage Interne_UTC*/
INSERT INTO Interne_UTC VALUES ('alexandre.brasseur@etu.utc.fr',(SELECT nom FROM Personne WHERE email='alexandre.brasseur@etu.utc.fr'),(SELECT prenom FROM Personne WHERE email='alexandre.brasseur@etu.utc.fr'),'abrasseu','12345678','etudiant',0);
INSERT INTO Interne_UTC VALUES ('eva.sodki@etu.utc.fr',(SELECT nom FROM Personne WHERE email='eva.sodki@etu.utc.fr'),(SELECT prenom FROM Personne WHERE email='eva.sodki@etu.utc.fr'),'esodkie','12345678','etudiant',1);
INSERT INTO Interne_UTC VALUES ('melanie.henaux@etu.utc.fr', (SELECT nom FROM Personne WHERE email='melanie.henaux@etu.utc.fr'),(SELECT prenom FROM Personne WHERE email='melanie.henaux@etu.utc.fr'),'henauxme','12345678','etudiant',0);
INSERT INTO Interne_UTC VALUES ('aurelien.beranger@etu.utc.fr',(SELECT nom FROM Personne WHERE email='aurelien.beranger@etu.utc.fr'),(SELECT prenom FROM Personne WHERE email='aurelien.beranger@etu.utc.fr'),'aberange','12345678','etudiant',0);
INSERT INTO Interne_UTC VALUES ('veronique.hedou@utc.fr', (SELECT nom FROM Personne WHERE email='veronique.hedou@utc.fr'),(SELECT prenom FROM Personne WHERE email='veronique.hedou@utc.fr'), 'verhedou','12345678','enseignant',0);
INSERT INTO Interne_UTC VALUES ('stephane.crozat@utc.fr',(SELECT nom FROM Personne WHERE email='stephane.crozat@utc.fr'),(SELECT prenom FROM Personne WHERE email='stephane.crozat@utc.fr'),'stcrozat', '12345678','enseignant',1);
INSERT INTO Interne_UTC VALUES ('guillaume.carnino@utc.fr',(SELECT nom FROM Personne WHERE email='guillaume.carnino@utc.fr'),(SELECT prenom FROM Personne WHERE email='guillaume.carnino@utc.fr'),'gcarnino', '12345678','enseignant',0);

/*Remplissage de Licence*/
INSERT INTO Licence VALUES ('CC BY-SA 4.0');
INSERT INTO Licence VALUES ('GNU GPL');
INSERT INTO Licence VALUES ('GFDL');

/* Remplissage de Document */
DECLARE
    refP REF TInterne_UTC;
    refC1 REF TPersonne;
    refC2 REF TPersonne;
    refC3 REF TPersonne;
    refL REF TLicence;

BEGIN
    SELECT REF(Interne) INTO refP
    FROM Interne_UTC Interne
    WHERE login='abrasseu';

    SELECT REF(Per) INTO refC1
    FROM Personne Per
    WHERE email='alexandre.brasseur@etu.utc.fr';

    SELECT REF(Per) INTO refC2
    FROM Personne Per
    WHERE email='stephane.crozat@utc.fr';

    SELECT REF(Per) INTO refC3
    FROM Personne Per
    WHERE email='melanie.henaux@etu.utc.fr';

    SELECT REF(Lic) INTO refL
    FROM Licence Lic
    WHERE nom='CC BY-SA 4.0';

    INSERT INTO Document VALUES ('/document/abrasseu/rendu_TN09.pdf', 'rendu TN09',TO_DATE('2015/10/05','YYYY/MM/DD'),'A15',0,refP,CollPersonne(RefPersonne(refC1),RefPersonne(refC2),RefPersonne(refC3)),CollLicence(RefLicence(refL)));
END;
/

DECLARE
    refP REF TInterne_UTC;
    refC1 REF TPersonne;
    refL REF TLicence;

BEGIN
    SELECT REF(Interne) INTO refP
    FROM Interne_UTC Interne
    WHERE login='aberange';

    SELECT REF(Per) INTO refC1
    FROM Personne Per
    WHERE email='aurelien.beranger@etu.utc.fr';

    SELECT REF(Lic) INTO refL
    FROM Licence Lic
    WHERE nom='GNU GPL';

    INSERT INTO Document VALUES ('/document/aberange/memoire_HT04.pdf', 'memoire HT04',TO_DATE('2017/01/05','YYYY/MM/DD'), 'A16',0,refP,CollPersonne(RefPersonne(refC1)),CollLicence(RefLicence(refL)));

END;
/
DECLARE
    refP REF TInterne_UTC;
    refC1 REF TPersonne;
    refL REF TLicence;

BEGIN
    SELECT REF(Interne) INTO refP
    FROM Interne_UTC Interne
    WHERE login='aberange';

    SELECT REF(Per) INTO refC1
    FROM Personne Per
    WHERE email='aurelien.beranger@etu.utc.fr';

    SELECT REF(Lic) INTO refL
    FROM Licence Lic
    WHERE nom='GFDL';

INSERT INTO Document VALUES ('/document/aberange/rendu_LO01.pdf', 'rendu LO01',TO_DATE('2014/05/20','YYYY/MM/DD'),'A14',1,refP,collPersonne(RefPersonne(refC1)),CollLicence(RefLicence(refL)));
END;
/

DECLARE
    refP REF TInterne_UTC;
    refC1 REF TPersonne;
    refL REF TLicence;

BEGIN
    SELECT REF(Interne) INTO refP
    FROM Interne_UTC Interne
    WHERE login='esodkie';

    SELECT REF(Per) INTO refC1
    FROM Personne Per
    WHERE email='eva.sodki@etu.utc.fr';

    SELECT REF(Lic) INTO refL
    FROM Licence Lic
    WHERE nom='CC BY-SA 4.0';

    INSERT INTO Document VALUES ('/document/sodkie/projetNA17.pdf', 'projet NA17',TO_DATE('2014/11/18','YYYY/MM/DD'),'A14', 0, refP,CollPersonne(RefPersonne(refC1)),CollLicence(RefLicence(refL)));
END;
/



/* Vues liées à l'héritage */

CREATE VIEW vAdministrateurs AS
    SELECT login,nom,prenom,email FROM Interne_UTC WHERE is_admin=1;

CREATE VIEW vEtudiants AS
    SELECT login,nom,prenom,email FROM Interne_UTC WHERE rol='etudiant';

CREATE VIEW vEnseignants AS
    SELECT login,nom,prenom,email FROM Interne_UTC WHERE rol='enseignant';
/* Vues liées aux document */
CREATE VIEW vNonArchive AS
    SELECT * FROM Document WHERE archivage=0;

CREATE VIEW vArchives AS
    SELECT * FROM Document WHERE archivage=1;


/* REQUETES DE TEST */

/*affichage du nom, prenom et login du proprietaire du document nommé 'projet NA17'*/
SELECT d.proprietaire.login, d.proprietaire.nom, d.proprietaire.prenom
FROM document d
WHERE d.TITRE='projet NA17';

/*affichage de l'email et du nom des contributeurs du document nommé 'rendu LO01' */
SELECT c.refPersonne.email,c.refPersonne.nom
FROM document d, table(d.contributeurs) c
WHERE d.titre='rendu LO01';

/*affichage du titre, de la date de publication et de l'état de document qui est déposé par une personne ayant pour login abrasseu*/
SELECT d.titre,d.date_publication,d.archivage
FROM document d
WHERE d.proprietaire.login='abrasseu';

/*affichage du titre, de la date de publication et du nom du proprietaire des documents auxquels a contribué la personne ayant pour email stephane.crozat@utc.fr */
SELECT d.titre, d.date_publication,d.proprietaire.nom
FROM document d, table(d.contributeurs) c
WHERE c.refPersonne.email='stephane.crozat@utc.fr';

/* Affiche le nom et le propriétaire des documents déposés sous licence CC BY-SA 4.0*/
SELECT d.titre, d.proprietaire.nom FROM document d, Licence l
WHERE l.nom ='CC BY-SA 4.0' ;

/* Affiche les documents rédigés en A14 */
SELECT d.titre, d.proprietaire.nom FROM document d WHERE d.semestre='A14';


/*affiche les logins tous les administrateurs, grâce à la vue d'héritage.*/
SELECT login FROM vAdministrateurs ;

/*Affiche les titres des documents non-archivés*/
SELECT titre FROM vNonArchive ;

/*Affiche les informations de "Interne_UTC" où le login est verhedou*/
SELECT * FROM Interne_UTC i WHERE i.login = 'verhedou';
