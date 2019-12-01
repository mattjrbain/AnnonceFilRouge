# AnnonceFilRouge

Projet "Fil Rouge" de la formation Développeur Web / Web Mobile Afpa 2019 

### Cahier des charges
Vous êtes chargé de réaliser un système de gestion de petites annonces utilisablees au sein d'une entreprisse ou d"une collectivité et qui s'inspire des sites gratuits de petites annonces.
Ce système doit principalement permettre de consulter des annonces, d'en déposer, et de les gérer.

Une annonce est caractérisée par un entête (texte de maximum 80 caractères ), un corps (texte de taille limitéé) et une date limite de validité, une rubrique et l'utilisateur qui l'a déposée.
Une annonce figure dans une seule rubrique, et une rubrique peut ne pas contenir d'annonce. Une rubrique est caractérisée par son libellé. La gestion des rubriques est confiée à un administrateur de l'application.
Pour certaines fonctionnalités, le système contrôle l'accès des utilisateurs par nom et mot de passe. Il n'y a pas d'homonyme au sein de l'entreprise ou de la collectivité.

## Description succinte des fonctionnalités du système
(les fonctions décrites entre [] sont à réaliser dans un deuxième étape)

### Catégories d'utilisateurs : Utilisateur anonyme (Visiteur)
Tout visiteur du système d'annonces peut librement consulter toutes les annonces publiées, sans être obligé de s'identifier.

#### Consulter les annonces
La seule fonction autorisée dans ce cas est la consultation d'annonces, elle s'effectue en deux étapes : 
* l'utilisateur choisit d'abord la rubrique qui l'intéresse (en navigant dans une liste de rubriques)
* ensuite, l'application
