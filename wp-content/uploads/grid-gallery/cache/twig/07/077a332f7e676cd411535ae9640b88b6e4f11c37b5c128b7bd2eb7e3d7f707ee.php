<?php

/* @galleries/shortcode/import.twig */
class __TwigTemplate_b8207a0c2981d3a9db22d80e02c064f90faaf172f6b58a88bec908ced1fbd7ea extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
    }

    // line 1
    public function getshow($__areaWidth__ = null, $__galleryId__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "areaWidth" => $__areaWidth__,
            "galleryId" => $__galleryId__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            $context["form1"] = $this->loadTemplate("@core/form.twig", "@galleries/shortcode/import.twig", 2);
            // line 3
            echo "    <div class=\"media-wrapr";
            if (twig_test_empty(($context["galleryId"] ?? null))) {
                echo "no-gallery-id";
            }
            echo "\" style=\"width:";
            echo twig_escape_filter($this->env, ($context["areaWidth"] ?? null), "html", null, true);
            echo "px;margin: 0 auto !important;display: block;\">";
            // line 4
            if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == true)) {
                // line 5
                echo "\t\t\t<br/>
\t\t\t<label>";
                // line 7
                echo $context["form1"]->getcheckbox("importUseExifData", 0, array("checked" => "checked", "class" => "ggUseExifData"));
                // line 8
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import EXIF data")), "html", null, true);
                echo "
\t\t\t</label>";
            } else {
                // line 11
                echo "\t\t\t<div>";
                // line 12
                echo $context["form1"]->getrowpro(call_user_func_array($this->env->getFunction('translate')->getCallable(), array("")), "utm_source=plugin&utm_medium=use-exif-data&utm_campaign=gallery", "backgroundColorForShowOnHoverFree",                 // line 16
$context["form1"]->getcheckbox("importExifData", 0, array("disabled" => "disabled", "class" => "ggUseExifData")));
                // line 18
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import EXIF data")), "html", null, true);
                echo "
\t\t\t</div>";
            }
            // line 21
            echo "        <h1>";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Choose source")), "html", null, true);
            echo "</h1>
        <button class=\"button button-primary button-hero gallery\" id=\"gg-btn-upload\" data-folder-id=\"0\"
                style=\"width: 400px; margin-bottom: 20px;\"
                data-gallery-id=\"";
            // line 24
            echo twig_escape_filter($this->env, ($context["galleryId"] ?? null), "html", null, true);
            echo "\" data-upload>
            <i class=\"fa fa-wordpress fa-2x\"></i>";
            // line 26
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from WordPress Media Library")), "html", null, true);
            echo "
        </button>";
            // line 28
            if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == true)) {
                // line 29
                echo "\t\t\t<button class=\"button button-primary button-hero gallery\" id=\"sggUploadVideoFromUrlBtn\" data-folder-id=\"0\"
\t\t\t\t\tstyle=\"width: 400px;\"
\t\t\t>
\t\t\t\t<i class=\"fa fa-youtube-play fa-2x\" aria-hidden=\"true\"></i>";
                // line 33
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Add video")), "html", null, true);
                echo "
\t\t\t</button>";
            }
            // line 36
            echo "        <h3>";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from social networks")), "html", null, true);
            echo "</h3>
        <a class=\"button button-primary button-hero\" href=\"";
            // line 37
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "insta", 1 => "index", 2 => array("id" => ($context["galleryId"] ?? null))), "method"), "html", null, true);
            echo "\" style=\"width: 400px;margin-bottom: 20px;\">
            <i class=\"fa fa-instagram fa-2x\"></i>";
            // line 39
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Instagram account")), "html", null, true);
            echo "
        </a>";
            // line 41
            if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == true)) {
                // line 42
                echo "            <a class=\"button button-primary button-hero\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "flickr", 1 => "index", 2 => array("id" => ($context["galleryId"] ?? null))), "method"), "html", null, true);
                echo "\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-flickr fa-2x\"></i>";
                // line 44
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Flickr account")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero\" href=\"";
                // line 46
                echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "tumblr", 1 => "index", 2 => array("id" => ($context["galleryId"] ?? null))), "method"), "html", null, true);
                echo "\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-tumblr fa-2x\"></i>";
                // line 48
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Tumblr account")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero\" href=\"";
                // line 50
                echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "facebook", 1 => "index", 2 => array("id" => ($context["galleryId"] ?? null))), "method"), "html", null, true);
                echo "\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-facebook fa-2x\"></i>";
                // line 52
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Facebook account")), "html", null, true);
                echo "
            </a>

            <h3 style=\"margin-top: 0px\">";
                // line 55
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from cloud services")), "html", null, true);
                echo "</h3>
            <a class=\"button button-primary button-hero\" href=\"";
                // line 56
                echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "ftp", 1 => "index", 2 => array("id" => ($context["galleryId"] ?? null))), "method"), "html", null, true);
                echo "\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-file-image-o fa-2x\"></i>";
                // line 58
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your FTP server")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero\" href=\"";
                // line 60
                echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "googledrive", 1 => "index", 2 => array("id" => ($context["galleryId"] ?? null))), "method"), "html", null, true);
                echo "\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-google fa-2x\"></i>";
                // line 62
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Google Drive account")), "html", null, true);
                echo "
            </a>";
            } else {
                // line 65
                echo "            <h3>";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Get Pro to enable import")), "html", null, true);
                echo "</h3>
            <a class=\"button button-primary button-hero\" href=\"http://supsystic.com/plugins/photo-gallery/\" target=\"_blank\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-unlock fa-2x\"></i>";
                // line 68
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Get PRO")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero disabled\" href=\"http://supsystic.com/plugins/photo-gallery/\" target=\"_blank\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-youtube-play fa-2x\"></i>";
                // line 72
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Add video")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero disabled\" href=\"https://supsystic.com/documentation/flickr/\" target=\"_blank\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-flickr fa-2x\"></i>";
                // line 76
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Flickr account")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero disabled\" href=\"https://supsystic.com/documentation/tumblr/\" target=\"_blank\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-tumblr fa-2x\"></i>";
                // line 80
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Tumblr account")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero disabled\" href=\"https://supsystic.com/documentation/facebook/\" target=\"_blank\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-facebook fa-2x\"></i>";
                // line 84
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Facebook account")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero disabled\" href=\"https://supsystic.com/documentation/ftp-import/\" target=\"_blank\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-file-image-o fa-2x\"></i>";
                // line 88
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your FTP server")), "html", null, true);
                echo "
            </a>
            <a class=\"button button-primary button-hero disabled\" href=\"https://supsystic.com/documentation/google-drive-import/\" target=\"_blank\" style=\"width: 400px;margin-bottom: 20px;\">
                <i class=\"fa fa-google fa-2x\"></i>";
                // line 92
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Import from your Google Drive account")), "html", null, true);
                echo "
            </a>";
            }
            // line 95
            echo "    </div>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 98
    public function getview_dialogs($__gallery_id__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "gallery_id" => $__gallery_id__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 99
            $context["form"] = $this->loadTemplate("@core/form.twig", "@galleries/shortcode/import.twig", 99);
            // line 100
            $context["importTypes"] = $this;
            // line 101
            echo "    <div id=\"importDialog\" title=\"";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Select source to import from")), "html", null, true);
            echo "\" style=\"display: none;\">";
            // line 102
            echo $context["importTypes"]->getshow(400, ($context["gallery_id"] ?? null));
            echo "
    </div>

    <div id=\"videoUrlAddDialog\" title=\"";
            // line 105
            echo "Add video url";
            echo "\" style=\"display:none;\" data-gallery-id=\"";
            echo twig_escape_filter($this->env, ($context["gallery_id"] ?? null), "html", null, true);
            echo "\">
        <div class=\"sggVideoUrlAddWr\">
            <div class=\"sggTableRow\">
                <div class=\"sggTableColumn6\">
                    <div class=\"sggDlgVideoTypeH3\">";
            // line 109
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Video type:")), "html", null, true);
            echo "</div>
                </div>
                <div class=\"sggTableColumn6\">";
            // line 112
            echo ((((            // line 113
$context["form"]->getradio("sggDlgVideoType", "youtube", array("id" => "sggDlgYoutubeVideoType", "class" => "sggDlgVideoTypeRadio", "checked" => "checked")) .             // line 118
$context["form"]->getlabel(call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Youtube url")), "sggDlgYoutubeVideoType")) . "<br/>") .             // line 122
$context["form"]->getradio("sggDlgVideoType", "vimeo", array("id" => "sggDlgVimeoVideoType", "class" => "sggDlgVideoTypeRadio"))) .             // line 127
$context["form"]->getlabel(call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Vimeo url")), "sggDlgVimeoVideoType"));
            // line 131
            echo "
                </div>
            </div>
            <div class=\"sggTableRow\">
                <div class=\"sggTableColumn6\">
                    <div class=\"sggDlgVideoTypeH3\">";
            // line 136
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Video url:")), "html", null, true);
            echo "</div>
                </div>
                <div class=\"sggTableColumn6\">";
            // line 139
            echo             // line 140
$context["form"]->getinput("text", "sggDlgUrlVideoValue", "", array("id" => "sggDlgUrlVideoInp", "class" => ""));
            // line 146
            echo "
                </div>
            </div>
            <div class=\"sggTableRow sggAduHiden\" id=\"sggAduErrorText\"></div>
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
        return "@galleries/shortcode/import.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  282 => 146,  280 => 140,  279 => 139,  274 => 136,  267 => 131,  265 => 127,  264 => 122,  263 => 118,  262 => 113,  261 => 112,  256 => 109,  247 => 105,  241 => 102,  237 => 101,  235 => 100,  233 => 99,  221 => 98,  206 => 95,  201 => 92,  195 => 88,  189 => 84,  183 => 80,  177 => 76,  171 => 72,  165 => 68,  159 => 65,  154 => 62,  150 => 60,  145 => 58,  141 => 56,  137 => 55,  131 => 52,  127 => 50,  122 => 48,  118 => 46,  113 => 44,  108 => 42,  106 => 41,  102 => 39,  98 => 37,  93 => 36,  88 => 33,  83 => 29,  81 => 28,  77 => 26,  73 => 24,  66 => 21,  61 => 18,  59 => 16,  58 => 12,  56 => 11,  51 => 8,  49 => 7,  46 => 5,  44 => 4,  36 => 3,  34 => 2,  21 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@galleries/shortcode/import.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Galleries\\views\\shortcode\\import.twig");
    }
}
