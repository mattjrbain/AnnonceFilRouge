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

/* header.html.twig */
class __TwigTemplate_bd23f358b40c0c7d3871ac1a45794c107b3f973dcde1c1bf81cb776a0f3e8e1d extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'header' => [$this, 'block_header'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $this->displayBlock('header', $context, $blocks);
    }

    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "    <div class=\"jumbotron text-white bg-dark jumbotron-fluid mb-0\">
        <div class=\"container\">
            <h1 class=\"display-3\">Annonce.com</h1>
            <p class=\"lead\">Un Slogan Super</p>
        </div>

    </div>
    <nav class=\"navbar navbar-expand-md navbar-dark bg-dark mb-3\">
        <a class=\"navbar-brand text-success\" href=\"#\">Annonce.com</a>
        <button class=\"navbar-toggler d-lg-none\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapsibleNavId\"
                aria-controls=\"collapsibleNavId\"
                aria-expanded=\"false\" aria-label=\"Toggle navigation\">
            <span class=\"navbar-toggler-icon\"></span>
        </button>
        <div class=\"collapse navbar-collapse\" id=\"collapsibleNavId\">
            <ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"#\">Rubriques <span class=\"sr-only\">(current)</span></a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"#\">Compte</a>
                </li>
            </ul>
            <a class=\"mr-3\" href=\"...\"><i class=\"fa fa-user fa-2x text-white\" aria-hidden=\"true\"></i></a>
            <form class=\"form-inline my-2 my-lg-0\">
                <input class=\"form-control mr-sm-2\" type=\"text\" placeholder=\"recherche...\">
                <button class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\">Rechercher</button>
            </form>
        </div>
    </nav>
";
    }

    public function getTemplateName()
    {
        return "header.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  45 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.html.twig", "D:\\Projets_Communs\\AnnonceFilRouge\\src\\view\\header.html.twig");
    }
}
