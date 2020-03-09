<?php

/* grid-gallery.twig */
class __TwigTemplate_4d43cd44bd907b7fba4f871bd4126e772f04e536c3c8657f1c9cb9767829d25c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'alerts' => array($this, 'block_alerts'),
            'header' => array($this, 'block_header'),
            'preview' => array($this, 'block_preview'),
            'content' => array($this, 'block_content'),
            'table' => array($this, 'block_table'),
            'notes' => array($this, 'block_notes'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"wraper\">";
        // line 9
        $this->displayBlock('alerts', $context, $blocks);
        // line 10
        echo "
    <div class=\"supsystic-plugin";
        // line 11
        if (($this->getAttribute(($context["pageOptions"] ?? null), "isSettingPage", array()) == 1)) {
            echo " sgg-setting-page";
        }
        echo "\">";
        // line 12
        $this->displayBlock('header', $context, $blocks);
        // line 17
        echo "        <section class=\"supsystic-content\">
            <nav class=\"supsystic-navigation supsystic-sticky\" style=\"top: 0px;\">
                <ul>
                    <li class=\"supsystic-sticky";
        // line 20
        if (($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "overview")) {
            echo "active";
        }
        echo "\">
                        <a href=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "overview"), "method"), "html", null, true);
        echo "\">
                            <i class=\"fa fa-info\"></i>
\t\t\t\t\t\t\t<span class=\"gg-sps-sticky-link\">";
        // line 23
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Overview")), "html", null, true);
        echo "</span>
                        </a>
                    </li>
                    <li";
        // line 26
        if ((($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "galleries") && ($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "action", array()) == "showPresets"))) {
            echo "class=\"active\"";
        }
        echo ">
                        <a id=\"btn-add-new\" href=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "showPresets"), "method"), "html", null, true);
        echo "\">
                            <i class=\"fa fa-plus-circle\"></i>
\t\t\t\t\t\t\t<span class=\"gg-sps-sticky-link\">";
        // line 29
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("New Gallery")), "html", null, true);
        echo "</span>
                        </a>
                    </li>
                    <li class=\"supsystic-sticky";
        // line 32
        if (((($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "galleries") || (null === $this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()))) && ($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "action", array()) != "showPresets"))) {
            echo "active";
        }
        echo "\">
                        <a href=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">
                            <i class=\"fa fa-archive\"></i>
\t\t\t\t\t\t\t<span class=\"gg-sps-sticky-link\">";
        // line 35
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Galleries")), "html", null, true);
        echo "</span>
                        </a>
                    </li>
                    <li class=\"supsystic-sticky";
        // line 38
        if (($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "optimization")) {
            echo " active";
        }
        echo "\">
                        <a href=\"";
        // line 39
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "optimization"), "method"), "html", null, true);
        echo "\">
                            <i class=\"fa fa-compress\"></i>
\t\t\t\t\t\t\t<span class=\"gg-sps-sticky-link\">";
        // line 41
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Image Optimize")), "html", null, true);
        echo "</span>
                        </a>
                    </li>

                    <li class=\"supsystic-sticky";
        // line 45
        if (($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "settings")) {
            echo "active";
        }
        echo "\">
                        <a href=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "settings"), "method"), "html", null, true);
        echo "\">
                            <i class=\"fa fa-gear\"></i>
\t\t\t\t\t\t\t<span class=\"gg-sps-sticky-link\">";
        // line 48
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Advanced Settings")), "html", null, true);
        echo "</span>
                        </a>
                    </li>";
        // line 52
        if ($this->getAttribute(($context["environment"] ?? null), "getModule", array(0 => "license"), "method")) {
            // line 53
            echo "                        <li class=\"supsystic-sticky";
            if (($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "license")) {
                echo "active";
            }
            echo "\">
                            <a href=\"";
            // line 54
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "license"), "method"), "html", null, true);
            echo "\">
                                <i class=\"fa fa-hand-o-right\"></i>
\t\t\t\t\t\t\t\t<span class=\"gg-sps-sticky-link\">";
            // line 56
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("License")), "html", null, true);
            echo "</span>
                            </a>
                        </li>";
        }
        // line 60
        echo "\t\t\t\t\t
\t\t\t\t\t<li class=\"supsystic-sticky";
        // line 61
        if (($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "featuredplugins")) {
            echo "active";
        }
        echo "\">
                        <a href=\"";
        // line 62
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "featuredplugins"), "method"), "html", null, true);
        echo "\">
                            <i class=\"fa fa-heart\"></i>
\t\t\t\t\t\t\t<span class=\"gg-sps-sticky-link\">";
        // line 64
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Featured Plugins")), "html", null, true);
        echo "</span>
                        </a>
                    </li>";
        // line 131
        echo "                </ul>
            </nav>
            <div class=\"supsystic-container supsystic-item supsystic-panel\"";
        // line 133
        if (($this->getAttribute($this->getAttribute(($context["request"] ?? null), "query", array()), "module", array()) == "galleries")) {
            echo "style=\"min-height: 500px\"";
        }
        echo ">";
        // line 134
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["environment"] ?? null), "getDispatcher", array(), "method"), "dispatch", array(0 => "messages"), "method"), "html", null, true);
        // line 135
        $this->displayBlock('preview', $context, $blocks);
        // line 136
        $this->displayBlock('content', $context, $blocks);
        // line 137
        echo "                <div class=\"clear\"></div>";
        // line 138
        $this->displayBlock('table', $context, $blocks);
        // line 139
        echo "            </div>
        </section>
    </div>

    <!-- Modal loading overlay -->
    <div class=\"gg-modal-loading-overlay\"></div>
    <div class=\"gg-modal-loading-object\">
        <p>
            <span id=\"loading-text\">Loading</span>
            <img src=\"";
        // line 148
        echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["environment"] ?? null), "config", array()), "get", array(0 => "admin_url"), "method") . "/images/wpspin_light.gif"), "html", null, true);
        echo "\" alt=\"\"
                 title=\"";
        // line 149
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Loading")), "html", null, true);
        echo "\"/>
        </p>
    </div>";
        // line 153
        $this->displayBlock('notes', $context, $blocks);
        // line 154
        echo "</div>
";
    }

    // line 9
    public function block_alerts($context, array $blocks = array())
    {
    }

    // line 12
    public function block_header($context, array $blocks = array())
    {
        // line 13
        echo "            <div class=\"supsystic-breadcrumbs\">
                Galleries
            </div>";
    }

    // line 135
    public function block_preview($context, array $blocks = array())
    {
    }

    // line 136
    public function block_content($context, array $blocks = array())
    {
    }

    // line 138
    public function block_table($context, array $blocks = array())
    {
    }

    // line 153
    public function block_notes($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "grid-gallery.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  243 => 153,  238 => 138,  233 => 136,  228 => 135,  222 => 13,  219 => 12,  214 => 9,  209 => 154,  207 => 153,  202 => 149,  198 => 148,  187 => 139,  185 => 138,  183 => 137,  181 => 136,  179 => 135,  177 => 134,  172 => 133,  168 => 131,  163 => 64,  158 => 62,  152 => 61,  149 => 60,  143 => 56,  138 => 54,  131 => 53,  129 => 52,  124 => 48,  119 => 46,  113 => 45,  106 => 41,  101 => 39,  95 => 38,  89 => 35,  84 => 33,  78 => 32,  72 => 29,  67 => 27,  61 => 26,  55 => 23,  50 => 21,  44 => 20,  39 => 17,  37 => 12,  32 => 11,  29 => 10,  27 => 9,  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "grid-gallery.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\app\\templates\\grid-gallery.twig");
    }
}
