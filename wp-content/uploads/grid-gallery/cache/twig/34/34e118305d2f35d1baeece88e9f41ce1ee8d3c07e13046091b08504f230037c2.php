<?php

/* @insta/authorization.twig */
class __TwigTemplate_39e4dd6a75edf01857c7a7d0c84139bfffd8325cdb9ce347d0323b03a6031f7e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@insta/authorization.twig", 1);
        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "grid-gallery.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_header($context, array $blocks = array())
    {
        // line 4
        echo "    <nav id=\"supsystic-breadcrumbs\" class=\"supsystic-breadcrumbs\">";
        // line 7
        echo "        <a href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Galleries")), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "view", 2 => array("gallery_id" => ($context["id"] ?? null))), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, twig_capitalize_string_filter($this->env, ($context["galleryName"] ?? null)), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "view", 2 => array("gallery_id" => ($context["id"] ?? null))), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import images")), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "insta", 1 => "authorization", 2 => array("id" => ($context["id"] ?? null))), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Instagram authorization")), "html", null, true);
        echo "</a>
    </nav>";
    }

    // line 17
    public function block_content($context, array $blocks = array())
    {
        // line 18
        echo "
    <h2 id=\"gg-alrt\" style=\"text-align: center; color: #bfbfbf; margin: 50px 0 25px 0;\">
\t\t<span style=\"margin-bottom: 20px; display: block;\">";
        // line 21
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Upload your images from the Instagram Media Library")), "html", null, true);
        echo "
\t\t</span>
        <a class=\"button button-primary button-hero bordered\" href=\"";
        // line 23
        echo twig_escape_filter($this->env, ($context["url"] ?? null), "html", null, true);
        echo "\">
            <i class=\"fa fa-fw fa-instagram\"></i>";
        // line 25
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Upload from Instagram")), "html", null, true);
        echo "
        </a>
    </h2>";
    }

    public function getTemplateName()
    {
        return "@insta/authorization.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 25,  76 => 23,  71 => 21,  67 => 18,  64 => 17,  56 => 13,  49 => 11,  42 => 9,  34 => 7,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@insta/authorization.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Insta\\views\\authorization.twig");
    }
}
