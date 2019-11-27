<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* template.html.twig */
class __TwigTemplate_c3ddd35316279400ba95cfc0eefb6b4ccb568f672fa3ac51c45db3e809c54674 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"en\">
<head>
    ";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 18
        echo "</head>
<body>
<div class=\"container-fluid\">
    ";
        // line 21
        $this->displayBlock('body', $context, $blocks);
        // line 22
        echo "</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src=\"https://code.jquery.com/jquery-3.3.1.slim.min.js\"
        integrity=\"sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo\"
        crossorigin=\"anonymous\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\"
        integrity=\"sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1\"
        crossorigin=\"anonymous\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\"
        integrity=\"sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM\"
        crossorigin=\"anonymous\"></script>
</body>
</html>";
    }

    // line 4
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        echo "        <title>";
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <!-- Required meta tags -->
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

        <!-- Bootstrap CSS -->
        <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css\"
              integrity=\"sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T\"
              crossorigin=\"anonymous\">
        <link rel=\"stylesheet\" href=\"../web/css/annonce.css\">
        <!-- FontAwesome Kit   -->
        <script src=\"https://kit.fontawesome.com/8108dfc9fe.js\" crossorigin=\"anonymous\"></script>
    ";
    }

    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 21
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "template.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  98 => 21,  75 => 5,  71 => 4,  54 => 22,  52 => 21,  47 => 18,  45 => 4,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "template.html.twig", "D:\\Projets_Communs\\AnnonceFilRouge\\src\\view\\template.html.twig");
    }
}
