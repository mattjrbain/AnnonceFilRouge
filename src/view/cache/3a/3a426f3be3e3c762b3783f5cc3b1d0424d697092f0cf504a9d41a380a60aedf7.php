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

/* accueil.html.twig */
class __TwigTemplate_ed957672c3726df1a71ded48daf65127e1358526c31f44adb0776ce814001f97 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "template.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("template.html.twig", "accueil.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Le titre";
    }

    // line 3
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    ";
        $this->loadTemplate("header.html.twig", "accueil.html.twig", 4)->display($context);
        // line 5
        echo "    <div class=\"container mb-4\">
        <div class=\"row \">
            <div class=\"col-lg-3 col-md-4 mt-3 \">
                <div class=\"card text-center shadow h-100 bg-yellow\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fas fa-car-side fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Auto, Moto</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-blue\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-paw fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Animaux</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-red\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-tv fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Electroménager</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-violet\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-home fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Maison, déco</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-orange\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <div class=\"card-block\"><h2><i class=\"fa fa-female fa-3x mt-2\"></i></h2></div>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Mode, Beauté</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-darkblue\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-laptop fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">High-Tech</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-mdviolet\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-bicycle fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Loisirs, Culture</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-lightblue\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-baby fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Bébé</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-lightyellow\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-hands-helping fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Services</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-green\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-briefcase fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Emploi</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-lightgreen\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-heart fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Rencontres</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class=\"col-lg-3 col-md-4 mt-3\">
                <div class=\"card text-center shadow h-100 bg-yellow\">
                    <!--                <img class=\"card-img-top\" src=\"holder.js/100px180/\" alt=\"\">-->
                    <h2><i class=\"fa fa-home fa-3x mt-2\"></i></h2>
                    <div class=\"card-body\">
                        <h4 class=\"card-title\">Immo</h4>
                        <p class=\"card-text\"><a name=\"\" id=\"\" class=\"btn btn-primary\" href=\"#\"
                                                role=\"button\">Consulter</a>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>

";
    }

    public function getTemplateName()
    {
        return "accueil.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 5,  58 => 4,  54 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "accueil.html.twig", "D:\\Projets_Communs\\AnnonceFilRouge\\src\\view\\accueil.html.twig");
    }
}
