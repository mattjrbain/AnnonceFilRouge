<?php


namespace Main\view;


class VueListerRubriques
{
    private $contenu;

    public function setContenu($cont)
    {
        $this->contenu = $cont;
    }

    public function show()
    {
        foreach ($this->contenu as $contenu) {
            echo $contenu ."<br>";
        }
    }
}