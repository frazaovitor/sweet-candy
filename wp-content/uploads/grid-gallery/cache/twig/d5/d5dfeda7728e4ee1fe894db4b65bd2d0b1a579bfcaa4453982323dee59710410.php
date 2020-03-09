<?php

/* @settings/index.twig */
class __TwigTemplate_5d6ac956b392134bd8e38a2e669b904f7e34403e3b34cde12c06de0629e10f95 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@settings/index.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'beforeSettingsList' => array($this, 'block_beforeSettingsList'),
            'beforeSettings' => array($this, 'block_beforeSettings'),
            'afterSettings' => array($this, 'block_afterSettings'),
            'afterSettingsList' => array($this, 'block_afterSettingsList'),
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
    public function block_content($context, array $blocks = array())
    {
        // line 5
        $context["h"] = $this->loadTemplate("@core/helpers.twig", "@settings/index.twig", 5);
        // line 6
        echo "
    <form action=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "settings", 1 => "saveSettings", 2 => array("_wpnonce" => ($context["_wpnonce"] ?? null))), "method"), "html", null, true);
        echo "\" method=\"POST\">";
        // line 8
        $this->displayBlock('beforeSettingsList', $context, $blocks);
        // line 14
        echo "        <div class=\"settings-list\">";
        // line 15
        $this->displayBlock('beforeSettings', $context, $blocks);
        // line 16
        echo "            <div class=\"settings\">
\t\t\t\t<div class=\"setting\">
                    <div class=\"setting-description\">
                        <label>";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "translate", array(0 => "Send usage statistics"), "method"), "html", null, true);
        echo "</label>";
        // line 20
        echo $context["h"]->getshowTooltip("If this option is enabled, the statistics about what plugin options you prefer to use will be collected and sent to us automatically. This information will help us make our solution better for you.", "top", true);
        echo "
                    </div>
                    <div class=\"setting-control\">
\t\t\t\t\t\t<input type=\"checkbox\" name=\"settings[send_stats]\" value=\"1\"";
        // line 23
        if ($this->getAttribute(($context["settings"] ?? null), "send_stats", array())) {
            echo "checked";
        }
        echo " />
                    </div>
                </div>
                <div class=\"setting\">
                    <div class=\"setting-description\">
                        <label>";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "translate", array(0 => "Image Preprocessor"), "method"), "html", null, true);
        echo "</label>";
        // line 29
        echo $context["h"]->getshowTooltip("Choose the preprocessor for image transformations (cropping, resizing etc.) Note: Changing the default settings may affect image quality. If you are not sure about how to use this option, please leave the settings by default.", "top", true);
        echo "
                    </div>
                    <div class=\"setting-control\">
                        <select name=\"settings[image_editor]\">";
        // line 33
        $context["editors"] = array("auto" => "Auto", "gd" => "GD", "imagic" => "Imagick");
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["editors"] ?? null));
        foreach ($context['_seq'] as $context["name"] => $context["title"]) {
            // line 39
            echo "                                <option value=\"";
            echo twig_escape_filter($this->env, $context["name"], "html", null, true);
            echo "\"";
            // line 40
            if (($context["name"] == $this->getAttribute(($context["settings"] ?? null), "image_editor", array()))) {
                // line 41
                echo "                                    selected=\"selected\"";
            }
            // line 43
            echo "                                >";
            echo twig_escape_filter($this->env, $context["title"], "html", null, true);
            echo "
                                </option>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['title'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo "                        </select>
                    </div>
                </div>
                <div class=\"setting\">
                    <div class=\"setting-description\">

                        <label>";
        // line 52
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "translate", array(0 => "Roles"), "method"), "html", null, true);
        echo "</label>";
        // line 53
        echo $context["h"]->getshowTooltip("Here you may assign the roles of the persons, that are allowed to use the plugin. This feature is useful when you need to depute your site management to someone else. Administrator is included by default.", "top", true);
        // line 55
        if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == false)) {
            // line 56
            echo "                            <a target=\"_blank\" href=\"";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('build_pro_url')->getCallable(), array(array("utm_medium" => "manage_roles"))), "html", null, true);
            echo "\">";
            // line 57
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "translate", array(0 => "PRO option"), "method"), "html", null, true);
            echo "
                            </a>";
        }
        // line 60
        echo "                    </div>
                    <div class=\"setting-control\">
                        <select multiple=\"multiple\" name=\"settings[access_roles][]\" class=\"chosen-select\" data-placeholder=\"";
        // line 62
        echo "Select avalilable roles to use tables.";
        echo "\">
                            <option value=\"administrator\" disabled selected>Administrator</option>";
        // line 64
        $context["roles"] = array("editor" => "Editor", "author" => "Author", "contributor" => "Contributor", "subscriber" => "Subscriber");
        // line 70
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["roles"] ?? null));
        foreach ($context['_seq'] as $context["role"] => $context["title"]) {
            // line 71
            echo "                                <option value=\"";
            echo twig_escape_filter($this->env, $context["role"], "html", null, true);
            echo "\"";
            // line 72
            if (twig_in_filter($context["role"], $this->getAttribute(($context["settings"] ?? null), "access_roles", array()))) {
                // line 73
                echo "                                    selected=\"selected\"";
            }
            // line 75
            echo "                                >";
            echo twig_escape_filter($this->env, $context["title"], "html", null, true);
            echo "
                                </option>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['role'], $context['title'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 78
        echo "                        </select>
                    </div>
                </div>
            </div>";
        // line 82
        $this->displayBlock('afterSettings', $context, $blocks);
        // line 83
        echo "        </div>";
        // line 84
        $this->displayBlock('afterSettingsList', $context, $blocks);
        // line 85
        echo "    </form>";
    }

    // line 8
    public function block_beforeSettingsList($context, array $blocks = array())
    {
        // line 9
        echo "            <button class=\"button\">
                <i class=\"fa fa-fw fa-save\"></i>";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "translate", array(0 => "Save"), "method"), "html", null, true);
        echo "
            </button>";
    }

    // line 15
    public function block_beforeSettings($context, array $blocks = array())
    {
    }

    // line 82
    public function block_afterSettings($context, array $blocks = array())
    {
    }

    // line 84
    public function block_afterSettingsList($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "@settings/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  199 => 84,  194 => 82,  189 => 15,  183 => 11,  180 => 9,  177 => 8,  173 => 85,  171 => 84,  169 => 83,  167 => 82,  162 => 78,  153 => 75,  150 => 73,  148 => 72,  144 => 71,  140 => 70,  138 => 64,  134 => 62,  130 => 60,  125 => 57,  121 => 56,  119 => 55,  117 => 53,  114 => 52,  106 => 46,  97 => 43,  94 => 41,  92 => 40,  88 => 39,  84 => 38,  82 => 33,  76 => 29,  73 => 28,  63 => 23,  57 => 20,  54 => 19,  49 => 16,  47 => 15,  45 => 14,  43 => 8,  40 => 7,  37 => 6,  35 => 5,  32 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@settings/index.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Settings\\views\\index.twig");
    }
}
