<?php

/* @galleries/shortcode/helpers.twig */
class __TwigTemplate_9490b9a88024aec95dbbdc1f41304a8528652e9874c1d2575dd33aad990ce1b0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'ggFigureWidth' => array($this, 'block_ggFigureWidth'),
            'ggMosaicHiddenItem' => array($this, 'block_ggMosaicHiddenItem'),
            'a_attributes' => array($this, 'block_a_attributes'),
            'a_attributes_class_set' => array($this, 'block_a_attributes_class_set'),
            'a_attributes_href' => array($this, 'block_a_attributes_href'),
            'sggPopupLinkForDetailsButton' => array($this, 'block_sggPopupLinkForDetailsButton'),
            'figure_before' => array($this, 'block_figure_before'),
            'galleryTypeBlock' => array($this, 'block_galleryTypeBlock'),
            'figure_attributes' => array($this, 'block_figure_attributes'),
            'previewImageUrlVar' => array($this, 'block_previewImageUrlVar'),
            'imageAttributesStyleSize' => array($this, 'block_imageAttributesStyleSize'),
            'image_attributes' => array($this, 'block_image_attributes'),
            'figcaption_style' => array($this, 'block_figcaption_style'),
            'figcaption_class' => array($this, 'block_figcaption_class'),
            'figcaption_attributes' => array($this, 'block_figcaption_attributes'),
            'figcaption_wrap' => array($this, 'block_figcaption_wrap'),
            'ggImageCaptionEntry' => array($this, 'block_ggImageCaptionEntry'),
            'figcaption_after' => array($this, 'block_figcaption_after'),
            'figcaption_after_set_exif' => array($this, 'block_figcaption_after_set_exif'),
            'figure_after' => array($this, 'block_figure_after'),
            'oneGalleryImage' => array($this, 'block_oneGalleryImage'),
            'mosaicLastImageNumberWrapper' => array($this, 'block_mosaicLastImageNumberWrapper'),
            'mosaicFigcaptionWrapper' => array($this, 'block_mosaicFigcaptionWrapper'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        ob_start();
        // line 2
        if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "type", array()) != "none")) {
            // line 3
            echo "\t\tborder:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "width", array()), "html", null, true);
            echo "px";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "type", array()), "html", null, true);
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "color", array()), "html", null, true);
            echo ";";
        }
        // line 5
        echo "\tborder-radius:";
        echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "radius", array()) . twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "radius_unit", array()), array(0 => "px", 1 => "%"))), "html", null, true);
        echo ";";
        // line 6
        if (($this->getAttribute(($context["settings"] ?? null), "use_shadow", array()) == 1)) {
            // line 7
            echo "\t\tbox-shadow:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "shadow", array()), "x", array()), "html", null, true);
            echo "px";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "shadow", array()), "y", array()), "html", null, true);
            echo "px";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "shadow", array()), "blur", array()), "html", null, true);
            echo "px";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "shadow", array()), "color", array()), "html", null, true);
            echo ";";
        }
        // line 8
        echo ";";
        // line 10
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "2")) {
            // line 11
            $context["newImageDistance"] = ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "distance", array()) / 2);
            // line 12
            echo "\t\tmargin:";
            echo twig_escape_filter($this->env, ((array_key_exists("newImageDistance", $context)) ? (_twig_default_filter(($context["newImageDistance"] ?? null), 0)) : (0)), "html", null, true);
            echo "px;";
        } else {
            // line 14
            echo "\t\tmargin:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "distance", array()), "html", null, true);
            echo "px;";
        }
        // line 18
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "2")) {
            // line 19
            echo "\t\theight:";
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height", array()) . twig_replace_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height_unit", array()), array(0 => "px", 1 => "%"))), "html", null, true);
            echo ";";
        }
        // line 21
        $this->displayBlock('ggFigureWidth', $context, $blocks);
        $context["figureStyle"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 30
        ob_start();
        // line 31
        if (($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "description", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "description", array())))) {
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "description", array()), "html", null, true);
        } else {
            // line 34
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "title", array()), "html", null, true);
        }
        $context["aTitle"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 38
        if ((array_key_exists("mosaicParams", $context) && ($this->getAttribute(($context["mosaicParams"] ?? null), "photoCountLeft", array()) > 0))) {
            // line 39
            $context["is_ext_link"] = false;
        } else {
            // line 41
            $context["is_ext_link"] = ($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "external_link", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "external_link", array())));
        }
        // line 44
        ob_start();
        // line 45
        if ((((($context["is_ext_link"] ?? null) == false) && ( !$this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "video", array(), "any", true, true) || twig_test_empty(twig_trim_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array()))))) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "0"))) {
            // line 46
            echo "\t\tgg-colorbox";
        }
        // line 49
        if ((($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "video", array(), "any", true, true) &&  !twig_test_empty(twig_trim_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array())))) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "0"))) {
            // line 50
            echo "\t\tgg-video";
        }
        // line 53
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "2") && ((($context["is_ext_link"] ?? null) == false) || ($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "video", array(), "any", true, true) &&  !twig_test_empty(twig_trim_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array()))))))) {
            // line 54
            echo "\t\tpbox";
        }
        $context["aClass"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 58
        ob_start();
        // line 59
        if ((($context["is_ext_link"] ?? null) == true)) {
            // line 60
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('force_http')->getCallable(), array($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "external_link", array()))), "html", null, true);
            // line 61
            $context["link"] = true;
        } else {
            // line 63
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "url", array()) . "?gid=") . $this->getAttribute(($context["gallery"] ?? null), "id", array())), "html", null, true);
        }
        $context["aHref"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 67
        ob_start();
        // line 68
        if ((($context["link"] ?? null) && $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "rel", array(), "any", true, true))) {
            // line 69
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "rel", array()), "html", null, true);
        }
        // line 71
        if (((($context["link"] ?? null) == false) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "enabled", array()) == "false"))) {
            // line 72
            echo "\t\tnofollow";
        }
        $context["aRel"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 76
        ob_start();
        // line 78
        ob_start();
        // line 79
        $this->displayBlock('ggMosaicHiddenItem', $context, $blocks);
        $context["ggMosaicHiddenItemVar"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 84
        ob_start();
        // line 85
        $this->displayBlock('a_attributes', $context, $blocks);
        $context["var_a_attributes"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 120
        ob_start();
        // line 121
        $this->displayBlock('figure_before', $context, $blocks);
        $context["var_figure_before"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 128
        ob_start();
        // line 129
        $this->displayBlock('galleryTypeBlock', $context, $blocks);
        $context["galleryType"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 154
        ob_start();
        // line 155
        $this->displayBlock('figure_attributes', $context, $blocks);
        $context["var_figure_attributes"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 180
        list($context["width"], $context["height"], $context["crop"]) =         array(0, 0, 0);
        // line 182
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width_unit", array()) == 0)) {
            // line 183
            $context["width"] = $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array());
        } else {
            // line 186
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "width_unit", array()) == 0)) {
                // line 187
                $context["width"] = round((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "width", array()) / 100) * $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array())));
            } else {
                // line 189
                $context["width"] = null;
            }
        }
        // line 193
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height_unit", array()) == 0)) {
            // line 194
            $context["height"] = $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height", array());
        } else {
            // line 197
            $context["height"] = null;
        }
        // line 205
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == 0) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == 3))) {
            // line 206
            $context["crop"] = 1;
        }
        // line 209
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == 1)) {
            // line 210
            $context["height"] = null;
        }
        // line 213
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == 2)) {
            // line 214
            $context["width"] = null;
        }
        // line 217
        ob_start();
        // line 218
        $this->displayBlock('previewImageUrlVar', $context, $blocks);
        $context["previewImgUrl"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 227
        ob_start();
        // line 228
        $this->displayBlock('imageAttributesStyleSize', $context, $blocks);
        $context["imageAttributesStyleSizeVar"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 241
        ob_start();
        // line 242
        $this->displayBlock('image_attributes', $context, $blocks);
        $context["var_image_attributes"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 272
        ob_start();
        // line 273
        $this->displayBlock('figcaption_style', $context, $blocks);
        $context["figcaptionStyle"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 298
        ob_start();
        // line 299
        echo "\t\tclass=\"";
        $this->displayBlock('figcaption_class', $context, $blocks);
        echo "\"";
        // line 300
        $this->displayBlock('figcaption_attributes', $context, $blocks);
        $context["var_figcaption_attributes"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 310
        $context["prepareImgUrl"] = (($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "url", array()) . "?gid=") . $this->getAttribute(($context["gallery"] ?? null), "id", array()));
        // line 312
        ob_start();
        // line 313
        $this->displayBlock('figcaption_wrap', $context, $blocks);
        $context["var_figcaption_wrap"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 443
        ob_start();
        // line 444
        $this->displayBlock('figcaption_after', $context, $blocks);
        $context["var_figcaption_after"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 486
        ob_start();
        // line 487
        $this->displayBlock('figure_after', $context, $blocks);
        $context["var_figure_after"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 495
        $this->displayBlock('oneGalleryImage', $context, $blocks);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 21
    public function block_ggFigureWidth($context, array $blocks = array())
    {
        // line 22
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "2")) {
            // line 23
            echo "\t\t\twidth:auto;";
        } else {
            // line 25
            echo "\t\t\twidth:";
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array()) . twig_replace_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width_unit", array()), array(0 => "px", 1 => "%"))), "html", null, true);
            echo ";";
        }
    }

    // line 79
    public function block_ggMosaicHiddenItem($context, array $blocks = array())
    {
    }

    // line 85
    public function block_a_attributes($context, array $blocks = array())
    {
        // line 86
        echo "
\t\t\tid=\"gg-";
        // line 87
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
        echo "-";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["photo"] ?? null), "id", array()), "html", null, true);
        echo "\"";
        // line 89
        $this->displayBlock('a_attributes_class_set', $context, $blocks);
        // line 93
        echo twig_escape_filter($this->env, ($context["ggMosaicHiddenItemVar"] ?? null), "html", null, true);
        // line 94
        $this->displayBlock('a_attributes_href', $context, $blocks);
        // line 99
        if (($this->getAttribute(($context["settings"] ?? null), "disableImageTitle", array()) != 1)) {
            // line 100
            echo "\t\t\t\ttitle=\"";
            echo twig_escape_filter($this->env, twig_trim_filter(($context["aTitle"] ?? null)), "html", null, true);
            echo "\"";
        }
        // line 103
        $this->displayBlock('sggPopupLinkForDetailsButton', $context, $blocks);
        // line 116
        echo "\t\t\tstyle=\"border-radius:";
        echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "radius", array()) . twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "border", array()), "radius_unit", array()), array(0 => "px", 1 => "%"))), "html", null, true);
        echo ";\"";
    }

    // line 89
    public function block_a_attributes_class_set($context, array $blocks = array())
    {
        // line 90
        echo "\t\t\t\tclass=\"gg-link";
        echo twig_escape_filter($this->env, twig_trim_filter(($context["aClass"] ?? null)), "html", null, true);
        if ((($this->getAttribute(($context["settings"] ?? null), "displayFirstPhoto", array()) == "on") && (($context["index"] ?? null) > 0))) {
            echo " hidden-item";
        }
        echo "\"";
    }

    // line 94
    public function block_a_attributes_href($context, array $blocks = array())
    {
        // line 95
        echo "\t\t\t\thref=\"";
        echo twig_escape_filter($this->env, htmlspecialchars_decode(twig_trim_filter(($context["aHref"] ?? null))), "html", null, true);
        echo "\"
\t\t\t\ttarget=\"";
        // line 96
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "target", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "target", array()), "_self")) : ("_self")), "html", null, true);
        echo "\"";
    }

    // line 103
    public function block_sggPopupLinkForDetailsButton($context, array $blocks = array())
    {
        // line 105
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "1") && (($context["link"] ?? null) == false))) {
            // line 106
            echo "\t\t\t\t\tdata-rel=\"prettyPhoto[pp_gal]\"";
        } elseif (($this->getAttribute($this->getAttribute(        // line 107
($context["photo"] ?? null), "attachment", array()), "video", array()) == null)) {
            // line 108
            echo "\t\t\t\t\trel=\"";
            echo twig_escape_filter($this->env, twig_trim_filter(($context["aRel"] ?? null)), "html", null, true);
            echo "\"";
        }
        // line 112
        if ((($context["link"] ?? null) == true)) {
            // line 113
            echo "\t\t\t\t\tdata-type=\"link\"";
        }
    }

    // line 121
    public function block_figure_before($context, array $blocks = array())
    {
        // line 122
        if (( !$this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "false"))) {
            // line 123
            echo "\t\t\t\t<a";
            echo twig_escape_filter($this->env, ($context["var_a_attributes"] ?? null), "html", null, true);
            echo " >";
        }
    }

    // line 129
    public function block_galleryTypeBlock($context, array $blocks = array())
    {
        // line 130
        if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "enabled", array()) == "false")) {
            // line 131
            if (($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true"))) {
                // line 132
                echo "\t\t\t\t\ticons";
            } else {
                // line 134
                echo "\t\t\t\t\tnone";
            }
        } else {
            // line 137
            if (($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true"))) {
                // line 138
                if ((($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "personal", array()) == "true") && twig_in_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "captionEffect", array()), array(0 => "icons", 1 => "icons-scale", 2 => "icons-sodium-left", 3 => "icons-sodium-top", 4 => "icons-nitrogen-top")))) {
                    // line 139
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "captionEffect", array()), "html", null, true);
                } else {
                    // line 141
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()), "html", null, true);
                }
            } else {
                // line 144
                if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "personal", array()) == "true")) {
                    // line 145
                    echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "captionEffect", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "captionEffect", array()), $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()))) : ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()))), "html", null, true);
                } else {
                    // line 147
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()), "html", null, true);
                }
            }
        }
    }

    // line 155
    public function block_figure_attributes($context, array $blocks = array())
    {
        // line 156
        echo "\t\t\tclass=\"grid-gallery-caption";
        // line 157
        if ((($this->getAttribute(($context["settings"] ?? null), "displayFirstPhoto", array()) == "on") && (($context["index"] ?? null) > 0))) {
            echo " hidden-item";
        }
        // line 158
        echo twig_escape_filter($this->env, ($context["ggMosaicHiddenItemVar"] ?? null), "html", null, true);
        // line 159
        if ((($this->getAttribute(($context["settings"] ?? null), "mouse_shadow", array()) == "1") && ($this->getAttribute(($context["settings"] ?? null), "use_shadow", array()) == "1"))) {
            // line 160
            echo "\t\t\t\tshadow-show";
        }
        // line 162
        if ((($this->getAttribute(($context["settings"] ?? null), "mouse_shadow", array()) == "2") && ($this->getAttribute(($context["settings"] ?? null), "use_shadow", array()) == "1"))) {
            // line 163
            echo "\t\t\t\tshadow-hide";
        }
        // line 164
        echo "\"
\t\t\tdata-grid-gallery-type=\"";
        // line 165
        echo twig_escape_filter($this->env, twig_trim_filter(($context["galleryType"] ?? null)), "html", null, true);
        echo "\"
\t\t\tdata-index=\"";
        // line 166
        echo twig_escape_filter($this->env, ($context["index"] ?? null), "html", null, true);
        echo "\"
\t\t\tstyle=\"display:none;";
        // line 167
        echo twig_escape_filter($this->env, twig_trim_filter(($context["figureStyle"] ?? null)), "html", null, true);
        echo "\"";
        // line 168
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true")) {
            // line 169
            ob_start();
            // line 170
            if (twig_in_filter("icons", $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()))) {
                // line 171
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()), "html", null, true);
            } else {
                // line 173
                echo "\t\t\t\t\t\t\ticons";
            }
            $context["galleryType"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        }
    }

    // line 218
    public function block_previewImageUrlVar($context, array $blocks = array())
    {
        // line 219
        if (($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "isNotRealAttachment", array()) == 1)) {
            // line 220
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "url", array()), "html", null, true);
        } else {
            // line 222
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('get_attachment')->getCallable(), array($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "id", array()), ($context["width"] ?? null), ($context["height"] ?? null), $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "cropPosition", array()), (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "cropQuality", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array(), "any", false, true), "cropQuality", array()), "100")) : ("100")))), "html", null, true);
        }
    }

    // line 228
    public function block_imageAttributesStyleSize($context, array $blocks = array())
    {
        // line 229
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width_unit", array()) == 0) &&  !twig_test_empty($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array())))) {
            // line 230
            echo "\t\t\t\twidth:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array()), "html", null, true);
            echo "px;";
        }
        // line 232
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height_unit", array()) == 0) &&  !twig_test_empty($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height", array())))) {
            // line 233
            echo "\t\t\t\theight:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height", array()), "html", null, true);
            echo "px;";
            // line 234
            if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width_unit", array()) != 0) || twig_test_empty($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array())))) {
                // line 235
                echo "\t\t\t\t\twidth:auto;";
            }
        }
    }

    // line 242
    public function block_image_attributes($context, array $blocks = array())
    {
        // line 243
        $context["imgSrcStr"] = htmlspecialchars_decode(twig_replace_filter(twig_trim_filter(($context["previewImgUrl"] ?? null)), "/%20\$/", ""));
        // line 244
        $context["imgClassStr"] = "ggImg";
        // line 245
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array()), "enabled", array()) == "1")) {
            // line 246
            echo "\t\t\t\tdata-gg-real-image-href=\"";
            echo twig_escape_filter($this->env, ($context["imgSrcStr"] ?? null), "html", null, true);
            echo "\"";
            // line 248
            if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array()), "hideLoader", array()) != "true") && twig_length_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array()), "defaultImgUrl", array())))) {
                // line 249
                $context["imgSrcStr"] = $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array()), "defaultImgUrl", array());
            } else {
                // line 251
                $context["imgSrcStr"] = $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "lazyload", array()), "leerImgUrl", array());
            }
            // line 253
            $context["imgClassStr"] = (($context["imgClassStr"] ?? null) . " ggLazyImg");
        }
        // line 256
        if (((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == 2) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == 3)) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == 4))) {
            // line 257
            $context["imgClassStr"] = (($context["imgClassStr"] ?? null) . " ggNotInitImg");
        }
        // line 259
        echo "\t\t\tsrc=\"";
        echo twig_escape_filter($this->env, ($context["imgSrcStr"] ?? null), "html", null, true);
        echo "\"
\t\t\tclass=\"";
        // line 260
        echo twig_escape_filter($this->env, ($context["imgClassStr"] ?? null), "html", null, true);
        echo "\"
\t\t\talt=\"";
        // line 261
        if ((twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "alt", array())) || ($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "alt", array()) == " "))) {
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "title", array()), "html", null, true);
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "alt", array()), "html", null, true);
        }
        echo "\"";
        // line 262
        if (($this->getAttribute(($context["settings"] ?? null), "disableImageTitle", array()) != 1)) {
            // line 263
            echo "\t\t\t\ttitle=\"";
            if ( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "description", array()))) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "description", array()), "html", null, true);
            } else {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "title", array()), "html", null, true);
            }
            echo "\"";
        }
        // line 265
        echo "\t\t\tdata-description=\"";
        if ( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "description", array()))) {
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "description", array()), "html", null, true);
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "title", array()), "html", null, true);
        }
        echo "\"
\t\t\tdata-caption=\"";
        // line 266
        if ( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "caption", array()))) {
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "caption", array()));
        } else {
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "title", array()));
        }
        echo "\"
\t\t\tdata-title=\"";
        // line 267
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "title", array()), "html", null, true);
        echo "\"
\t\t\tstyle=\"";
        // line 268
        echo twig_escape_filter($this->env, ($context["imageAttributesStyleSizeVar"] ?? null), "html", null, true);
        echo "\"";
    }

    // line 273
    public function block_figcaption_style($context, array $blocks = array())
    {
        // line 274
        if (($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true"))) {
            // line 275
            echo "\t\t\t\tfont-family:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "font_family", array()), "html", null, true);
            echo ";";
            // line 276
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "overlay_enabled", array()) == "true")) {
                // line 277
                echo "\t\t\t\t\tbackground-color:";
                echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "overlay_color", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "overlay_color", array()), "#3498db")) : ("#3498db")), "html", null, true);
                echo ";
\t\t\t\t\theight : 100%;";
            } else {
                // line 281
                echo "\t\t\t\t\theight : 100%;
\t\t\t\t\tbackground-color: transparent;";
            }
        } else {
            // line 285
            echo "\t\t\t\tcolor:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "foreground", array()), "html", null, true);
            echo ";
\t\t\t\tbackground-color:";
            // line 286
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "background", array()), "html", null, true);
            echo ";
\t\t\t\tfont-size:";
            // line 287
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size", array()), "html", null, true);
            echo twig_escape_filter($this->env, twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size_unit", array()), array(0 => "px", 1 => "%", 2 => "em")), "html", null, true);
            echo ";
\t\t\t\ttext-align:";
            // line 288
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_align", array()), "html", null, true);
            echo ";
\t\t\t\tfont-family:";
            // line 289
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "font_family", array()), "html", null, true);
            echo ";";
            // line 290
            if ((($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()) == "none") || ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "enabled", array()) == "false"))) {
                // line 291
                echo "\t\t\t\t\topacity:1;
\t\t\t\t\tbottom:0;";
            }
        }
    }

    // line 299
    public function block_figcaption_class($context, array $blocks = array())
    {
    }

    // line 300
    public function block_figcaption_attributes($context, array $blocks = array())
    {
        // line 301
        if (($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true"))) {
            // line 302
            echo "\t\t\t\tdata-alpha=\"";
            echo twig_escape_filter($this->env, twig_trim_filter((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "overlay_transparency", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "overlay_transparency", array()), 5)) : (5))), "html", null, true);
            echo "\"";
        } else {
            // line 304
            echo "\t\t\t\tdata-alpha=\"";
            echo twig_escape_filter($this->env, twig_trim_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "transparency", array())), "html", null, true);
            echo "\"";
        }
        // line 306
        echo "\t\t\tstyle=\"";
        echo twig_escape_filter($this->env, twig_trim_filter(($context["figcaptionStyle"] ?? null)), "html", null, true);
        echo "\"";
    }

    // line 313
    public function block_figcaption_wrap($context, array $blocks = array())
    {
        // line 315
        if (($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true"))) {
            // line 316
            echo "\t\t\t\t<div
\t\t\t\t\t\tclass=\"hi-icon-wrap";
            // line 317
            echo twig_escape_filter($this->env, twig_slice($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "effect", array()), 0, (($context["length"] ?? null) - 1)), "html", null, true);
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "effect", array()), "html", null, true);
            echo "\"
\t\t\t\t\t\tdata-margin=\"";
            // line 318
            echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "margin", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "margin", array()), 5)) : (5)), "html", null, true);
            echo "\"
\t\t\t\t>";
            // line 321
            $context["showFewIconsVar"] = (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "showFewIcons", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "showFewIcons", array()), "default")) : ("default"));
            // line 322
            $context["isShowVideoIcon"] = 0;
            // line 323
            if (( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array())) && ((            // line 325
($context["showFewIconsVar"] ?? null) == "default") || ((            // line 327
($context["showFewIconsVar"] ?? null) == "params") && ($this->getAttribute($this->getAttribute(            // line 328
($context["settings"] ?? null), "icons", array()), "isVideoIcon", array()) == "1"))))) {
                // line 332
                $context["isShowVideoIcon"] = 1;
            }
            // line 335
            $context["isShowLinkIcon"] = 0;
            // line 336
            if (( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "external_link", array())) && ((            // line 338
($context["showFewIconsVar"] ?? null) == "default") || ((            // line 340
($context["showFewIconsVar"] ?? null) == "params") && ($this->getAttribute($this->getAttribute(            // line 341
($context["settings"] ?? null), "icons", array()), "isLinkIcon", array()) == "1"))))) {
                // line 345
                $context["isShowLinkIcon"] = 1;
            }
            // line 348
            if ((($context["isShowVideoIcon"] ?? null) == 1)) {
                // line 349
                ob_start();
                // line 350
                if (twig_in_filter("youtu", $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array()))) {
                    // line 351
                    echo twig_escape_filter($this->env, twig_replace_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array()), ($context["youtube"] ?? null)), "html", null, true);
                    // line 352
                    $context["videoSource"] = "youtube";
                } elseif (twig_in_filter("vimeo.com", $this->getAttribute($this->getAttribute(                // line 353
($context["photo"] ?? null), "attachment", array()), "video", array()))) {
                    // line 354
                    echo twig_escape_filter($this->env, (call_user_func_array($this->env->getFilter('preg_replace')->getCallable(), array($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array()), ($context["vimeoPattern"] ?? null), ($context["vimeoReplace"] ?? null))) . "?api=1"), "html", null, true);
                    // line 355
                    $context["videoSource"] = "vimeo";
                } else {
                    // line 357
                    echo twig_escape_filter($this->env, twig_trim_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array())), "html", null, true);
                }
                $context["videoUrl"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 361
                $context["videoIcon"] = ((twig_in_filter("youtu", $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "video", array()))) ? ("icon-youtube") : ("icon-vimeo"));
                // line 363
                ob_start();
                // line 364
                echo "\t\t\t\t\t\t\tmargin-left:";
                echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "margin", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "margin", array()), 5)) : (5)) . "px"), "html", null, true);
                echo ";
\t\t\t\t\t\t\tmargin-right:";
                // line 365
                echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "margin", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", false, true), "margin", array()), 5)) : (5)) . "px"), "html", null, true);
                echo ";";
                $context["iconStyle"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 367
                echo "
\t\t\t\t\t\t<a href=\"";
                // line 368
                echo twig_escape_filter($this->env, twig_trim_filter(($context["videoUrl"] ?? null)), "html", null, true);
                echo "\"
\t\t\t\t\t\t\tdata-id=\"gg-";
                // line 369
                echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["photo"] ?? null), "id", array()), "html", null, true);
                echo "\"";
                // line 370
                if (($this->getAttribute(($context["settings"] ?? null), "disableImageTitle", array()) != 1)) {
                    // line 371
                    echo "\t\t\t\t\t\t\t\ttitle=\"";
                    echo twig_escape_filter($this->env, twig_trim_filter(($context["aTitle"] ?? null)), "html", null, true);
                    echo "\"";
                }
                // line 373
                echo "
\t\t\t\t\t\t\tclass=\"hi-icon gg-video";
                // line 374
                echo twig_escape_filter($this->env, ($context["videoIcon"] ?? null), "html", null, true);
                // line 375
                if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "2")) {
                    echo " pbox";
                }
                // line 376
                echo "\t\t\t\t\t\t\t\t\t\t\"
\t\t\t\t\t\t\tstyle=\"";
                // line 377
                echo twig_escape_filter($this->env, twig_trim_filter(($context["iconStyle"] ?? null)), "html", null, true);
                echo "\"
\t\t\t\t\t\t\tdata-video-source=\"";
                // line 378
                echo twig_escape_filter($this->env, ($context["videoSource"] ?? null), "html", null, true);
                echo "\"";
                // line 380
                if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "1")) {
                    // line 381
                    echo "\t\t\t\t\t\t\t\t\tdata-rel=\"prettyPhoto[pp_gal]\"";
                } else {
                    // line 384
                    echo "\t\t\t\t\t\t\t\t\trel=\"video\"";
                }
                // line 387
                echo "\t\t\t\t\t\t>";
                // line 389
                echo "\t\t\t\t\t\t</a>";
            }
            // line 392
            if ((($context["isShowLinkIcon"] ?? null) == 1)) {
                // line 393
                echo "\t\t\t\t\t\t<a";
                // line 394
                if (($this->getAttribute(($context["settings"] ?? null), "disableImageTitle", array()) != 1)) {
                    // line 395
                    echo "\t\t\t\t\t\t\t\ttitle=\"";
                    echo twig_escape_filter($this->env, twig_trim_filter(($context["aTitle"] ?? null)), "html", null, true);
                    echo "\"";
                }
                // line 397
                echo "\t\t\t\t\t\t\tdata-id=\"gg-";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["photo"] ?? null), "id", array()), "html", null, true);
                echo "\" href=\"";
                if (($this->getAttribute(($context["settings"] ?? null), "openByLink", array()) == "on")) {
                    echo twig_escape_filter($this->env, ($context["prepareImgUrl"] ?? null), "html", null, true);
                } else {
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "external_link", array()), "html", null, true);
                }
                echo " \" target=\"";
                echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "target", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array(), "any", false, true), "target", array()), "_self")) : ("_self")), "html", null, true);
                echo "\" class=\"hi-icon icon-link";
                if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "2") && ($this->getAttribute(($context["settings"] ?? null), "openByLink", array()) == "on"))) {
                    echo "pbox";
                }
                echo "\" style=\"";
                echo twig_escape_filter($this->env, twig_trim_filter(($context["iconStyle"] ?? null)), "html", null, true);
                echo "\"></a>";
            }
            // line 400
            $context["isShowPopupIcon"] = 0;
            // line 401
            if (((((            // line 402
($context["showFewIconsVar"] ?? null) == "default") && twig_test_empty(            // line 403
($context["videoUrl"] ?? null))) && twig_test_empty($this->getAttribute($this->getAttribute(            // line 404
($context["photo"] ?? null), "attachment", array()), "external_link", array()))) || ((            // line 407
($context["showFewIconsVar"] ?? null) == "params") && ($this->getAttribute($this->getAttribute(            // line 408
($context["settings"] ?? null), "icons", array()), "isPopupIcon", array()) == "1")))) {
                // line 411
                $context["isShowPopupIcon"] = 1;
            }
            // line 414
            if ((($context["isShowPopupIcon"] ?? null) == 1)) {
                // line 415
                echo "\t\t\t\t\t\t<a";
                // line 416
                if (($this->getAttribute(($context["settings"] ?? null), "disableImageTitle", array()) != 1)) {
                    // line 417
                    echo "\t\t\t\t\t\t\t\ttitle=\"";
                    echo twig_escape_filter($this->env, twig_trim_filter(($context["aTitle"] ?? null)), "html", null, true);
                    echo "\"";
                }
                // line 419
                echo "\t\t\t\t\t\t\tdata-id=\"gg-";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
                echo "-";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["photo"] ?? null), "id", array()), "html", null, true);
                echo "\" href=\"";
                echo twig_escape_filter($this->env, ($context["prepareImgUrl"] ?? null), "html", null, true);
                echo "\" class=\"hi-icon icon-fullscreen gg-colorbox";
                if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "2") &&  !array_key_exists("link", $context))) {
                    echo " pbox";
                }
                echo "\" style=\"";
                echo twig_escape_filter($this->env, twig_trim_filter(($context["iconStyle"] ?? null)), "html", null, true);
                echo "\"";
                // line 420
                if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "box", array()), "type", array()) == "1")) {
                    // line 421
                    echo "\t\t\t\t\t\t\tdata-rel=\"prettyPhoto[pp_gal]\"";
                }
                // line 422
                echo ">Open in pop-up window</a>";
            }
            // line 424
            echo "\t\t\t\t</div>";
        }
        // line 427
        if (( !$this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "false"))) {
            // line 428
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "enabled", array()) == "true")) {
                // line 429
                $this->displayBlock('ggImageCaptionEntry', $context, $blocks);
            }
        }
    }

    public function block_ggImageCaptionEntry($context, array $blocks = array())
    {
        // line 430
        if ( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "caption", array()))) {
            // line 431
            echo "\t\t\t\t\t\t\t<div class=\"gg-image-caption fitvidsignore";
            if (($this->getAttribute(($context["settings"] ?? null), "rtl", array()) == true)) {
                echo "ggRtlClass";
            }
            echo "\"";
            if (($this->getAttribute(($context["settings"] ?? null), "rtl", array()) == true)) {
                echo "dir=\"rtl\"";
            }
            echo " style=\"font-size:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size", array()), "html", null, true);
            echo twig_escape_filter($this->env, twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size_unit", array()), array(0 => "px", 1 => "%", 2 => "em")), "html", null, true);
            echo ";\">
\t\t\t\t\t\t\t\t<object type=\"none/none\">";
            // line 433
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "caption", array()), "html", null, true);
            echo "
\t\t\t\t\t\t\t\t</object>
\t\t\t\t\t\t\t</div>";
        }
    }

    // line 444
    public function block_figcaption_after($context, array $blocks = array())
    {
        // line 445
        if ((($this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) && ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "true")) && ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "enabled", array()) == "true"))) {
            // line 447
            ob_start();
            // line 448
            echo "\t\t\t\t\tcolor:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "foreground", array()), "html", null, true);
            echo ";
\t\t\t\t\tbackground-color:";
            // line 449
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "background", array()), "html", null, true);
            echo ";
\t\t\t\t\tfont-size:";
            // line 450
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size", array()), "html", null, true);
            echo twig_escape_filter($this->env, twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size_unit", array()), array(0 => "px", 1 => "%", 2 => "em")), "html", null, true);
            echo ";
\t\t\t\t\tfont-family:";
            // line 451
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "font_family", array()), "html", null, true);
            echo ";";
            // line 452
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_align", array()) != 3)) {
                // line 453
                echo "\t\t\t\t\t\ttext-align:";
                echo twig_escape_filter($this->env, twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_align", array()), array(0 => "left", 1 => "right", 2 => "center")), "html", null, true);
                echo ";";
            }
            // line 455
            if ((($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()) == "none") || ($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "enabled", array()) == "false"))) {
                // line 456
                echo "\t\t\t\t\t\topacity:1;
\t\t\t\t\t\tbottom:0;";
            }
            // line 459
            echo "\t\t\t\t\tvertical-align:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "position", array()), "html", null, true);
            echo ";";
            $context["captionStyle"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
            // line 462
            if (( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "caption", array())) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "tooltip", array()) == "false"))) {
                // line 463
                echo "\t\t\t\t\t<div
\t\t\t\t\t\t\tclass=\"caption-with-";
                // line 464
                if (twig_in_filter("icons", $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()))) {
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "effect", array()), "html", null, true);
                } else {
                    echo "icons";
                }
                echo "\"
\t\t\t\t\t\t\tstyle=\"";
                // line 465
                echo twig_escape_filter($this->env, ($context["captionStyle"] ?? null), "html", null, true);
                echo "\"
\t\t\t\t\t\t\tdata-alpha=\"";
                // line 466
                echo twig_escape_filter($this->env, twig_trim_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "transparency", array())), "html", null, true);
                echo "\">
\t\t\t\t\t\t<div style=\"display: table; height:100%; width:100%;\">";
                // line 468
                $context["ggCaptionText"] = $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "title", array());
                // line 469
                $context["ggCaptionTextStyle"] = ((((("padding: 10px;display:table-cell;font-size:" . $this->getAttribute($this->getAttribute($this->getAttribute(                // line 470
($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size", array())) . twig_replace_filter($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "text_size_unit", array()), array(0 => "px", 1 => "%", 2 => "em"))) . ";vertical-align:") . $this->getAttribute($this->getAttribute($this->getAttribute(                // line 471
($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "position", array())) . ";");
                // line 472
                if ( !twig_test_empty($this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "caption", array()))) {
                    // line 473
                    $context["ggCaptionText"] = $this->getAttribute($this->getAttribute(($context["photo"] ?? null), "attachment", array()), "caption", array());
                    // line 474
                    $context["ggCaptionTextStyle"] = (($context["ggCaptionTextStyle"] ?? null) . "font-weight: 800;");
                }
                // line 476
                $this->displayBlock('figcaption_after_set_exif', $context, $blocks);
                // line 479
                echo "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>";
            }
        }
    }

    // line 476
    public function block_figcaption_after_set_exif($context, array $blocks = array())
    {
        // line 477
        echo "\t\t\t\t\t\t\t\t<span style=\"";
        echo twig_escape_filter($this->env, ($context["ggCaptionTextStyle"] ?? null), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, ($context["ggCaptionText"] ?? null), "html", null, true);
        echo "</span>";
    }

    // line 487
    public function block_figure_after($context, array $blocks = array())
    {
        // line 488
        if (( !$this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "false"))) {
            // line 489
            echo "\t\t\t\t</a>";
        }
    }

    // line 495
    public function block_oneGalleryImage($context, array $blocks = array())
    {
        // line 496
        echo twig_escape_filter($this->env, ($context["var_figure_before"] ?? null), "html", null, true);
        echo "
\t\t<FIGURE";
        // line 497
        echo twig_escape_filter($this->env, ($context["var_figure_attributes"] ?? null), "html", null, true);
        echo " >
\t\t\t<div class=\"crop";
        // line 499
        if ((($this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "shadow", array()), "overlay", array()) == "1") && ($this->getAttribute(($context["settings"] ?? null), "use_shadow", array()) == "1"))) {
            // line 500
            echo "\t\t\t\t\timage-overlay";
        }
        // line 501
        echo "\"
\t\t\t\t style=\"";
        // line 503
        if ((($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "0") || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "grid", array()) == "3"))) {
            // line 504
            echo "\t\t\t\t\t\t width:";
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width", array()) . twig_replace_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_width_unit", array()), array(0 => "px", 1 => "%"))), "html", null, true);
            echo ";
\t\t\t\t\t\t height:";
            // line 505
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height", array()) . twig_replace_filter($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "area", array()), "photo_height_unit", array()), array(0 => "px", 1 => "%"))), "html", null, true);
            echo ";
\t\t\t\t\t\t overflow:hidden;";
        }
        // line 507
        echo "\">

\t\t\t\t<img";
        // line 509
        echo twig_escape_filter($this->env, ($context["var_image_attributes"] ?? null), "html", null, true);
        echo " />
\t\t\t</div>";
        // line 511
        $this->displayBlock('mosaicLastImageNumberWrapper', $context, $blocks);
        // line 513
        $this->displayBlock('mosaicFigcaptionWrapper', $context, $blocks);
        // line 526
        echo "\t\t</FIGURE>";
        // line 527
        echo twig_escape_filter($this->env, ($context["var_figure_after"] ?? null), "html", null, true);
    }

    // line 511
    public function block_mosaicLastImageNumberWrapper($context, array $blocks = array())
    {
    }

    // line 513
    public function block_mosaicFigcaptionWrapper($context, array $blocks = array())
    {
        // line 514
        echo "\t\t\t\t<FIGCAPTION";
        echo twig_escape_filter($this->env, ($context["var_figcaption_attributes"] ?? null), "html", null, true);
        echo "\t>
\t\t\t\t\t<div
\t\t\t\t\t\t\tclass=\"grid-gallery-figcaption-wrap\"
\t\t\t\t\t\t\tstyle=\"";
        // line 518
        if (( !$this->getAttribute(($context["settings"] ?? null), "icons", array(), "any", true, true) || ($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "icons", array()), "enabled", array()) == "false"))) {
            // line 519
            echo "\t\t\t\t\t\t\t\t\tvertical-align:";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "thumbnail", array()), "overlay", array()), "position", array()), "html", null, true);
            echo ";";
        }
        // line 520
        echo "\">";
        // line 521
        echo twig_escape_filter($this->env, ($context["var_figcaption_wrap"] ?? null), "html", null, true);
        echo "
\t\t\t\t\t</div>
\t\t\t\t</FIGCAPTION>";
        // line 524
        echo twig_escape_filter($this->env, ($context["var_figcaption_after"] ?? null), "html", null, true);
    }

    public function getTemplateName()
    {
        return "@galleries/shortcode/helpers.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1096 => 524,  1091 => 521,  1089 => 520,  1084 => 519,  1082 => 518,  1075 => 514,  1072 => 513,  1067 => 511,  1063 => 527,  1061 => 526,  1059 => 513,  1057 => 511,  1053 => 509,  1049 => 507,  1044 => 505,  1039 => 504,  1037 => 503,  1034 => 501,  1031 => 500,  1029 => 499,  1025 => 497,  1021 => 496,  1018 => 495,  1013 => 489,  1011 => 488,  1008 => 487,  1000 => 477,  997 => 476,  990 => 479,  988 => 476,  985 => 474,  983 => 473,  981 => 472,  979 => 471,  978 => 470,  977 => 469,  975 => 468,  971 => 466,  967 => 465,  959 => 464,  956 => 463,  954 => 462,  949 => 459,  945 => 456,  943 => 455,  938 => 453,  936 => 452,  933 => 451,  928 => 450,  924 => 449,  919 => 448,  917 => 447,  915 => 445,  912 => 444,  904 => 433,  890 => 431,  888 => 430,  880 => 429,  878 => 428,  876 => 427,  873 => 424,  870 => 422,  867 => 421,  865 => 420,  851 => 419,  846 => 417,  844 => 416,  842 => 415,  840 => 414,  837 => 411,  835 => 408,  834 => 407,  833 => 404,  832 => 403,  831 => 402,  830 => 401,  828 => 400,  807 => 397,  802 => 395,  800 => 394,  798 => 393,  796 => 392,  793 => 389,  791 => 387,  788 => 384,  785 => 381,  783 => 380,  780 => 378,  776 => 377,  773 => 376,  769 => 375,  767 => 374,  764 => 373,  759 => 371,  757 => 370,  752 => 369,  748 => 368,  745 => 367,  741 => 365,  736 => 364,  734 => 363,  732 => 361,  728 => 357,  725 => 355,  723 => 354,  721 => 353,  719 => 352,  717 => 351,  715 => 350,  713 => 349,  711 => 348,  708 => 345,  706 => 341,  705 => 340,  704 => 338,  703 => 336,  701 => 335,  698 => 332,  696 => 328,  695 => 327,  694 => 325,  693 => 323,  691 => 322,  689 => 321,  685 => 318,  680 => 317,  677 => 316,  675 => 315,  672 => 313,  666 => 306,  661 => 304,  656 => 302,  654 => 301,  651 => 300,  646 => 299,  639 => 291,  637 => 290,  634 => 289,  630 => 288,  625 => 287,  621 => 286,  616 => 285,  611 => 281,  605 => 277,  603 => 276,  599 => 275,  597 => 274,  594 => 273,  589 => 268,  585 => 267,  577 => 266,  568 => 265,  559 => 263,  557 => 262,  550 => 261,  546 => 260,  541 => 259,  538 => 257,  536 => 256,  533 => 253,  530 => 251,  527 => 249,  525 => 248,  521 => 246,  519 => 245,  517 => 244,  515 => 243,  512 => 242,  506 => 235,  504 => 234,  500 => 233,  498 => 232,  493 => 230,  491 => 229,  488 => 228,  483 => 222,  480 => 220,  478 => 219,  475 => 218,  468 => 173,  465 => 171,  463 => 170,  461 => 169,  459 => 168,  456 => 167,  452 => 166,  448 => 165,  445 => 164,  442 => 163,  440 => 162,  437 => 160,  435 => 159,  433 => 158,  429 => 157,  427 => 156,  424 => 155,  417 => 147,  414 => 145,  412 => 144,  408 => 141,  405 => 139,  403 => 138,  401 => 137,  397 => 134,  394 => 132,  392 => 131,  390 => 130,  387 => 129,  380 => 123,  378 => 122,  375 => 121,  370 => 113,  368 => 112,  363 => 108,  361 => 107,  359 => 106,  357 => 105,  354 => 103,  349 => 96,  344 => 95,  341 => 94,  332 => 90,  329 => 89,  323 => 116,  321 => 103,  316 => 100,  314 => 99,  312 => 94,  310 => 93,  308 => 89,  303 => 87,  300 => 86,  297 => 85,  292 => 79,  285 => 25,  282 => 23,  280 => 22,  277 => 21,  272 => 495,  269 => 487,  267 => 486,  264 => 444,  262 => 443,  259 => 313,  257 => 312,  255 => 310,  252 => 300,  248 => 299,  246 => 298,  243 => 273,  241 => 272,  238 => 242,  236 => 241,  233 => 228,  231 => 227,  228 => 218,  226 => 217,  223 => 214,  221 => 213,  218 => 210,  216 => 209,  213 => 206,  211 => 205,  208 => 197,  205 => 194,  203 => 193,  199 => 189,  196 => 187,  194 => 186,  191 => 183,  189 => 182,  187 => 180,  184 => 155,  182 => 154,  179 => 129,  177 => 128,  174 => 121,  172 => 120,  169 => 85,  167 => 84,  164 => 79,  162 => 78,  160 => 76,  156 => 72,  154 => 71,  151 => 69,  149 => 68,  147 => 67,  143 => 63,  140 => 61,  138 => 60,  136 => 59,  134 => 58,  130 => 54,  128 => 53,  125 => 50,  123 => 49,  120 => 46,  118 => 45,  116 => 44,  113 => 41,  110 => 39,  108 => 38,  104 => 34,  101 => 32,  99 => 31,  97 => 30,  94 => 21,  89 => 19,  87 => 18,  82 => 14,  77 => 12,  75 => 11,  73 => 10,  71 => 8,  60 => 7,  58 => 6,  54 => 5,  46 => 3,  44 => 2,  42 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@galleries/shortcode/helpers.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Galleries\\views\\shortcode\\helpers.twig");
    }
}
