<?php

/* @overview/index.twig */
class __TwigTemplate_af1c40a74c2dccbecb15b686e3a2d14594d57d144abc6541c56dedf8cf64333f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@overview/index.twig", 1);
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
        echo "
    <nav id=\"supsystic-breadcrumbs\" class=\"supsystic-breadcrumbs\">
        <a href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Galleries")), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Overview")), "html", null, true);
        echo "</a>
    </nav>";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "    <div class=\"supsystic-overview\">
        <div class=\"half-page half-page-left\">";
        // line 23
        echo "
            <div class=\"faq-list\">
                <h3>FAQ and Documentation</h3>
                <div class=\"faq-title\">
                    <i class=\"fa fa-info-circle\"></i>
                    Gallery plugin installation
                    <div class=\"description\" hidden>
                        One more advantage of responsive grid gallery WordPress plugin is an easy installation. To install it, you should make three following steps:</br>
                        1. Download Supsystic Gallery WordPress plugin.</br>
                        2. Upload to your WordPress plugins directory.</br>
                        3. Activate and enjoy.
                    </div>
                </div>
                <div class=\"faq-title\">
                    <i class=\"fa fa-info-circle\"></i>
                    Gallery doesn’t load on the front end. If the loading gallery icon just keeps playing but never loads the gallery.
                    <div class=\"description\" hidden>
                        Most likely there are conflicts with your theme or other plugins. Please contact us through our <a href=\"//supsystic.com/contact-us/\" target=\"_blank\">internal support</a>. We will check what is wrong and will help you to solve the problem.
                    </div>
                </div>
                <div class=\"faq-title\">
                    <i class=\"fa fa-info-circle\"></i>
                    How to change the position of photos in gallery?

                    <div class=\"description\" hidden>
                        To change the position of photos just drag them manually on the Images List and click save.  Also there you can sort the images by add date, create date, size, name and tags.
                    </div>
                </div>
\t\t\t\t<div class=\"faq-title\">
                    <i class=\"fa fa-info-circle\"></i>
                    What is Gallery Loader?

                    <div class=\"description\" hidden>
                        This is a new option of Photo Gallery by Supsystic, which can be found on the Main tab settings. With its help you can choose funny loader icons to entertain your users while they are waiting. Also you can set the color for your icon or disable this option at all, if you don’t need it.
\t\t\t\t\t\tLearn more about it in <a href=\"//supsystic.com/main-settings/\" target=\"_blank\">Main Settings.</a>
                    </div>
                </div>
                <div style=\"clear: both;\"></div>
                <a href=\"";
        // line 61
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "promo", 1 => "showTutorial"), "method"), "html", null, true);
        echo "\" class=\"button button-primary button-hero\">
                    <i class=\"fa fa-info-circle\"></i>";
        // line 63
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Start step-by-step tutorial")), "html", null, true);
        echo "
                </a>
                <a href=\"http://supsystic.com/plugins/photo-gallery/?utm_source=plugin&utm_medium=faq&utm_campaign=gallery#faq\" class=\"button button-primary button-hero\">
                    <i class=\"fa fa-info-circle\"></i>
                    Check all FAQs
                </a>
                <div style=\"clear: both;\"></div>
            </div>
            <div class=\"video\">
                <h3>Video tutorial</h3>
                <iframe type=\"text/html\"
                        width=\"80%\"
                        height=\"240px\"
                        src=\"http://www.youtube.com/embed/5bkjrlV14CE\"
                        frameborder=\"0\">
                </iframe>
            </div>
            <div class=\"banner\">
                <div class=\"text-block\">";
        // line 81
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("If you want to host a business site or a blog, Kinsta managed WordPress hosting is the best place to stop on. Without any hesitation, we can say Kinsta is incredible when it comes to uptime and speed.")), "html", null, true);
        echo "</div>
                <a href=\"https://kinsta.com?kaid=MNRQQASUYJRT\">
                    <img src=\"";
        // line 83
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('plugin_directory_url')->getCallable(), array("app/assets/img/kinsta_banner.png")), "html", null, true);
        echo "\" style=\"width: 300px;height: 250px;\" />
                </a>
            </div>
            <div class=\"server-settings\">
                <h3>Server Settings</h3>
                <ul class=\"settings-list\">";
        // line 89
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["serverSettings"] ?? null));
        foreach ($context['_seq'] as $context["title"] => $context["element"]) {
            // line 90
            echo "                        <li class=\"settings-line\" style=\"float: none;\">
                            <div class=\"settings-title\">";
            // line 91
            echo twig_escape_filter($this->env, twig_trim_filter($context["title"]), "html", null, true);
            echo ":</div>
                            <span>";
            // line 92
            echo twig_escape_filter($this->env, twig_trim_filter($this->getAttribute($context["element"], "value", array())), "html", null, true);
            echo "</span>
                        </li>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['title'], $context['element'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 95
        echo "                </ul>
            </div>
        </div>
        <div class=\"half-page half-page-right\">
            <div class=\"supsystic-overview-news-container\">
                <h3>News</h3>
                <div class=\"supsystic-overview-news\">";
        // line 102
        echo ($context["news"] ?? null);
        echo "
                </div>
                <a href=\"http://supsystic.com/plugins/photo-gallery/\" class=\"button button-primary button-hero\">
                    <i class=\"fa fa-info-circle\"></i>All news
                </a>
                <div class=\"clear\"></div>
            </div>
            <div class=\"overview-contact-form\">
                <h3>Contact form</h3>";
        // line 112
        $context["form"] = $this->loadTemplate("@core/form.twig", "@overview/index.twig", 112);
        // line 114
        echo $context["form"]->getopen("post", $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "overview", 1 => "sendMail"), "method"), array("id" => "form-settings", "style" => "max-width: 428px;", "_wpnonce" => ($context["_wpnonce"] ?? null)));
        echo "

                <table class=\"contact-form-table\" style=\"width: 100%;\">
                    <thead>";
        // line 118
        echo $context["form"]->getrow((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Name")) . " *"),         // line 119
$context["form"]->gettext("name", $this->getAttribute(($context["contactForm"] ?? null), "name", array()), array("required" => "")));
        // line 121
        echo $context["form"]->getrow((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Email")) . " *"),         // line 122
$context["form"]->gettext("email", $this->getAttribute(($context["contactForm"] ?? null), "email", array()), array("required" => "")));
        // line 124
        echo $context["form"]->getrow((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Website")) . " *"),         // line 125
$context["form"]->gettext("website", $this->getAttribute(($context["contactForm"] ?? null), "website", array()), array("required" => "")));
        // line 127
        echo $context["form"]->getrow((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Subject")) . " *"),         // line 128
$context["form"]->gettext("subject", "", array("required" => "")));
        echo "
                    <tr>
                        <th scope=\"row\">
                            <label for=\"select-question\">";
        // line 131
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Topic")), "html", null, true);
        echo "</label>
                        </th>
                        <td>
                            <select id=\"select-question\" name=\"question\">
                                <option value=\"plugin_options\">";
        // line 136
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Plugin options")), "html", null, true);
        echo "
                                </option>
                                <option value=\"bug\">";
        // line 139
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Report a bug")), "html", null, true);
        echo "
                                </option>
                                <option value=\"functionallity\">";
        // line 142
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Require a new functionallity")), "html", null, true);
        echo "
                                </option>
                                <option value=\"other\">";
        // line 145
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Other")), "html", null, true);
        echo "
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope=\"row\" style=\"vertical-align: top;\">
                            <label for=\"mail-text\">";
        // line 152
        echo twig_escape_filter($this->env, (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Message")) . " *"), "html", null, true);
        echo "</label>
                        </th>
                        <td>
                            <textarea id=\"mail-text\" name=\"message\" cols=\"50\" rows=\"3\" placeholder=\"";
        // line 155
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Hello Supsystic Team!")), "html", null, true);
        echo "\" required=\"\"></textarea>
                        </td>
                    </tr>

                    </thead>
                </table>
                <button id=\"send-mail\" type=\"submit\" class=\"button button-primary button-hero\">
                    <i class=\"fa fa-upload\"></i>
                    Send email
                </button>
                <div class=\"required-notification\" style=\"color: red; float: left;\" hidden>Fields with * are required to fill</div>";
        // line 166
        echo $context["form"]->getclose();
        echo "
                <div class=\"clear\"></div>
            </div>
        </div>
        <div id=\"contact-form-dialog\" hidden>
            <div class=\"on-error\" style=\"display:none\">
                <p>";
        // line 172
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Some errors occurred while sending mail please send your message trough this contact form:")), "html", null, true);
        echo "</p>
                <p><a href=\"http://supsystic.com/plugins/photo-gallery/#contact\" target=\"_blank\">http://supsystic.com/plugins/photo-gallery/#contact</a></p>
            </div>
            <div class=\"message\"></div>
        </div>
    </div>";
    }

    public function getTemplateName()
    {
        return "@overview/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  257 => 172,  248 => 166,  235 => 155,  229 => 152,  219 => 145,  214 => 142,  209 => 139,  204 => 136,  197 => 131,  191 => 128,  190 => 127,  188 => 125,  187 => 124,  185 => 122,  184 => 121,  182 => 119,  181 => 118,  175 => 114,  173 => 112,  162 => 102,  154 => 95,  146 => 92,  142 => 91,  139 => 90,  135 => 89,  127 => 83,  122 => 81,  101 => 63,  97 => 61,  57 => 23,  54 => 14,  51 => 13,  43 => 8,  36 => 6,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@overview/index.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Overview\\views\\index.twig");
    }
}
