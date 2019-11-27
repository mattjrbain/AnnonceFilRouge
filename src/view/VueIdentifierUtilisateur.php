<?php


namespace Main\view;


class VueIdentifierUtilisateur
{
    public function show()
    {
        $form = "
        <form action=\"\" method=\"post\">
            <div class=\"form-group\">
                <label for=\"name\">Nom</label>
                <input type=\"text\"
                       class=\"form-control\" name=\"name\" id=\"name\" aria-describedby=\"helpId\" placeholder=\"\">
            </div>
            <div class=\"form-group\">
                <label for=\"pass\">Pass</label>
                <input type=\"text\"
                       class=\"form-control\" name=\"pass\" id=\"pass\" aria-describedby=\"helpId\" placeholder=\"\">
            </div>
            <div class=\"form-group\">
                <input type=\"hidden\"
                       class=\"form-control\" name=\"action\" id=\"action\" aria-describedby=\"helpId\" placeholder=\"\" value=\"identifierUtilisateur\">
            </div>
            <button type=\"submit\" class=\"btn btn-primary\">Envoyer</button>
        </form>
        ";
        echo $form;
    }
}