<?php

/* @galleries/shortcode/gallery.twig */
class __TwigTemplate_9456cce1e54f9c91a526a1bf650b565ec9325ba281a4400c08630efe06a0c78c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'gallery_before' => array($this, 'block_gallery_before'),
            'gallery_attributes' => array($this, 'block_gallery_attributes'),
            'additionalGridGalleryClass' => array($this, 'block_additionalGridGalleryClass'),
            'photos_before' => array($this, 'block_photos_before'),
            'photos_attributes' => array($this, 'block_photos_attributes'),
            'photos_attributes_class' => array($this, 'block_photos_attributes_class'),
            'photos' => array($this, 'block_photos'),
            'photos_after' => array($this, 'block_photos_after'),
            'styleForEffectInclude' => array($this, 'block_styleForEffectInclude'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["style"] = $this->loadTemplate("@galleries/shortcode/style.twig", "@galleries/shortcode/gallery.twig", 1);
        // line 3
        if ((array_key_exists("gallery", $context) &&  !twig_test_empty(($context["gallery"] ?? null)))) {
            // line 4
            $this->displayBlock('gallery_before', $context, $blocks);
            // line 14
            echo "
\t<div";
            // line 16
            $this->displayBlock('gallery_attributes', $context, $blocks);
            // line 209
            echo ">";
            // line 211
            if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "enabled", array()) == "true") || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "enabled", array()) == null))) {
                // line 212
                if (((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "icon_name", array()) == "default") || ($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") != true)) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "enabled", array()) == null))) {
                    // line 213
                    echo "\t\t\t\t<div class=\"gallery-loading\">
\t\t\t\t\t<div class=\"blocks\">
\t\t\t\t\t\t<div class=\"block\"></div>
\t\t\t\t\t\t<div class=\"block\"></div>
\t\t\t\t\t\t<div class=\"block\"></div>
\t\t\t\t\t\t<div class=\"block\"></div>
\t\t\t\t\t</div>
\t\t\t\t</div>";
                } else {
                    // line 222
                    echo "\t\t\t\t<div class=\"gallery-loading\">
\t\t\t\t\t<div class=\"la-";
                    // line 223
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "icon_name", array()), "html", null, true);
                    echo "\" style=\"color:";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "background", array()), "html", null, true);
                    echo "\">";
                    // line 224
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(range(1, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "icon_items", array())));
                    foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                        // line 225
                        echo "\t\t\t\t\t\t\t<div></div>";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 227
                    echo "\t\t\t\t\t</div>
\t\t\t\t</div>";
                }
            }
            // line 232
            $this->displayBlock('photos_before', $context, $blocks);
            // line 235
            if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "socialSharing", array()), "enabled", array())) {
                // line 236
                echo "            <div id=\"social-share-html\" style=\"display:none;\">";
                // line 237
                echo $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "socialSharing", array()), "html", array());
                // line 239
                echo "            </div>";
            }
            // line 241
            echo "
\t\t<div class=\"gallery-sharing-top\"></div>
\t\t<div";
            // line 244
            $this->displayBlock('photos_attributes', $context, $blocks);
            // line 247
            echo ">";
            // line 249
            $this->displayBlock('photos', $context, $blocks);
            // line 257
            echo "
\t\t\t<div class=\"grid-gallery-clearfix\"></div>
\t\t</div>
\t\t<div class=\"gallery-sharing-bottom\"></div>

\t\t<div class=\"grid-gallery-clearfix\"></div>";
            // line 264
            $this->displayBlock('photos_after', $context, $blocks);
            // line 266
            echo "\t</div>
\t
\t<!-- Gallery by Supsystic plugin";
            // line 268
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["environment"] ?? null), "getConfig", array(), "method"), "get", array(0 => "plugin_version"), "method"), "html", null, true);
            if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == true)) {
                echo " /";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["environment"] ?? null), "getConfig", array(), "method"), "get", array(0 => "pro_plugin_version"), "method"), "html", null, true);
            }
            echo " -->";
        }
        // line 271
        $this->displayBlock('styleForEffectInclude', $context, $blocks);
    }

    // line 4
    public function block_gallery_before($context, array $blocks = array())
    {
        // line 5
        if (($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true"))) {
            // line 6
            echo "\t\t\t<style>
\t\t\t\t #grid-gallery-";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "random_val", array()), "html", null, true);
            echo " .";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "effect", array()), "html", null, true);
            echo " .hi-icon { color:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "color", array()), "html", null, true);
            echo " !important; background:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "background", array()), "html", null, true);
            echo " !important; }
\t\t\t\t #grid-gallery-";
            // line 8
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "random_val", array()), "html", null, true);
            echo " .";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "effect", array()), "html", null, true);
            echo " .hi-icon:hover { color:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "hover_color", array()), "html", null, true);
            echo " !important; background:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "background_hover", array()), "html", null, true);
            echo " !important; }
\t\t\t\t #grid-gallery-";
            // line 9
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "random_val", array()), "html", null, true);
            echo " .hi-icon { width:";
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "size", array()) * 2), "html", null, true);
            echo "px !important; height:";
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "size", array()) * 2), "html", null, true);
            echo "px !important; }
\t\t\t\t #grid-gallery-";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
            echo "-";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "random_val", array()), "html", null, true);
            echo " .hi-icon:before { font-size:";
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "size", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "size", array()), 16)) : (16)), "html", null, true);
            echo "px !important; line-height:";
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "size", array()) * 2), "html", null, true);
            echo "px !important; }
\t\t\t</style>";
        }
    }

    // line 16
    public function block_gallery_attributes($context, array $blocks = array())
    {
        // line 17
        echo "\t\t\tid=\"grid-gallery-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "random_val", array()), "html", null, true);
        echo "\"
\t\t\tdata-gg-id=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
        echo "\"
\t\t\tdata-title=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "title", array()), "html", null, true);
        echo "\"
\t\t\tdata-grid-type=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()), "html", null, true);
        echo "\"
\t\t\tdata-offset=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "distance", array()), "html", null, true);
        echo "\"
\t\t\tdata-area-position=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "position", array()), "html", null, true);
        echo "\"
\t\t\tdata-icons=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()), "html", null, true);
        echo "\"
\t\t\tdata-preloader=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "preload", array()), "enabled", array()), "html", null, true);
        echo "\"";
        // line 25
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "2")) {
            // line 26
            echo " \t\t\t\tdata-width=\"auto\"";
        } else {
            // line 28
            echo " \t\t\t\tdata-width=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array()), "html", null, true);
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width_unit", array()) == 1)) {
                echo "%";
            }
            echo "\"";
        }
        // line 30
        echo "\t\t\tdata-height=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height", array()), "html", null, true);
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height_unit", array()) == 1)) {
            echo "%";
        }
        echo "\"
\t\t\tdata-padding=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "padding", array()), "html", null, true);
        echo "\"
\t\t\tdata-quicksand=\"";
        // line 32
        if ((($this->getAttribute(($context["settings"] ?? null), "categories", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "categories", array()), "enabled", array()) == "true")) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "quicksand", array()), "enabled", array()) == "1"))) {
            echo "enabled";
        } else {
            echo "disabled";
        }
        echo "\"
\t\t\tdata-quicksand-duration=\"";
        // line 33
        if ( !twig_test_empty($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "quicksand", array()), "duration", array()))) {
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "quicksand", array()), "duration", array()), "html", null, true);
        } else {
            echo "none";
        }
        echo "\"";
        // line 34
        if (($this->getAttribute(($context["settings"] ?? null), "browserUrlTooltipHide", array(), "any", true, true) && ($this->getAttribute(($context["settings"] ?? null), "browserUrlTooltipHide", array()) == 1))) {
            // line 35
            echo "\t\t\t\tdata-popup-type=\"disable\"";
        } else {
            // line 37
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "enabled", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "enabled", array()) == "false"))) {
                // line 38
                echo "\t\t\t\t\tdata-popup-type=\"disable\"";
            } else {
                // line 40
                echo "\t\t\t\t\tdata-popup-theme=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "theme", array()), "html", null, true);
                echo "\"";
            }
            // line 42
            if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "0") && (($context["mobile"] ?? null) != "true"))) {
                // line 43
                echo "\t\t\t\t\tdata-popup-type=\"colorbox\"
\t\t\t\t\tdata-popup-fadeOut=\"";
                // line 44
                echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "fadeOut", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "fadeOut", array()), 300)) : (300)), "html", null, true);
                echo "\"";
            }
            // line 46
            if (((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "1") && (($context["mobile"] ?? null) != "true")) && ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "enabled", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "enabled", array()), "true")) : ("true")) == "true"))) {
                // line 47
                echo "\t\t\t\t\tdata-popup-type=\"pretty-photo\"";
            }
            // line 49
            if (((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "2") && (($context["mobile"] ?? null) != "true")) && ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "enabled", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "enabled", array()), "true")) : ("true")) == "true"))) {
                // line 50
                echo "\t\t\t\t\tdata-popup-type=\"photobox\"";
            }
            // line 52
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "3")) {
                // line 53
                echo "\t\t\t\t\tdata-columns-number=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "general", array()), "columns", array()), "number", array()), "html", null, true);
                echo "\"";
            }
            // line 55
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "captions", array()) == "on")) {
                // line 56
                echo "\t\t\t\t\tdata-popup-captions=\"hide\"";
            }
            // line 58
            echo "
\t\t\t\tdata-popup-image-text=\"";
            // line 59
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "imageText", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "imageText", array()), "title")) : ("title")), "html", null, true);
            echo "\"";
            // line 61
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "popupwidth", array()) == "")) {
                echo " 
\t\t\t\t\tdata-popup-widthsize=\"auto\"";
            } else {
                // line 63
                echo " 
\t\t\t\t\tdata-popup-widthsize=\"";
                // line 64
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "popupwidth", array()), "html", null, true);
                echo "\"";
            }
            // line 67
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "popupheight", array()) == "")) {
                echo " 
\t\t\t\t\tdata-popup-heightsize=\"auto\"";
            } else {
                // line 69
                echo " 
\t\t\t\t\tdata-popup-heightsize=\"";
                // line 70
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "popupheight", array()), "html", null, true);
                echo "\"";
            }
        }
        // line 74
        $context["popup_i18n_words"] = array("close" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("close")), "next" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("next")), "previous" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("previous")), "start_slideshow" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("start slideshow")), "stop_slideshow" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("stop slideshow")), "image" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("image")), "of" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "prev" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("prev")), "cExpand" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Expand")), "cPrevious" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Previous")), "cNext" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Next")), "cExpandStr" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Expand the image")), "cRotate" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Rotate")), "cDetails" => call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Details")));
        // line 75
        echo "\t\t\tdata-popup-i18n-words=\"";
        echo twig_escape_filter($this->env, twig_jsonencode_filter(($context["popup_i18n_words"] ?? null)));
        echo "\"

            data-popup-slideshow=\"";
        // line 77
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "slideshow", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "slideshow", array()), "false")) : ("false")), "html", null, true);
        echo "\"
\t\t\tdata-popup-slideshow-speed=\"";
        // line 78
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "slideshowSpeed", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "slideshowSpeed", array()), 2500)) : (2500)), "html", null, true);
        echo "\"
\t\t\tdata-popup-hoverstop=\"";
        // line 79
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "popupHoverStop", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "popupHoverStop", array()), "true")) : ("true")), "html", null, true);
        echo "\"
\t\t\tdata-popup-slideshow-auto=\"";
        // line 80
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "slideshowAuto", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "slideshowAuto", array()), "false")) : ("false")), "html", null, true);
        echo "\"
\t\t\tdata-popup-background=\"";
        // line 81
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "background", array()), "html", null, true);
        echo "\"
\t\t\tdata-popup-transparency=\"";
        // line 82
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "transparency", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array(), "any", false, true), "transparency", array()), 30)) : (30)), "html", null, true);
        echo "\"
\t\t\tdata-popup-disable-history=\"";
        // line 83
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "disableHistory", array()), "html", null, true);
        echo "\"
\t\t\tdata-popup-disable-changed-url=\"";
        // line 84
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "disableChangeUrl", array()), "html", null, true);
        echo "\"
\t\t\tdata-popup-border-type=\"";
        // line 85
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "popup", array()), "border", array()), "type", array()), "html", null, true);
        echo "\"
\t\t\tdata-popup-border-color=\"";
        // line 86
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "popup", array()), "border", array()), "color", array()), "html", null, true);
        echo "\"
\t\t\tdata-popup-border-width=\"";
        // line 87
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "popup", array()), "border", array()), "width", array()), "html", null, true);
        echo "\"
\t\t\tdata-popup-border-enable=\"";
        // line 88
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "popup", array()), "border", array()), "enable", array()), "html", null, true);
        echo "\"
\t\t\tdata-fullscreen=\"";
        // line 89
        echo (($this->getAttribute(($context["settings"] ?? null), "fullscreen", array())) ? ("true") : ("false"));
        echo "\"
\t\t\tdata-hide-tooltip=\"";
        // line 90
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "tooltip", array()), "html", null, true);
        echo "\"
\t\t\tdata-caption-font-family=\"";
        // line 91
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "font_family", array()), "html", null, true);
        echo "\"
\t\t\tdata-caption-text-size=\"";
        // line 92
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size", array()), "html", null, true);
        echo twig_escape_filter($this->env, twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size_unit", array()), array(0 => "px", 1 => "%", 2 => "em")), "html", null, true);
        echo "\"
\t\t\tdata-is-mobile=\"";
        // line 93
        echo twig_escape_filter($this->env, ((array_key_exists("isMobile", $context)) ? (_twig_default_filter(($context["isMobile"] ?? null), "0")) : ("0")), "html", null, true);
        echo "\"
\t\t\tdata-caption-mobile=\"";
        // line 94
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "isMobile", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "isMobile", array()), "false")) : ("false")), "html", null, true);
        echo "\"";
        // line 95
        echo "\t\t\tdata-hide-long-tltp-title=\"";
        echo ((($this->getAttribute(($context["settings"] ?? null), "hideLongTooltipTitles", array()) == "on")) ? ("1") : ("0"));
        echo "\"
\t\t\tdata-caption-disabled-on-mobile=\"";
        // line 96
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "isDisableMobileCaption", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "isDisableMobileCaption", array()), "false")) : ("false")), "html", null, true);
        echo "\"";
        // line 97
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array()), "enabled", array()) == "1")) {
            echo " 
\t\t\t\tdata-lazyload-enable='1' 
\t\t\t\tdata-lazyload-effect=\"";
            // line 99
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array(), "any", false, true), "animationEffect", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array(), "any", false, true), "animationEffect", array()), "show")) : ("show")), "html", null, true);
            echo "\"
\t\t\t\tdata-lazyload-effect-duration=\"";
            // line 100
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array(), "any", false, true), "effectDuration", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array(), "any", false, true), "effectDuration", array()), "400")) : ("400")), "html", null, true);
            echo "\"";
        }
        // line 102
        if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()) == "polaroid")) {
            // line 103
            echo "\t\t\t\tdata-polaroid-animation=\"";
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "overlay", array(), "any", false, true), "polaroidAnimation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "overlay", array(), "any", false, true), "polaroidAnimation", array()), "true")) : ("true")), "html", null, true);
            echo "\"
\t\t\t\tdata-polaroid-scattering=\"";
            // line 104
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "overlay", array(), "any", false, true), "polaroidScattering", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "overlay", array(), "any", false, true), "polaroidScattering", array()), "true")) : ("true")), "html", null, true);
            echo "\"
\t\t\t\tdata-polaroid-frame-width=\"";
            // line 105
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "overlay", array(), "any", false, true), "polaroidFrameWidth", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "overlay", array(), "any", false, true), "polaroidFrameWidth", array()), 20)) : (20)), "html", null, true);
            echo "\"";
            // line 106
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "captionBuilder", array()), "enabled", array()) == "1")) {
                // line 107
                echo "\t\t\t\t\tdata-polaroid-caption-height=\"";
                echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "captionBuilder", array(), "any", false, true), "title", array(), "any", false, true), "height", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "captionBuilder", array(), "any", false, true), "title", array(), "any", false, true), "height", array()), 50)) : (50)), "html", null, true);
                echo "\"";
            }
        }
        // line 110
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "3")) {
            // line 111
            echo "\t\t\t\tdata-responsive-colums=\"";
            echo twig_escape_filter($this->env, twig_jsonencode_filter((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "general", array(), "any", false, true), "responsiveColumns", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "general", array(), "any", false, true), "responsiveColumns", array()), "")) : (""))));
            echo "\"";
        }
        // line 113
        if (($this->getAttribute(($context["settings"] ?? null), "horizontalScroll", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "horizontalScroll", array()), "enabled", array()) == "true"))) {
            // line 114
            echo "\t\t\t\tdata-horizontal-scroll=\"";
            echo twig_escape_filter($this->env, twig_jsonencode_filter($this->getAttribute(($context["settings"] ?? null), "horizontalScroll", array())));
            echo "\"";
        }
        // line 116
        if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "personal", array()) == "true")) {
            // line 117
            echo "\t\t\t\tdata-thumb-overlay-personal=\"1\"";
        }
        // line 119
        echo "\t\t\tdata-popup-placement-type=\"";
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "popup", array(), "any", false, true), "placementType", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "popup", array(), "any", false, true), "placementType", array()), 0)) : (0)), "html", null, true);
        echo "\"";
        // line 121
        $context["imageSharingButPos"] = $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "socialSharing", array()), "imageSharing", array()), "buttonsPosition", array());
        // line 122
        $context["imageSharingWrapperClass"] = (($context["imageSharingButPos"] ?? null) . " ");
        // line 123
        if (((($context["imageSharingButPos"] ?? null) == "top") || (($context["imageSharingButPos"] ?? null) == "bottom"))) {
            // line 124
            $context["imageSharingWrapperClass"] = (($context["imageSharingWrapperClass"] ?? null) . $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "socialSharing", array()), "imageSharing", array()), "buttonsAlignHorizontal", array()));
        } else {
            // line 126
            $context["imageSharingWrapperClass"] = ((($context["imageSharingWrapperClass"] ?? null) . "vertical ") . $this->getAttribute($this->getAttribute($this->getAttribute(            // line 127
($context["settings"] ?? null), "socialSharing", array()), "imageSharing", array()), "buttonsAlignVertical", array()));
        }
        // line 141
        $context["socialSharing"] = array("enabled" => $this->getAttribute($this->getAttribute(        // line 142
($context["settings"] ?? null), "socialSharing", array()), "enabled", array()), "gallerySharing" => array("enabled" => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 144
($context["settings"] ?? null), "socialSharing", array()), "gallerySharing", array()), "enabled", array()), "position" => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 145
($context["settings"] ?? null), "socialSharing", array()), "gallerySharing", array()), "buttonsPosition", array())), "imageSharing" => array("enabled" => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 148
($context["settings"] ?? null), "socialSharing", array()), "imageSharing", array()), "enabled", array()), "wrapperClass" => $this->getAttribute(        // line 149
$this, "getSocialSharingWrapperClass", array(0 => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 150
($context["settings"] ?? null), "socialSharing", array()), "imageSharing", array()), "buttonsPosition", array()), 1 => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 151
($context["settings"] ?? null), "socialSharing", array()), "imageSharing", array()), "buttonsAlignHorizontal", array()), 2 => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 152
($context["settings"] ?? null), "socialSharing", array()), "imageSharing", array()), "buttonsAlignVertical", array())), "method")), "popupSharing" => array("enabled" => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 156
($context["settings"] ?? null), "socialSharing", array()), "popupImageSharing", array()), "enabled", array()), "wrapperClass" => $this->getAttribute(        // line 157
$this, "getSocialSharingWrapperClass", array(0 => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 158
($context["settings"] ?? null), "socialSharing", array()), "popupImageSharing", array()), "buttonsPosition", array()), 1 => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 159
($context["settings"] ?? null), "socialSharing", array()), "popupImageSharing", array()), "buttonsAlignHorizontal", array()), 2 => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 160
($context["settings"] ?? null), "socialSharing", array()), "popupImageSharing", array()), "buttonsAlignVertical", array())), "method")));
        // line 166
        echo "\t\t\tdata-social-sharing=\"";
        echo twig_escape_filter($this->env, twig_jsonencode_filter(($context["socialSharing"] ?? null)));
        echo "\"";
        // line 167
        ob_start();
        // line 168
        $this->displayBlock('additionalGridGalleryClass', $context, $blocks);
        $context["varAdditionalGalleryClass"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 176
        echo "\t\t\tclass=\"grid-gallery";
        // line 177
        echo twig_escape_filter($this->env, ($context["varAdditionalGalleryClass"] ?? null), "html", null, true);
        // line 178
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbs", array()), "enable", array()) == "1")) {
            // line 179
            echo "\t\t\t\t\tgrid-gallery-thumbs";
        }
        // line 182
        if ((($this->getAttribute($this->getAttribute(($context["environment"] ?? null), "getConfig", array(), "method"), "get", array(0 => "optimizations"), "method") == 1) && ($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == false))) {
            // line 183
            echo "\t\t\t\t\t\toptimizations";
        }
        // line 186
        if (($this->getAttribute(($context["settings"] ?? null), "openByLink", array()) == "on")) {
            // line 187
            echo "\t\t\t\t    hidden-item";
        }
        // line 190
        if (($this->getAttribute(($context["settings"] ?? null), "displayFirstPhoto", array()) == "on")) {
            // line 191
            echo "\t\t\t\t    one-photo";
        }
        // line 193
        echo "                \"
\t\t\tstyle=\"
\t\t\t\twidth:";
        // line 195
        echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "width", array()) . twig_replace_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "width_unit", array()), array(0 => "px", 1 => "%"))), "html", null, true);
        echo ";
\t\t\t\theight:";
        // line 196
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array(), "any", false, true), "height", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array(), "any", false, true), "height", array()), "auto")) : ("auto")), "html", null, true);
        // line 197
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "height", array()) != "auto") && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "height", array()) != null))) {
            echo "px";
        }
        echo ";";
        // line 198
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "position", array()) == "1") || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "position", array()) == "left"))) {
            // line 199
            echo "\t\t\t\t\tfloat: left;";
        }
        // line 201
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "position", array()) == "2") || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "position", array()) == "right"))) {
            // line 202
            echo "\t\t\t\t\tfloat: left;";
        }
        // line 204
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "position", array()) == "center")) {
            // line 205
            echo "\t\t\t\tmargin-left:auto;
\t\t\t\tmargin-right:auto;";
        }
        // line 208
        if ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "fullscreen", array()), "enabled", array())) {
            echo "position: fixed; z-index: 9999999; top: 0; left: 0; background-color: white;";
        } else {
            echo "position:relative;";
        }
        echo "\"";
    }

    // line 168
    public function block_additionalGridGalleryClass($context, array $blocks = array())
    {
        // line 169
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "1")) {
            // line 170
            echo "\t\t\t\t\t\tgrid-gallery-fluid-height";
        } else {
            // line 172
            echo "\t\t\t\t\t\tgrid-gallery-fixed";
        }
    }

    // line 232
    public function block_photos_before($context, array $blocks = array())
    {
    }

    // line 244
    public function block_photos_attributes($context, array $blocks = array())
    {
        // line 245
        echo "\t\t\t\tid=\"photos-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
        echo "\"
\t\t\t\tclass=\"grid-gallery-photos";
        // line 246
        $this->displayBlock('photos_attributes_class', $context, $blocks);
        echo "\"";
    }

    public function block_photos_attributes_class($context, array $blocks = array())
    {
    }

    // line 249
    public function block_photos($context, array $blocks = array())
    {
        // line 250
        $context["i"] = 0;
        // line 252
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["gallery"] ?? null), "photos", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["photo"]) {
            // line 253
            $this->loadTemplate("@galleries/shortcode/helpers.twig", "@galleries/shortcode/gallery.twig", 253)->display(array("gallery" => ($context["gallery"] ?? null), "photo" => $context["photo"], "settings" => ($context["settings"] ?? null), "index" => ($context["i"] ?? null)));
            // line 254
            $context["i"] = (($context["i"] ?? null) + 1);
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['photo'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    // line 264
    public function block_photos_after($context, array $blocks = array())
    {
    }

    // line 271
    public function block_styleForEffectInclude($context, array $blocks = array())
    {
        // line 272
        $this->loadTemplate("@galleries/shortcode/style_for_effects.twig", "@galleries/shortcode/gallery.twig", 272)->display(array_merge($context, array("gallery" => ($context["gallery"] ?? null), "settings" => ($context["settings"] ?? null))));
    }

    // line 130
    public function getgetSocialSharingWrapperClass($__position__ = null, $__horizontalAlign__ = null, $__verticalAlign__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "position" => $__position__,
            "horizontalAlign" => $__horizontalAlign__,
            "verticalAlign" => $__verticalAlign__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 131
            $context["class"] = (($context["position"] ?? null) . " ");
            // line 132
            if (((($context["position"] ?? null) == "top") || (($context["position"] ?? null) == "bottom"))) {
                // line 133
                $context["class"] = (($context["class"] ?? null) . ($context["horizontalAlign"] ?? null));
            } else {
                // line 135
                $context["class"] = ((($context["class"] ?? null) . "vertical ") .                 // line 136
($context["verticalAlign"] ?? null));
            }
            // line 138
            echo twig_escape_filter($this->env, ($context["class"] ?? null), "html", null, true);
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
        return "@galleries/shortcode/gallery.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  671 => 138,  668 => 136,  667 => 135,  664 => 133,  662 => 132,  660 => 131,  646 => 130,  642 => 272,  639 => 271,  634 => 264,  626 => 254,  624 => 253,  620 => 252,  618 => 250,  615 => 249,  606 => 246,  601 => 245,  598 => 244,  593 => 232,  588 => 172,  585 => 170,  583 => 169,  580 => 168,  571 => 208,  567 => 205,  565 => 204,  562 => 202,  560 => 201,  557 => 199,  555 => 198,  550 => 197,  548 => 196,  544 => 195,  540 => 193,  537 => 191,  535 => 190,  532 => 187,  530 => 186,  527 => 183,  525 => 182,  522 => 179,  520 => 178,  518 => 177,  516 => 176,  513 => 168,  511 => 167,  507 => 166,  505 => 160,  504 => 159,  503 => 158,  502 => 157,  501 => 156,  500 => 152,  499 => 151,  498 => 150,  497 => 149,  496 => 148,  495 => 145,  494 => 144,  493 => 142,  492 => 141,  489 => 127,  488 => 126,  485 => 124,  483 => 123,  481 => 122,  479 => 121,  475 => 119,  472 => 117,  470 => 116,  465 => 114,  463 => 113,  458 => 111,  456 => 110,  450 => 107,  448 => 106,  445 => 105,  441 => 104,  436 => 103,  434 => 102,  430 => 100,  426 => 99,  421 => 97,  418 => 96,  413 => 95,  410 => 94,  406 => 93,  401 => 92,  397 => 91,  393 => 90,  389 => 89,  385 => 88,  381 => 87,  377 => 86,  373 => 85,  369 => 84,  365 => 83,  361 => 82,  357 => 81,  353 => 80,  349 => 79,  345 => 78,  341 => 77,  335 => 75,  333 => 74,  328 => 70,  325 => 69,  320 => 67,  316 => 64,  313 => 63,  308 => 61,  305 => 59,  302 => 58,  299 => 56,  297 => 55,  292 => 53,  290 => 52,  287 => 50,  285 => 49,  282 => 47,  280 => 46,  276 => 44,  273 => 43,  271 => 42,  266 => 40,  263 => 38,  261 => 37,  258 => 35,  256 => 34,  249 => 33,  241 => 32,  237 => 31,  229 => 30,  221 => 28,  218 => 26,  216 => 25,  213 => 24,  209 => 23,  205 => 22,  201 => 21,  197 => 20,  193 => 19,  189 => 18,  182 => 17,  179 => 16,  166 => 10,  156 => 9,  144 => 8,  132 => 7,  129 => 6,  127 => 5,  124 => 4,  120 => 271,  112 => 268,  108 => 266,  106 => 264,  99 => 257,  97 => 249,  95 => 247,  93 => 244,  89 => 241,  86 => 239,  84 => 237,  82 => 236,  80 => 235,  78 => 232,  73 => 227,  67 => 225,  63 => 224,  58 => 223,  55 => 222,  45 => 213,  43 => 212,  41 => 211,  39 => 209,  37 => 16,  34 => 14,  32 => 4,  30 => 3,  28 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@galleries/shortcode/gallery.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Galleries\\views\\shortcode\\gallery.twig");
    }
}
