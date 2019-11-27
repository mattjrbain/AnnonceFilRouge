<?php


namespace Main\view;


class VueAjouterRubrique
{

    public function show()
    {
        $form = "
        <form action=\"\" method=\"post\">
            <div class=\"form-group\">
                <label for=\"libelle\">Libelle</label>
                <input type=\"text\"
                       class=\"form-control\" name=\"libelle\" id=\"libelle\" aria-describedby=\"helpId\" placeholder=\"\">
            </div>
            <div class=\"form-group\">
                <input type=\"hidden\"
                       class=\"form-control\" name=\"action\" id=\"action\" aria-describedby=\"helpId\" placeholder=\"\" value=\"ajouterRubrique\">
            </div>
            <button type=\"submit\" class=\"btn btn-primary\">Envoyer</button>
            <button type=\"reset\" class=\"btn btn-primary\">Annuler</button>
        </form>
        ";
        echo $form;
    }
}