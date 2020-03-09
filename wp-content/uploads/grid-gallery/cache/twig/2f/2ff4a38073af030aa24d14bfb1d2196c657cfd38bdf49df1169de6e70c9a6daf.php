<?php

/* @optimization/index.twig */
class __TwigTemplate_43d63484b1309867b341da43df71d6b9f31e08bc5ab6f20fba3439e4f9d984ee extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@optimization/index.twig", 1);
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
        $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 4);
        // line 5
        echo "
    <nav id=\"supsystic-breadcrumbs\" class=\"supsystic-breadcrumbs\">
        <a href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Galleries")), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "optimization"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Image Optimization")), "html", null, true);
        echo "</a>
    </nav>

    <div class=\"sgg-io-tabs-links-list sgg-main-tab-anch\">
        <a href=\"#\" class=\"sgg-io-tab-link sggActive\" data-tab-id=\"sgg-maintab-image-opt\">
            <i class=\"fa fa-compress\"></i>";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Image Optimize")), "html", null, true);
        // line 16
        echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Onboard image opimization with TinyPNG. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a>"), "top", true);
        // line 18
        echo "
        </a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-maintab-transfer-cdn\">
            <i class=\"fa fa-cloud-upload\"></i>";
        // line 22
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer to CDN")), "html", null, true);
        // line 23
        echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Here you may transfer your gallery images to CDN (Content Delivery Network) in order to reduce your site database load. ")) . "<a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
        // line 26
        echo "
        </a>
    </div>";
    }

    // line 31
    public function block_content($context, array $blocks = array())
    {
        // line 32
        $context["imgOptTemplate"] = $this;
        // line 33
        echo "    <div class=\"supsystic-image-optimize\">
        <div class=\"sgg-io-tabs-list sgg-main-tab-anch\">
            <input id=\"sggImgOptMainTabName\" name=\"sggImgOptMainTabName\" value=\"";
        // line 35
        echo twig_escape_filter($this->env, ($context["tabName"] ?? null), "html", null, true);
        echo "\" type=\"hidden\"/>
            <div class=\"sgg-io-one-tab sgg-maintab-image-opt\">";
        // line 37
        echo $context["imgOptTemplate"]->getimageOptimizeMainDialog(($context["imgOptTemplate"] ?? null), ($context["imgOptimizationSett"] ?? null));
        // line 38
        echo $context["imgOptTemplate"]->getimageOptimizeMainTab(($context["imgOptTemplate"] ?? null), ($context["imgOptimizationSett"] ?? null), ($context["galleryList"] ?? null), ($context["statistic"] ?? null));
        echo "
            </div>
            <div class=\"sgg-io-one-tab sgg-maintab-transfer-cdn sgg-io-tab-hidden\">";
        // line 41
        if ((($context["cdnSett"] ?? null) == null)) {
            // line 42
            echo "\t\t\t\t\t<div class=\"sgg-error-list-page\">
\t\t\t\t\t\t<h2>";
            // line 43
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Your host does not support the minimum requirements:")), "html", null, true);
            echo "</h2>";
            // line 44
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["cdnRequirements"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["elem1"]) {
                // line 45
                echo "\t\t\t\t\t\t\t<h3>";
                echo twig_escape_filter($this->env, $context["elem1"], "html", null, true);
                echo "</h3>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['elem1'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 47
            echo "\t\t\t\t\t</div>";
        } else {
            // line 49
            echo $context["imgOptTemplate"]->gettransferToCdnDialog(($context["cdnSett"] ?? null));
            // line 50
            echo $context["imgOptTemplate"]->getimageOptimizeCdnTab(($context["cdnSett"] ?? null), ($context["galleryList"] ?? null));
            // line 51
            echo $context["imgOptTemplate"]->getcdnServiceSettingDialog(($context["cdnSett"] ?? null));
        }
        // line 53
        echo "            </div>
        </div>
    </div>";
    }

    // line 58
    public function getimageOptimizeCdnTab($__cdnSettings__ = null, $__cdnGalleryList__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "cdnSettings" => $__cdnSettings__,
            "cdnGalleryList" => $__cdnGalleryList__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 59
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 59);
            // line 60
            echo "
    <input type=\"hidden\" id=\"sgg-transfer-to-cdn-used\";/>
    <div class=\"supsystic-io-block sgg-cdn-service-block\">
        <div class=\"supsystic-io-block-table sgg-cnd-service-info\">
            <div class=\"supsystic-io-block-row\">
                <div class=\"supsystic-io-block-cell sgg-io-tab-hidden\">
                    <input value=\"keycdn\"";
            // line 66
            if (($this->getAttribute(($context["cdnSettings"] ?? null), "current", array()) == "keycdn")) {
                echo " checked=\"checked\"";
            }
            echo " type=\"radio\" class=\"selected-cnd-opt-service\" name=\"selected-cdn-opt-service\"/>
                </div>
                <div class=\"supsystic-io-block-cell\">";
            // line 69
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("KeyCDN")), "html", null, true);
            // line 70
            echo $context["hlp"]->getshowTooltip((((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer your galleries to Content Delivery Network. Note: in order to do this, you should be a member of CDN. ")) . "<a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>") . "<br/>") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Note: before starting the transfer you should press the 'Setup' button, fill in the data and save the settings."))), "top", true);
            // line 74
            echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"supsystic-io-block-cell\">
                    <a href=\"\" class=\"button sgg-setup-button\" data-dialog-code=\"keycdn\"  data-dialog-title=\"";
            // line 77
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("KeyCDN Settings")), "html", null, true);
            echo "\">
                        <i class=\"fa fa-info-circle\"></i>";
            // line 79
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "u_name", array(), "any", true, true) && ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array()), "keycdn", array()), "u_name", array()) != ""))) {
                // line 80
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Change Details")), "html", null, true);
            } else {
                // line 82
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Setup")), "html", null, true);
            }
            // line 84
            echo "                    </a>
                </div>
            </div>
        </div>
    </div>
\t<div class=\"supsystic-io-block sgg-cdn-list\">
\t\t<input id=\"sgg-cdn-auth-sett\" type=\"hidden\" value=\"";
            // line 90
            echo twig_escape_filter($this->env, twig_jsonencode_filter(($context["cdnSettings"] ?? null)), "html", null, true);
            echo "\"/>
        <button class=\"button sgg-transer-to-cdn\" disabled=\"disabled\">";
            // line 91
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer selected")), "html", null, true);
            echo "</button>

        <div class=\"supsystic-io-block-table sgg-transfer-to-cdn-table\">
            <div class=\"supsystic-io-block-row sgg-table-row-header\">
                <div class=\"supsystic-io-block-cell\"></div>
                <div class=\"supsystic-io-block-cell\">";
            // line 96
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery Name")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 97
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Images")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 98
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Size")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 99
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Location")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\"></div>
            </div>";
            // line 103
            $context["disableTransferBtn"] = false;
            // line 104
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "u_name", array(), "any", true, true) && ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array()), "keycdn", array()), "u_name", array()) != ""))) {
                // line 105
                $context["disableTransferBtn"] = false;
            } else {
                // line 107
                $context["disableTransferBtn"] = true;
            }
            // line 110
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["cdnGalleryList"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["gallInfo"]) {
                // line 111
                echo "                <div class=\"supsystic-io-block-row sgg-cdn-info-row-";
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\">
                    <div class=\"supsystic-io-block-cell\">
\t\t\t\t\t\t<input class=\"sgg-check-gallery-inp\" name=\"sgg-check-gallery-inp\" type=\"checkbox\"
\t\t\t\t\t\t\t   data-gallery-size=\"";
                // line 114
                if ($this->getAttribute($context["gallInfo"], "cdn_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "cdn_size", array()), "html", null, true);
                } elseif ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                } else {
                    echo "-";
                }
                echo "\"
\t\t\t\t\t\t\t   data-gallery-img-cnt=\"";
                // line 115
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "\" value=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\"/>
                    </div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell\">";
                // line 117
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "title", array()), "html", null, true);
                echo "</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell\">";
                // line 119
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell sgg-cdn-info-size\">";
                // line 122
                if ($this->getAttribute($context["gallInfo"], "cdn_size", array(), "any", true, true)) {
                    // line 123
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "cdn_size", array()) . " ") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
                } elseif ($this->getAttribute(                // line 124
$context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    // line 125
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "optimized_size", array()) . " ") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
                } else {
                    // line 126
                    echo "-";
                }
                // line 127
                echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell sgg-cdn-info-tr-date\">";
                // line 129
                if (($this->getAttribute($context["gallInfo"], "cdn_last_transfer_date", array(), "any", true, true) && $this->getAttribute($context["gallInfo"], "cdn_service_name", array(), "any", true, true))) {
                    // line 130
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "cdn_service_name", array()) . " / ") . $this->getAttribute($context["gallInfo"], "cdn_last_transfer_date", array())), "html", null, true);
                } else {
                    // line 131
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("website")), "html", null, true);
                }
                // line 132
                echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell\">
\t\t\t\t\t\t<button class=\"button sgg-transfer-to\" data-gallery-id=\"";
                // line 134
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\"";
                // line 135
                if ((($context["disableTransferBtn"] ?? null) == true)) {
                    echo "disabled=\"disabled\"";
                }
                // line 136
                echo "\t\t\t\t\t\t\t\tdata-photo-count=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "\"
\t\t\t\t\t\t\t\tdata-img-size=\"";
                // line 137
                if ($this->getAttribute($context["gallInfo"], "cdn_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "cdn_size", array()), "html", null, true);
                } elseif ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                } else {
                    echo "-";
                }
                echo "\">";
                // line 138
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer to")), "html", null, true);
                echo "
\t\t\t\t\t\t</button>
\t\t\t\t\t</div>
                </div>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gallInfo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 143
            echo "        </div>
\t</div>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 147
    public function gettransferToCdnDialog($__cdnSettings__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "cdnSettings" => $__cdnSettings__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 148
            echo "\t<div id=\"transfer-to-cdn-dialog\">";
            // line 149
            echo "\t\t<div class=\"sgg-io-tabs-links-list sgg-il-transfer-dialog sgg-io-tab-hidden\">
\t\t\t<a href=\"#\" class=\"sgg-io-tab-link \" data-tab-id=\"sgg-il-transfer-start\">1</a>
\t\t\t<a href=\"#\" class=\"sgg-io-tab-link \" data-tab-id=\"sgg-il-transfer-process\">2</a>
\t\t</div>

\t\t<div class=\"sgg-io-tabs-list sgg-il-transfer-dialog\">
        \t<div class=\"sgg-io-one-tab sgg-il-transfer-start\">
\t\t\t\t<div class=\"sgg-cdndlg-row\">";
            // line 157
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer Gallery to")), "html", null, true);
            echo "
\t\t\t\t\t<strong><span class=\"sgg-cdn-service-name\">";
            // line 158
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Servicename")), "html", null, true);
            echo "</span></strong>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t<strong>";
            // line 161
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total images")), "html", null, true);
            echo ":</strong>
\t\t\t\t\t<span class=\"sgg-cdndlg-img-count\">55</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cnddlg-imgs-size-row\">
\t\t\t\t\t<strong>";
            // line 165
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total size")), "html", null, true);
            echo ":</strong>
\t\t\t\t\t<span class=\"sgg-cnddlg-imgs-size\">66</span>";
            // line 166
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "
\t\t\t\t</div>";
            // line 174
            echo "\t\t\t\t<input type=\"hidden\" id=\"sgg-transl-start-transf\" value=\"";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Start Transfer")), "html", null, true);
            echo "\"/>
\t\t\t</div>

\t\t\t<div class=\"sgg-io-one-tab sgg-il-transfer-process\">
\t\t\t\t<div class=\"sgg-cdndlg-row\">";
            // line 179
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Connected to")), "html", null, true);
            echo "
\t\t\t\t\t<strong><span class=\"sgg-cdn-service-name\">Servicename</span></strong>";
            // line 181
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("service")), "html", null, true);
            echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row\"><strong>";
            // line 183
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer information:")), "html", null, true);
            echo "</strong></div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cdndlg-info\">
\t\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t\t<span id=\"sgg-cdn-curr-gallery\">2</span>";
            // line 187
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
\t\t\t\t\t\t<span id=\"sgg-cdn-gallery-count\">22</span>";
            // line 189
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("galleries")), "html", null, true);
            echo "
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t\t<span id=\"sgg-cdn-curr-img\">1</span>";
            // line 193
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
\t\t\t\t\t\t<span id=\"sgg-cdn-img-count\">34</span>
\t\t\t\t\t\t<span class=\"sgg-cdn-img-text1\">";
            // line 195
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("images")), "html", null, true);
            echo "</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cdn-info-error\">
\t\t\t\t\t<span>";
            // line 199
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer ending with errors!")), "html", null, true);
            echo "</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cdn-info-succ\">
\t\t\t\t\t<span>";
            // line 202
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer completed successfully!")), "html", null, true);
            echo "</span>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 209
    public function getimageOptimizeMainDialog($___selfTemplate__ = null, $__ioSetting__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "_selfTemplate" => $___selfTemplate__,
            "ioSetting" => $__ioSetting__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 210
            echo "    <input type=\"hidden\" id=\"sgg-ai-optimize-sel-auth\" value=\"";
            echo twig_escape_filter($this->env, twig_jsonencode_filter(($context["ioSetting"] ?? null)), "html", null, true);
            echo "\"/>
    <div class=\"sgg-io-tabs-links-list sgg-il-optimize-dlg-wnd sgg-io-tab-hidden\">
        <a href=\"#\" class=\"sgg-io-tab-link sggActive\" data-tab-id=\"sgg-il-optimize-start\">FirstPage</a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-il-optimize-servlist\">Service List</a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-il-optimize-process\">Image Optimize process</a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-il-optimize-result\">Image Optimize Result</a>
    </div>

    <!--  sgg-io-tab-hidden -->
    <div class=\"sgg-io-tabs-list sgg-il-optimize-dlg-wnd\">
        <div class=\"sgg-io-one-tab sgg-il-optimize-start sgg-io-tab-hidden\">
\t\t\t<input type=\"hidden\" id=\"sgg-transl-img-opt-1\" value=\"";
            // line 221
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Image optimization")), "html", null, true);
            echo "\"/>
\t\t\t<input type=\"hidden\" id=\"sgg-transl-start-opt-1\" value=\"";
            // line 222
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Start Optimization")), "html", null, true);
            echo "\"/>";
            // line 234
            echo "
            <div class=\"sgg-il-os-item\">
                <div class=\"sgg-il-os-onerow\">";
            // line 236
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images")), "html", null, true);
            echo ":
\t\t\t\t\t<div id=\"sgg-il-full-img-cnt-div\" class=\"sgg-il-img-cnt-type-obj\">
\t\t\t\t\t\t<span id=\"sgg-il-amount-img-cnt\">18</span>
\t\t\t\t\t\t(<span class=\"sgg-il-preview-img-cnt\">9</span> preview and <span class=\"sgg-il-original-img-cnt\">9</span> original images)
\t\t\t\t\t</div>
\t\t\t\t</div><br/>
                <div id=\"sgg-iop-totalrow\" class=\"sgg-il-os-onerow\">";
            // line 242
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Size")), "html", null, true);
            echo ":
\t\t\t\t\t<span id=\"sgg-il-gallery-size\">00</span>
\t\t\t\t\t<span id=\"sgg-il-gallery-units\">";
            // line 244
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "</span>
\t\t\t\t</div>
            </div>
            <label for=\"sgg-il-backup-img-src\" class=\"sgg-il-os-item\">
                <input id=\"sgg-il-backup-img-src\" class=\"sgg-il-checkbox-prm\" name=\"sgg-il-backup-img-src\" type=\"checkbox\" checked=\"checked\"/>";
            // line 249
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Backup Images Source")), "html", null, true);
            echo "
            </label>
            <label for=\"sgg-il-optimize-preview\" class=\"sgg-il-os-item\">
                <input id=\"sgg-il-optimize-preview\" class=\"sgg-il-checkbox-prm\" name=\"sgg-il-optimize-preview\" type=\"checkbox\" checked=\"checked\"/>";
            // line 253
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize Preview images")), "html", null, true);
            echo "
            </label>
        </div>
        <div class=\"sgg-io-one-tab sgg-il-optimize-servlist sgg-io-tab-hidden\">";
            // line 257
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "imageOptimizeServiceSettingTable", array(0 => ($context["_selfTemplate"] ?? null), 1 => ($context["ioSetting"] ?? null)), "method"), "html", null, true);
            echo "
        </div>
        <div class=\"sgg-io-one-tab sgg-il-optimize-process sgg-io-tab-hidden\">
\t\t\t<input type=\"hidden\" id=\"sgg-transl-img-opt-2\" value=\"";
            // line 260
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimization in process...")), "html", null, true);
            echo "\"/>
            <div class=\"sgg-optimize-info sgg-io-tab-hidden\">
                <div>";
            // line 263
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Connected to")), "html", null, true);
            echo "
                    <strong><span id=\"sgg-conn-to-serv-name\">servicename</span></strong>";
            // line 265
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("service")), "html", null, true);
            echo "
                </div>
                <div><strong>";
            // line 267
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize:")), "html", null, true);
            echo "</strong></div>
                <div>
                    <span id=\"sgg-opt-curr-gallery\">curr</span>";
            // line 270
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
                    <span id=\"sgg-opt-numb-gallery\">numb</span>";
            // line 272
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("galleries")), "html", null, true);
            echo "
                </div>
                <div>
                    <span id=\"sgg-opt-curr-img\">curr</span>";
            // line 276
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
                    <span id=\"sgg-opt-numb-imgs\">numb</span>
                    <span class=\"sgg-iop-without-prev\">";
            // line 278
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("images")), "html", null, true);
            echo "</span>
                    <span class=\"sgg-iop-with-prev\">";
            // line 279
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("images (preview and original images)")), "html", null, true);
            echo "</span>
                </div>
                <div class=\"sgg-opt-info-error sgg-io-tab-hidden\">
                    <span>";
            // line 282
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Error ocured. Optimize process stopped!")), "html", null, true);
            echo "</span>
                </div>
            </div>
        </div>
        <div class=\"sgg-io-one-tab sgg-il-optimize-result sgg-io-tab-hidden\">
\t\t\t<input type=\"hidden\" id=\"sgg-transl-img-opt-3\" value=\"";
            // line 287
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimization complete")), "html", null, true);
            echo "\"/>
            <div class=\"sgg-iores-info\">
                <div class=\"sgg-iores-txt\">";
            // line 290
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images size before:")), "html", null, true);
            echo "
                    <span class=\"sgg-iores-tsizebefore\">0</span>";
            // line 292
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "
                </div>
                <div class=\"sgg-iores-txt\">";
            // line 295
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images size after:")), "html", null, true);
            echo "
                    <span class=\"sgg-iores-tsizeafter\">0</span>";
            // line 297
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "
                </div>
                <div class=\"sgg-iores-txt\">";
            // line 300
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Saving:")), "html", null, true);
            echo " <span class=\"sgg-iores-tsaving\">0</span>%
                </div>
            </div>
            <br/>
            <button class=\"button sgg-il-optimize-again-btn\">
                <i class=\"fa fa-compress\"></i>";
            // line 306
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize one more time")), "html", null, true);
            echo "
            </button>
            <br/>
            <a href=\"\" class=\"sgg-iores-link-compare\">";
            // line 310
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Show image comparision")), "html", null, true);
            echo "
            </a>

            <div class=\"supsystic-io-block-table sgg-iores-compare-wrap sgg-io-tab-hidden\">
                <!-- Rows to compare Images -->
            </div>
            <div class=\"sgg-iores-cmp-template sgg-io-tab-hidden\">
                <div class=\"supsystic-io-block-row sgg-compare-first-row\">
                    <div class=\"supsystic-io-block-cell\"><h3>";
            // line 318
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Before")), "html", null, true);
            echo "</h3></div>
                    <div class=\"supsystic-io-block-cell\"><h3>";
            // line 319
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("After")), "html", null, true);
            echo "</h3></div>
                </div>
            </div>
        </div>
    </div>";
            // line 325
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "imageOptimizeServiceSettingsDialog", array(0 => ($context["ioSetting"] ?? null)), "method"), "html", null, true);
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 328
    public function getimageOptimizeServiceSettingTable($___selfTemplate__ = null, $__ioSetting__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "_selfTemplate" => $___selfTemplate__,
            "ioSetting" => $__ioSetting__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 329
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 329);
            // line 330
            echo "
    <div class=\"supsystic-io-block sgg-service-setting\">
        <div class=\"supsystic-io-block-table sgg-service-info\">
            <div class=\"supsystic-io-block-row\">
                <div class=\"supsystic-io-block-cell sgg-io-tab-hidden\">
                    <input value=\"tinypng\"";
            // line 335
            if (($this->getAttribute(($context["ioSetting"] ?? null), "current", array()) == "tinypng")) {
                echo " checked=\"checked\"";
            }
            echo " type=\"radio\" class=\"selected-opt-service\" name=\"selected-opt-service\"/>
                </div>
                <div class=\"supsystic-io-block-cell\">";
            // line 338
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("TinyPNG")), "html", null, true);
            // line 339
            echo $context["hlp"]->getshowTooltip((((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("The intelligent image optimization feature allows you to save bandwidth and make your gallery load faster. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a> ") . "<br/>") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Note: before starting the optimization you should press the 'Change Details' button, get your TinyPNG API key and insert it to the text field. Use the tooltip to find the key. "))), "top", true);
            // line 343
            echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"supsystic-io-block-cell\">
                    <a href=\"\" class=\"button sgg-setup-button\" data-dialog-code=\"tinypng\"  data-dialog-title=\"";
            // line 346
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("TinyPNG Settings")), "html", null, true);
            echo "\">
                        <i class=\"fa fa-info-circle\"></i>";
            // line 348
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array(), "any", false, true), "tinypng", array(), "any", false, true), "auth_key", array(), "any", true, true) && ($this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array()), "tinypng", array()), "auth_key", array()) != ""))) {
                // line 349
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Change Details")), "html", null, true);
            } else {
                // line 351
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Setup")), "html", null, true);
            }
            // line 353
            echo "                    </a>
                </div>
            </div>";
            // line 368
            echo "        </div>
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

    // line 372
    public function getimageOptimizeMainTab($___selfTemplate__ = null, $__ioSetting__ = null, $__galleryList__ = null, $__statistic__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "_selfTemplate" => $___selfTemplate__,
            "ioSetting" => $__ioSetting__,
            "galleryList" => $__galleryList__,
            "statistic" => $__statistic__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 373
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 373);
            // line 374
            echo "
    <input type=\"hidden\" id=\"sgg-optimize-main-tab-inp\"/>";
            // line 376
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "imageOptimizeServiceSettingTable", array(0 => ($context["_selfTemplate"] ?? null), 1 => ($context["ioSetting"] ?? null)), "method"), "html", null, true);
            echo "

    <div class=\"supsystic-io-block sgg-io-stat-block\">
        <!--<div class=\"sgg-io-tabs-links-list sgg-io-stat-anch\">
            <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-io-one-tab\">All</a>
            <a href=\"#\" class=\"sgg-io-tab-link sggActive\" data-tab-id=\"sgg-stat-tab-1\">TinyPNG</a>
            <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-stat-tab-2\">Another Service</a>
        </div>-->
        <div class=\"sgg-io-tabs-list sgg-io-stat-anch\">
            <div class=\"sgg-io-one-tab sgg-stat-tab-1\">";
            // line 386
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "oneImageOptimizeStatTable", array(0 => "tinypng", 1 => "", 2 => ($context["statistic"] ?? null)), "method"), "html", null, true);
            echo "
            </div>
            <!-- <div class=\"sgg-io-one-tab sgg-stat-tab-2 sgg-io-tab-hidden\">";
            // line 390
            echo "            </div>-->
        </div>
    </div>

    <div class=\"supsystic-io-block sgg-optimize-list\">
        <button class=\"button sgg-optimize-selected\" disabled=\"disabled\">";
            // line 395
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize selected")), "html", null, true);
            echo "</button>";
            // line 396
            echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("You may choose one, several or all the galleries at once to optimize them. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a>"), "top", true);
            // line 399
            echo "

        <div class=\"supsystic-io-block-table sgg-gallery-opt-table\">
            <div class=\"supsystic-io-block-row sgg-table-row-header\">
                <div class=\"supsystic-io-block-cell\"></div>
                <div class=\"supsystic-io-block-cell\">";
            // line 404
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery Name")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 405
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Images")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 406
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Size")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 407
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimization")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\"></div>
            </div>";
            // line 410
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["galleryList"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["gallInfo"]) {
                // line 411
                echo "                <div class=\"supsystic-io-block-row\">
                    <div class=\"supsystic-io-block-cell\">
                        <input class=\"sgg-checkb-inp\" type=\"checkbox\" value=\"";
                // line 413
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\"
                               data-once-optimize=\"";
                // line 414
                if (($this->getAttribute($context["gallInfo"], "last_optimize_date", array(), "any", true, true) && $this->getAttribute($context["gallInfo"], "service_name", array(), "any", true, true))) {
                    echo "1";
                } else {
                    echo "0";
                }
                echo "\"
                               data-gallery-total-size=\"";
                // line 415
                if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                } else {
                    echo "-";
                }
                echo "\"
                               data-phot-count=\"";
                // line 416
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "\"
                        />
                    </div>
                    <div class=\"supsystic-io-block-cell\">";
                // line 419
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "title", array()), "html", null, true);
                echo "</div>
                    <div class=\"supsystic-io-block-cell\">";
                // line 421
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "
                    </div>
                    <div class=\"supsystic-io-block-cell\">";
                // line 424
                if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    // line 425
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "optimized_size", array()) . " ") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
                } else {
                    // line 427
                    echo "                            -";
                }
                // line 429
                echo "                    </div>
                    <div class=\"supsystic-io-block-cell\">";
                // line 431
                if ((($this->getAttribute($context["gallInfo"], "last_optimize_date", array(), "any", true, true) && $this->getAttribute($context["gallInfo"], "service_name", array(), "any", true, true)) && $this->getAttribute($context["gallInfo"], "optimize_percent", array(), "any", true, true))) {
                    // line 433
                    echo twig_escape_filter($this->env, ((($this->getAttribute($context["gallInfo"], "last_optimize_date", array()) . " / ") . $this->getAttribute($context["gallInfo"], "optimize_percent", array())) . "% "), "html", null, true);
                } else {
                    // line 435
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("No")), "html", null, true);
                }
                // line 437
                echo "\t\t\t\t\t</div>
                    <div class=\"supsystic-io-block-cell\">";
                // line 439
                if ($this->getAttribute($context["gallInfo"], "last_optimize_date", array(), "any", true, true)) {
                    // line 440
                    echo "                            <button class=\"button sgg-restore-src-img\" data-gallery-id=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\">";
                    // line 441
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Restore Source Images")), "html", null, true);
                    echo "
                            </button>
                            <div class=\"sgg-opt-twi-button\">
                                <button class=\"button sgg-tbl-optimize-retr\"
                                        data-gallery-id=\"";
                    // line 445
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\"
                                        data-gallery-total-size=\"";
                    // line 446
                    if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                        echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                    } else {
                        echo "-";
                    }
                    echo "\"
                                        data-photo-count=\"";
                    // line 447
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                    echo "\">";
                    // line 448
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize")), "html", null, true);
                    echo "
                                </button>
                                <br/><span class=\"sgg-more-info-str\">* one more time</span>
                            </div>";
                } else {
                    // line 453
                    echo "                            <button class=\"button sgg-restore-src-img sgg-io-tab-hidden\" data-gallery-id=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\">";
                    // line 454
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Restore Source Images")), "html", null, true);
                    echo "
                            </button>
                            <button class=\"button sgg-tbl-optimize-first\"
                                    data-gallery-id=\"";
                    // line 457
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\"
                                    data-gallery-total-size=\"";
                    // line 458
                    if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                        echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                    } else {
                        echo "-";
                    }
                    echo "\"
                                    data-photo-count=\"";
                    // line 459
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                    echo "\">";
                    // line 460
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize Now")), "html", null, true);
                    echo "
                            </button>";
                }
                // line 463
                echo "                    </div>
                </div>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gallInfo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 466
            echo "        </div>
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

    // line 470
    public function getimageOptimizeServiceSettingsDialog($__ioSetting__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "ioSetting" => $__ioSetting__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 471
            $context["helper1"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 471);
            // line 472
            echo "
    <div id=\"sggDialogSeviceSetting\" title=\"\" style=\"display:none;\">
        <div class=\"sgg-dialog-block-part sgg-io-tab-hidden\" data-img-opt-sett-code=\"tinypng\">
            <label>";
            // line 476
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your TinyPNG API key")), "html", null, true);
            // line 477
            echo $context["helper1"]->getshowTooltip(call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your name and email address on this <a target='_blank' href='https://tinypng.com/developers'>page</a> to retrieve your API key. On your email will be sent a link to your API key. Follow the link from email and grab your API key.")), "top", true);
            echo "
                <br/>
                <input type=\"text\" class=\"sgg-tinypng-sett-auth-val\" name=\"tinypng-auth-val\" value=\"";
            // line 479
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array(), "any", false, true), "tinypng", array(), "any", false, true), "auth_key", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array()), "tinypng", array()), "auth_key", array()), "html", null, true);
            }
            echo "\"/>
            </label>
            <button class=\"button sgg-setup-button sgg-tinypng-save\" >";
            // line 481
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save")), "html", null, true);
            echo "</button>
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

    // line 486
    public function getcdnServiceSettingDialog($__cdnSett__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "cdnSett" => $__cdnSett__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 487
            $context["helper1"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 487);
            // line 488
            echo "
    <div id=\"sggCdnDialogSeviceSett\" title=\"\" style=\"display:none;\">
        <div class=\"sgg-dialog-block-part sgg-io-tab-hidden\" data-img-opt-sett-code=\"keycdn\">
            <label>";
            // line 492
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your Site name")), "html", null, true);
            // line 493
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn Zone name (for example: pz-6f09.kxcdn.com)")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 496
            echo "
\t\t\t\t<br/>
                <input type=\"text\" autocomplete=\"off\" class=\"sgg-keycdn-sett-zonename\" name=\"sgg-keycdn-sett-sitename\" value=\"";
            // line 498
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "zone_name", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array()), "keycdn", array()), "zone_name", array()), "html", null, true);
            }
            echo "\"/>
            </label>
            <br/>
\t\t\t<label>";
            // line 502
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your username")), "html", null, true);
            // line 503
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn username")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 506
            echo "
\t\t\t\t<br/>
\t\t\t\t<input type=\"text\" autocomplete=\"off\" class=\"sgg-keycdn-sett-uname\" name=\"sgg-keycdn-sett-uname\" value=\"";
            // line 508
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "u_name", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array()), "keycdn", array()), "u_name", array()), "html", null, true);
            }
            echo "\"/>
\t\t\t</label><br/>
\t\t\t<label>";
            // line 511
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your password")), "html", null, true);
            // line 512
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn password")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 515
            echo "
\t\t\t\t<br/>";
            // line 518
            echo "\t\t\t\t<input type=\"password\" autocomplete=\"off\" class=\"sgg-keycdn-sett-upass\" name=\"sgg-keycdn-sett-upass\" value=\"\"/>
\t\t\t</label><br/>
\t\t\t<label>";
            // line 521
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your ftp base path")), "html", null, true);
            // line 522
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn ftp base path (for example: /pz)")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 525
            echo "
\t\t\t\t<br/>
\t\t\t\t<input type=\"text\" class=\"sgg-keycdn-sett-base-ftp\" name=\"sgg-keycdn-sett-base-ftp\" value=\"";
            // line 527
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "base_ftp_path", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array()), "keycdn", array()), "base_ftp_path", array()), "html", null, true);
            }
            echo "\"/>
\t\t\t</label>
\t\t\t<button class=\"button sgg-setup-button sgg-keycdn-save\" disabled=\"disabled\">";
            // line 529
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save")), "html", null, true);
            echo "</button>
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

    // line 534
    public function getoneImageOptimizeStatTable($__serviceCode__ = null, $__tblData__ = null, $__statistic__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "serviceCode" => $__serviceCode__,
            "tblData" => $__tblData__,
            "statistic" => $__statistic__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 535
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 535);
            // line 536
            echo "
    <div class=\"supsystic-io-block-table sgg-service-stat-info\">
        <div class=\"supsystic-io-block-caption\">
            <h4>";
            // line 540
            if ((($context["serviceCode"] ?? null) == "tinypng")) {
                // line 541
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("TinyPNG Statistics")), "html", null, true);
                // line 542
                echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Here you may find the detailed optimization statistics for your gallery. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a>"), "top", true);
            } else {
                // line 547
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Incorrect service Code")), "html", null, true);
            }
            // line 549
            echo "            </h4>
        </div>

        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\"></div>
            <div class=\"supsystic-io-block-cell\"><span class=\"sgg-text-style1\">";
            // line 554
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Last 24 hours")), "html", null, true);
            echo "</span></div>
            <div class=\"supsystic-io-block-cell\"><span class=\"sgg-text-style1\">";
            // line 555
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Week")), "html", null, true);
            echo "</span></div>
            <div class=\"supsystic-io-block-cell\"><span class=\"sgg-text-style1\">";
            // line 556
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Month")), "html", null, true);
            echo "</span></div>
        </div>";
            // line 559
            echo "        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 560
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Number of images")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 561
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "photo_count", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 562
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "photo_count", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 563
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "photo_count", array()), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 566
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total size before")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 567
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 568
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 569
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "size_mb", array()), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 572
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total size after")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 573
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "optimized_size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 574
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "optimized_size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 575
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "optimized_size_mb", array()), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 578
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save in Mb")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 579
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "save_mb", array()) . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 580
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "save_mb", array()) . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 581
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "save_mb", array()) . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 584
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save in %")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 585
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "save_percent", array()), "html", null, true);
            echo "%</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 586
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "save_percent", array()), "html", null, true);
            echo "%</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 587
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "save_percent", array()), "html", null, true);
            echo "%</div>
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
        return "@optimization/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1240 => 587,  1236 => 586,  1232 => 585,  1228 => 584,  1222 => 581,  1218 => 580,  1214 => 579,  1210 => 578,  1204 => 575,  1200 => 574,  1196 => 573,  1192 => 572,  1186 => 569,  1182 => 568,  1178 => 567,  1174 => 566,  1168 => 563,  1164 => 562,  1160 => 561,  1156 => 560,  1153 => 559,  1149 => 556,  1145 => 555,  1141 => 554,  1134 => 549,  1131 => 547,  1128 => 542,  1126 => 541,  1124 => 540,  1119 => 536,  1117 => 535,  1103 => 534,  1085 => 529,  1078 => 527,  1074 => 525,  1072 => 522,  1070 => 521,  1066 => 518,  1063 => 515,  1061 => 512,  1059 => 511,  1052 => 508,  1048 => 506,  1046 => 503,  1044 => 502,  1036 => 498,  1032 => 496,  1030 => 493,  1028 => 492,  1023 => 488,  1021 => 487,  1009 => 486,  991 => 481,  984 => 479,  979 => 477,  977 => 476,  972 => 472,  970 => 471,  958 => 470,  942 => 466,  935 => 463,  930 => 460,  927 => 459,  919 => 458,  915 => 457,  909 => 454,  905 => 453,  898 => 448,  895 => 447,  887 => 446,  883 => 445,  876 => 441,  872 => 440,  870 => 439,  867 => 437,  864 => 435,  861 => 433,  859 => 431,  856 => 429,  853 => 427,  850 => 425,  848 => 424,  843 => 421,  839 => 419,  833 => 416,  825 => 415,  817 => 414,  813 => 413,  809 => 411,  805 => 410,  800 => 407,  796 => 406,  792 => 405,  788 => 404,  781 => 399,  779 => 396,  776 => 395,  769 => 390,  764 => 386,  752 => 376,  749 => 374,  747 => 373,  732 => 372,  716 => 368,  712 => 353,  709 => 351,  706 => 349,  704 => 348,  700 => 346,  695 => 343,  693 => 339,  691 => 338,  684 => 335,  677 => 330,  675 => 329,  662 => 328,  647 => 325,  640 => 319,  636 => 318,  625 => 310,  619 => 306,  611 => 300,  606 => 297,  602 => 295,  597 => 292,  593 => 290,  588 => 287,  580 => 282,  574 => 279,  570 => 278,  565 => 276,  559 => 272,  555 => 270,  550 => 267,  545 => 265,  541 => 263,  536 => 260,  530 => 257,  524 => 253,  518 => 249,  511 => 244,  506 => 242,  497 => 236,  493 => 234,  490 => 222,  486 => 221,  471 => 210,  458 => 209,  438 => 202,  432 => 199,  425 => 195,  420 => 193,  414 => 189,  410 => 187,  404 => 183,  399 => 181,  395 => 179,  387 => 174,  383 => 166,  379 => 165,  372 => 161,  366 => 158,  362 => 157,  353 => 149,  351 => 148,  339 => 147,  323 => 143,  313 => 138,  304 => 137,  299 => 136,  295 => 135,  292 => 134,  288 => 132,  285 => 131,  282 => 130,  280 => 129,  277 => 127,  274 => 126,  271 => 125,  269 => 124,  267 => 123,  265 => 122,  260 => 119,  256 => 117,  249 => 115,  239 => 114,  232 => 111,  228 => 110,  225 => 107,  222 => 105,  220 => 104,  218 => 103,  213 => 99,  209 => 98,  205 => 97,  201 => 96,  193 => 91,  189 => 90,  181 => 84,  178 => 82,  175 => 80,  173 => 79,  169 => 77,  164 => 74,  162 => 70,  160 => 69,  153 => 66,  145 => 60,  143 => 59,  130 => 58,  124 => 53,  121 => 51,  119 => 50,  117 => 49,  114 => 47,  106 => 45,  102 => 44,  99 => 43,  96 => 42,  94 => 41,  89 => 38,  87 => 37,  83 => 35,  79 => 33,  77 => 32,  74 => 31,  68 => 26,  66 => 23,  64 => 22,  59 => 18,  57 => 16,  55 => 15,  45 => 9,  38 => 7,  34 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@optimization/index.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Optimization\\views\\index.twig");
    }
}
