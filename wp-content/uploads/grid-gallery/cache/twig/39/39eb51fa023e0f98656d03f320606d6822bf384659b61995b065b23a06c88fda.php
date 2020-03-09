<?php

/* @galleries/gallery_preset.twig */
class __TwigTemplate_0cf5eb04dda5541eafe95eb3d0d6c0a24cf8fc712e4120936e250f049825044a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@galleries/gallery_preset.twig", 1);
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

    // line 27
    public function block_header($context, array $blocks = array())
    {
        // line 28
        echo "    <nav id=\"supsystic-breadcrumbs\" class=\"supsystic-breadcrumbs\">";
        // line 31
        echo "        <a href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "showPresets"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Create new gallery")), "html", null, true);
        echo "</a>
    </nav>";
    }

    // line 35
    public function block_content($context, array $blocks = array())
    {
        // line 36
        $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@galleries/gallery_preset.twig", 36);
        // line 37
        echo "
    <h3 style=\"margin-left: 10px;padding-bottom: 10px !important;border-bottom: 1px solid;\">";
        // line 38
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Choose Gallery Template. You can change template and settings on the next step.")), "html", null, true);
        echo "</h3>
    <div id=\"gg-create-gallery-text\">
        <h3 style=\"float: left; margin: 10px !important;\">";
        // line 40
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery Name:")), "html", null, true);
        // line 41
        echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Type your new gallery name here. It is for internal use only and will not be visible on your site.")) . " <a target='_blank' href='https://supsystic.com/documentation/gallery-getting-started/'>https://supsystic.com/documentation/gallery-getting-started/</a>"), "top", true);
        // line 44
        echo "
\t\t</h3>
        <form id=\"gallery-create-form\">
        <input id=\"gallery-create-title\" name=\"title\" type=\"text\" style=\"float: left; width: 60%; height: 36px;\"/>
        <button id=\"gallery-create\" class=\"button button-primary\" type=\"button\" style=\"height:37px;\">
            <i class=\"fa fa-check\"></i>";
        // line 50
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save")), "html", null, true);
        echo "
        </button>";
        // line 55
        echo "        </form\">

        <div class=\"clear\"></div>
        <input id=\"presetValue\" name=\"preset\" type=\"hidden\" value=\"1\"/>
    </div>";
        // line 61
        echo "    <div id=\"gg-create-gallery-text\">
        <div class=\"presetSelect\">";
        // line 63
        $context["preset"] = $this;
        // line 65
        $context["presets"] = array(0 => array("title" => "Standard Gallery", "image" => "template1.jpg", "pro" => false, "value" => 1, "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery with fixed grid. If the original image is larger, the picture will be proportionally reduced and cropped to the specified thumbnail size.")) . " <a target='_blank' href='https://supsystic.com/documentation/fixed-type/'>https://supsystic.com/documentation/fixed-type/</a>")), 1 => array("title" => "Vertical Gallery", "image" => "template2.jpg", "pro" => false, "value" => 2, "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("In this gallery images are arranged into vertical columns. In vertical gallery type you may set image width only, image height will change automatically, accordingly to original size proportions.")) . " <a target='_blank' href='https://supsystic.com/documentation/vertical-type/'>https://supsystic.com/documentation/vertical-type/</a>")), 2 => array("title" => "Rounded Gallery", "image" => "template3.jpg", "pro" => false, "value" => 3, "tooltip" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery with rounded thumbnails and fixed grid. Images will be proportionally reduced and cropped to the specified thumbnail size and shape."))), 3 => array("title" => "Horizontal Gallery", "image" => "template4.jpg", "pro" => false, "value" => 4, "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("In this gallery images are arranged into horizontal rows. In horizontal gallery type you may set image height only, image width will change automatically, accordingly to original size proportions.")) . " <a target='_blank' href='https://supsystic.com/documentation/horizontal-type/'>https://supsystic.com/documentation/horizontal-type/</a>")), 4 => array("title" => "Categories and Icons", "image" => "template5.jpg", "pro" => true, "value" => 5, "link" => "https://supsystic.com/categories-gallery-example/", "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("If choosing this gallery template you may easily arrange your images by categories and add icons. Get step by step instructions from our knowledge base.")) . " <a target='_blank' href='https://supsystic.com/documentation/categories/'>https://supsystic.com/documentation/categories/</a>")), 5 => array("title" => "Post feed and Pagination", "image" => "template6.jpg", "pro" => true, "value" => 6, "link" => "https://supsystic.com/pagination-gallery-example/", "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("This gallery template with active presets of post feed and pagination options will help you organize handy post feed navigation. Note: you don't need to add images to your gallery if using it as a post feed. You should add them directly at the post body.")) . " <a target='_blank' href='https://supsystic.com/example/pagination-gallery-example/'>https://supsystic.com/example/pagination-gallery-example/</a>")), 6 => array("title" => "Post feed Slide Up", "image" => "template7.jpg", "pro" => true, "value" => 7, "link" => "https://supsystic.com/post-feed-slide-up/", "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("This gallery template with active presets of post feed slide up helps you create a stylish post feed with sliding highlight effect. Note: you don't need to add images to your gallery if using it as a post feed. You should add them directly at the post body.")) . " <a target='_blank' href='https://supsystic.com/example/post-feed-slide-up/'>https://supsystic.com/example/post-feed-slide-up/</a>")), 7 => array("title" => "Post feed Description", "image" => "template8.jpg", "pro" => true, "value" => 8, "link" => "https://supsystic.com/post-feed-description/", "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery template with small images and fixed place for description. Suits perfectly for Feedback page or 'Our Team' presentation page. Note: you don't need to add images to your gallery if using it as a post feed. You should add them directly at the post body.")) . " <a target='_blank' href='https://supsystic.com/example/post-feed-description/'>https://supsystic.com/example/post-feed-description/</a>")), 8 => array("title" => "Mosaic Gallery", "image" => "template9.png", "pro" => true, "value" => 9, "link" => "https://supsystic.com/mosaic-gallery-example/", "tooltip" => (call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Cute mosaic gallery layout with enabled captions.")) . " <a target='_blank' href='https://supsystic.com/documentation/gallery-mosaic-type/'>https://supsystic.com/documentation/gallery-mosaic-type/</a>")));
        // line 109
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["presets"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["data"]) {
            // line 110
            echo $context["preset"]->getputPreset($context["data"]);
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['data'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 112
        echo "        </div>
    </div>
    <div id=\"gg-create-gallery-loader\" style=\"display: none;\">
        <p class=\"gg-centered\">

        <div class=\"gg-inline-loader gg-centered\"></div>
        </p>
    </div>";
    }

    // line 3
    public function getputPreset($__data__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "data" => $__data__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 4
            echo "    <div class=\"preset supsystic-tooltip";
            if ((($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == false) && $this->getAttribute(($context["data"] ?? null), "pro", array()))) {
                echo "disabled";
            }
            echo "\"
\t\ttitle=\"";
            // line 5
            echo $this->getAttribute(($context["data"] ?? null), "tooltip", array());
            echo "\"
        data-preset=\"";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute(($context["data"] ?? null), "value", array()), "html", null, true);
            echo "\">";
            // line 7
            if (($this->getAttribute(($context["data"] ?? null), "pro", array()) && ($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == false))) {
                // line 8
                echo "            <img onclick=\"document.location='";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["data"] ?? null), "link", array()), "html", null, true);
                echo "'\" src=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["environment"] ?? null), "getModule", array(0 => "galleries"), "method"), "getLocationUrl", array(), "method"), "html", null, true);
                echo "/assets/img/";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["data"] ?? null), "image", array()), "html", null, true);
                echo "\" alt=\"\"/>
            <a class=\"button button-primary\" href=\"";
                // line 9
                echo twig_escape_filter($this->env, $this->getAttribute(($context["data"] ?? null), "link", array()), "html", null, true);
                echo "\" style=\"position: absolute; top: 50%; left: 30%; background-color: #ffffff;\">
                Available in PRO
            </a>";
            } else {
                // line 13
                echo "            <img src=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["environment"] ?? null), "getModule", array(0 => "galleries"), "method"), "getLocationUrl", array(), "method"), "html", null, true);
                echo "/assets/img/";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["data"] ?? null), "image", array()), "html", null, true);
                echo "\" alt=\"\"/>
            <div style=\"position: absolute; top: 50%; left: 50%; transform:translate(-50%, -50%); display:table;\">
                <a class=\"button button-primary button-select\" style=\"background-color: #ffffff;\">
                    Select
                </a>
                <span class=\"selected-preset\">";
                // line 18
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Selected")), "html", null, true);
                echo "</span>
            </div>";
            }
            // line 21
            echo "        <div class=\"preset-overlay\">
            <h3>";
            // line 22
            echo twig_escape_filter($this->env, twig_title_string_filter($this->env, $this->getAttribute(($context["data"] ?? null), "title", array())), "html", null, true);
            echo "</h3>
        </div>
    </div>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "@galleries/gallery_preset.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  167 => 22,  164 => 21,  159 => 18,  148 => 13,  142 => 9,  133 => 8,  131 => 7,  128 => 6,  124 => 5,  117 => 4,  105 => 3,  94 => 112,  88 => 110,  84 => 109,  82 => 65,  80 => 63,  77 => 61,  71 => 55,  67 => 50,  60 => 44,  58 => 41,  56 => 40,  51 => 38,  48 => 37,  46 => 36,  43 => 35,  34 => 31,  32 => 28,  29 => 27,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@galleries/gallery_preset.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Galleries\\views\\gallery_preset.twig");
    }
}
