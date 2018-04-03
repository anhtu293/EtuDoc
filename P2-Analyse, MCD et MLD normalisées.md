# P2 - Analyse, MCD et MLD normalisées
###### Version 3 (1 Décembre 2017)


### Groupe 10
- Anh Tu Nguyen 
- Alexandre Brasseur 
- Kyllian Chartrain
- Camille Beaudou

## Modélisation Conceptuelle de Données

Tous les classes et les attributs ont été basés sur la Note de Clarification (V2).



**!!! Mettre l'image** 




## Modélisation Logique de Données

À partir du diagramme UML, nous déduisons les relations suivantes :

Pour l'héritage de **Interne_UTC** à **Etudiant** et **Enseignant**, on fait un héritage par classe mère. En effet on est dans le cas d'un héritage complet, c'est donc la solution qui nous semble le plus simple.

Pour l'héritage de **Personne** à **Interne_UTC**, on fait un héritage par référence, cela permet d'éviter les redondances et de simplifier les relations avec **Document**. chaque type d'utilisateur pourra être retrouvé avec des Vues dans le SQL.


- **Document**(#id: integer, titre: varchar, semestre: char(3), date_publication: date, archivage: boolean, lien: varchar, type => Type.intitule, uv => UV.code, proprietaire => Interne_UTC.login) avec lien KEY, uv et proprietaire NOT NULL

- **Type**(#intitule: varchar)
- **Personne**(#mail: varchar, nom : varchar, prenom : varchar)
- **Interne_UTC**(login: varchar, is_admin: boolean, role: {etudiant, enseignant}, #personne => Personne.mail) avec is_admin, role NOT NULL et login KEY
- **Contribue**(#document => Document.id, #personne=>Personne.mail) avec PROJECTION(Document,id) = PROJECTION(Contribue,document) 

- **UV**(#code: char(5), description: varchar), avec description KEY

*Exemple :*

| Code  | Description                              |
| ----- | ---------------------------------------- |
| NA17  | Conception de bases de données relationnelles et non-relationnelles (en autonomie) |
| HT04  | Théories technologiques et histoire des savoirs techniques |
| TMI03 | Ergonomie des situations de travail (apprentissage) |

- **Categorie**(#nom : varchar)
- **Classifie**(#document=>Document.id, #categorie=>Categorie.nom) avec PROJECTION(Document,id) = PROJECTION(Categorie,nom)

- **Licence**(#nom: varchar)
- **Comporte**(#document=>Document.id, #licence => Licence.nom) avec PROJECTION(Document,id) = PROJECTION(Comporte,document)



### Normalisation

#### 1NF
- [x] Toutes les relations ont au moins une clef.
- [x] Tous les attributs sont atomiques.

#### 2NF 
- [x] Toutes les relations sont 1NF.
- [x] Il n’y a pas d’attribut non clef qui soit en dépendance fonctionnelle avec une partie de la clef

#### 3NF 
- [x] Tous les relations sont 2NF.
- [x] Aucun attribut non clef ne détermine un autre attribut non clef

Ainsi les relations sont en 3NF.


Diffusé sous licence [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/)