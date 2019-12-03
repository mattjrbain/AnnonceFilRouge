# AnnonceFilRouge

Projet "Fil Rouge" de la formation Développeur Web / Web Mobile Afpa 2019 

## Cahier des charges
Le projet consiste à réaliser un système de gestion de petites annonces qui s’inspire des sites gratuits de petites annonces, et qui doit principalement permettre de consulter des annonces, d’en déposer, et de les gérer.

Une annonce est caractérisée au minimum par un en-tête, un corps et une date limite de validité, une rubrique et l’utilisateur qui l’a déposée. 
La gestion back-office est confiée à un administrateur de l’application. 
Pour certaines fonctionnalités, le système contrôle l’accès des utilisateurs.

### Catégorie d'utilisateurs: visiteur
Tout visiteur du système d'annonces peut librement:
* consulter les annonces publiées, 
* s’identifier ou créer un compte.

### Catégorie d'utilisateurs: utilisateur identifié
Tout utilisateur qui souhaite créer une annonce ou gérer ses annonces doit au préalable s'identifier.
Les fonctionnalités accessibles à l’utilisateur identifié sont:
* déposer une annonce,
* gérer ses propres annonces,
  * lister ses annonces,
  * modifier une annonce,
  * détruire une annonce.

### Catégorie d'utilisateurs: administrateur
Tout administrateur a accès à des fonctions spécifiques lui permettant de : 
* gérer les rubriques,
* gérer les annonces périmées.
