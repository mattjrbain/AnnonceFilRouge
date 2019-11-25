<?php


namespace Main\view;


class VueAccueil
{
    public function show()
    {
        $links = array();
        $originalUrl = "?action=";
        $afficherRubrique = $originalUrl . "afficherRubriques";
        $links[] = "<a href=" . $afficherRubrique .">Afficher rubriques</a>";
        return $links;
    }
}