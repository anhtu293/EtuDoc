# Projet de NA17 : Système de gestion de documents
### - Anh Tu Nguyen 
### - Alexandre Brasseur 
### - Kyllian Chartrain
### - Camille Beaudou
### P5 - Application
Les fichiers se trouvent dans le dossier `app` et s'organisent en architecture **MVC** (_Models_ Views Controllers) (pas de Models en réalité).

On a l'architecture suivante :
- `assets/`         : tous les fichiers statiques css, js, img...
- `controllers/`    : le traitement des données
- `views/`          : les templates et vues (réponses html) envoyées à l'utilisateur
- `.htaccess`       : configuration des routes pour que toutes les requêtes
- `config.php`      : configuration de la bdd et autres 
- `helpers.php`     : fonctions utiles disponibles pour toute l'application
- `index.php`       : point d'entrée de toutes les requêtes et inclusion des fichiers
- `routes.php`      : définition des routes possibles

### Routes

`routes.php` appelle les fonctions des controllers et fait un switch sur les params de l'url `REQ_PARAMS` récupérés dans `index.php`.

### Controllers

Ce dossier donne les fonctions principales qui permettent de récupérer les données depuis la base de données et appellent ensuite les bonnes vues en leur passant les résultats des requêtes.


### Views
J'ai fait un mini moteur de template :
les views sont emboitées dans le `views/template.php` via la fonction `view('nom_de_la_vue_sans_point_php')`

## TODO

- [ ] Rajouter les P1-4
- [ ] login
- [ ] 
