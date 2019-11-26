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
        $links[] = "<a href=" . $afficherRubrique .">Afficher rubriques</a><br>";
        $links[] = "<a href=" . $ajouterRubrique .">Ajouter rubrique</a><br>";
        $links[] = "<a href=\"/\">Accueil</a><br>";
        return $links;
    }
}