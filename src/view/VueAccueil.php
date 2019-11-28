<?php


namespace Main\view;


class VueAccueil
{
    public function show()
    {
        $links = array();
        $originalUrl = "?action=";
        $afficherRubrique = $originalUrl . "afficherRubriques";
        $ajouterRubrique = $originalUrl . "ajouterRubrique";
        $accueil = $originalUrl . "accueil";
        $identifier = $originalUrl . "identifierUtilisateur";
        $links[] = "<a href=" . $afficherRubrique .">Afficher rubriques</a><br>";
        $links[] = "<a href=" . $ajouterRubrique .">Ajouter rubrique</a><br>";
        $links[] = "<a href=" . $accueil .">Test Accueil Twig</a><br>";
        $links[] = "<a href=" . $identifier .">Identifier</a><br>";
        $links[] = "<a href=\"/\">Accueil</a><br>";
        return $links;
    }
}