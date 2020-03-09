<?php

/* @galleries/sort.twig */
class __TwigTemplate_358af976b89d7f232181bd2c71c5b4da9a17f4169bcc555221042e5db65a6aa7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@galleries/sort.twig", 1);
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
        echo "    <nav id=\"supsystic-breadcrumbs\" class=\"supsystic-breadcrumbs\" style=\"float: left; padding: 20px 0 0 20px;\">";
        // line 7
        echo "        <a href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Galleries")), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "settings", 2 => array("gallery_id" => $this->getAttribute(($context["gallery"] ?? null), "id", array()))), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "title", array()), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "view", 2 => array("gallery_id" => $this->getAttribute(($context["gallery"] ?? null), "id", array()))), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images List")), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "sort", 2 => array("gallery_id" => $this->getAttribute(($context["gallery"] ?? null), "id", array()))), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Sort Images")), "html", null, true);
        echo "</a>
    </nav>

    <section class=\"sgg-all-img-info-sect\" id=\"single-gallery-head-toolbar\" style=\"margin-left: 75px;\">
    \t<div class=\"gg-settings-row\">
\t    \t<div class=\"gg-settings-block\">
\t\t    \t<ul class=\"supsystic-bar-controls\" style=\"padding-left: 20px;\">
\t\t            <li title=\"";
        // line 20
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Upload new images")), "html", null, true);
        echo "\">
\t\t                <button class=\"button button-primary gallery import-to-gallery\">
\t\t                    <i class=\"fa fa-fw fa-upload\"></i>";
        // line 23
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Add Images")), "html", null, true);
        echo "
\t\t                </button>
\t\t            </li>
\t\t            <li>
\t\t                <a href=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "view", 2 => array("gallery_id" => $this->getAttribute(($context["gallery"] ?? null), "id", array()))), "method"), "html", null, true);
        echo "\"
\t\t                   class=\"button\">
\t\t                    <i class=\"fa fa-fw fa-arrow-left\"></i>";
        // line 30
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Back to Images List")), "html", null, true);
        echo "
\t\t                </a>
\t\t            </li>
\t\t        </ul>
        \t</div>
    \t\t<div class=\"gg-settings-block\">
\t\t    \t<ul class=\"supsystic-bar-controls\">
\t\t    \t\t<li>
\t\t            \t<a href=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "settings", 2 => array("gallery_id" => $this->getAttribute(($context["gallery"] ?? null), "id", array()))), "method"), "html", null, true);
        echo "\"
\t\t                \tclass=\"button\">
\t\t                    <i class=\"fa fa-fw fa-cogs\"></i>";
        // line 41
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Settings")), "html", null, true);
        echo "
\t\t                </a>
\t\t            </li>

\t\t            <li>
\t\t                <a target=\"_blank\"
\t\t                   href=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "preview", 2 => array("gallery_id" => $this->getAttribute(($context["gallery"] ?? null), "id", array()))), "method"), "html", null, true);
        echo "\"
\t\t                   class=\"button\" data-button=\"preview\">
\t\t                    <i class=\"fa fa-fw fa-eye\"></i>";
        // line 50
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Preview")), "html", null, true);
        echo "
\t\t                </a>
\t\t            </li>
\t\t        </ul>
        \t</div>
        </div>
    </section>
    <section class=\"supsystic-bar sgg-all-img-info-sect\" id=\"single-gallery-toolbar\" style=\"padding-bottom:0;\">
    \t<div class=\"gg-settings-row\">
    \t\t<div class=\"gg-settings-block\">
\t\t    \t<ul class=\"supsystic-bar-controls\">
\t\t            <li>
\t\t\t\t\t\t<button class=\"button button-primary\" data-button=\"save-sort-order\"";
        // line 62
        if (twig_test_empty($this->getAttribute(($context["gallery"] ?? null), "photos", array()))) {
            echo "disabled";
        }
        echo ">
\t\t\t\t\t\t<i class=\"fa fa-fw fa-save\"></i>";
        // line 64
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Update Sort Order")), "html", null, true);
        echo "
\t\t\t\t\t\t</button>
\t\t\t\t\t</li>
\t\t\t\t\t<li>
                   \t\t<div class=\"gg-wraper-option-links\" style=\"padding-left: 20px\">";
        // line 69
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Preview size: ")), "html", null, true);
        echo "
                        \t<a href=\"#gg-big\" class=\"gg-option-links\" data-size-image data-width=\"200\">";
        // line 70
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Big")), "html", null, true);
        echo "</a> / 
                        \t<a href=\"#gg-medium\" class=\"gg-option-links active\" data-size-image data-width=\"150\">";
        // line 71
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Medium")), "html", null, true);
        echo "</a> / 
                        \t<a href=\"#gg-small\" class=\"gg-option-links\" data-size-image data-width=\"80\">";
        // line 72
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Small")), "html", null, true);
        echo "</a>
\t\t                </div>
\t\t\t\t\t</li>
\t\t\t\t\t<li>";
        // line 76
        if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == true)) {
            // line 77
            echo "\t\t\t\t\t\t\t<button class=\"button button-primary\" data-button=\"show-categories\">
\t\t\t\t\t\t\t\t<i class=\"fa fa-fw fa-tags\"></i>";
            // line 79
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Show Categories")), "html", null, true);
            echo "
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t<button class=\"button button-primary ggSettingsDisplNone\" data-button=\"hide-categories\">
\t\t\t\t\t\t\t\t<i class=\"fa fa-fw fa-eye-slash\"></i>";
            // line 83
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Hide Categories")), "html", null, true);
            echo "
\t\t\t\t\t\t\t</button>";
        }
        // line 86
        echo "\t\t\t\t\t</li>
\t\t        </ul>
        \t</div>

\t        <div class=\"gg-settings-block\">        \t
\t\t        <ul class=\"supsystic-bar-controls\">
\t\t            <li title=\"";
        // line 92
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Sort By: ")), "html", null, true);
        echo "\">";
        // line 93
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Sort By: ")), "html", null, true);
        echo "
\t\t                <select name=\"sortby\" style=\"height: 34px;\">
\t\t                    <option value=\"postion\"";
        // line 95
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "position")) {
            echo "selected";
        }
        echo ">Position</option>
\t\t                    <option value=\"adate\"";
        // line 96
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "adate")) {
            echo "selected";
        }
        echo ">Add date</option>
\t\t                    <option value=\"date\"";
        // line 97
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "date")) {
            echo "selected";
        }
        echo ">Create date</option>
\t\t                    <option value=\"size\"";
        // line 98
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "size")) {
            echo "selected";
        }
        echo ">Size</option>
\t\t                    <option value=\"name\"";
        // line 99
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "name")) {
            echo "selected";
        }
        echo ">Name</option>
\t\t                    <option value=\"filename\"";
        // line 100
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "filename")) {
            echo "selected";
        }
        echo ">File name</option>";
        // line 101
        if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == true)) {
            echo "<option value=\"tags\"";
            if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "tags")) {
                echo "selected";
            }
            echo ">Tags</option>";
        }
        // line 102
        echo "\t\t                    <option value=\"randomly\"";
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "randomly")) {
            echo "selected";
        }
        echo ">Randomly</option>
\t\t                </select>
\t\t            </li>
\t\t\t\t\t<li id=\"sortToLi\" title=\"";
        // line 105
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Sort To: ")), "html", null, true);
        echo "\" style=\"";
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortby", array()) == "randomly")) {
            echo " display:none;";
        }
        echo " }}\">
\t\t\t\t\t\t<button class=\"button button-invisible\" data-button=\"sortbtn\">
\t\t\t\t\t\t\t<i class=\"fa fa-fw fa-arrow-";
        // line 107
        if (($this->getAttribute($this->getAttribute(($context["settings"] ?? null), "sort", array()), "sortto", array()) == "asc")) {
            echo "up";
        } else {
            echo "down";
        }
        echo "\"></i>
\t\t\t\t\t\t</button>
\t\t\t\t\t</li>
\t\t\t\t\t<li>";
        // line 111
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "photos", array())), "html", null, true);
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("media")), "html", null, true);
        echo "
\t\t\t\t\t</li>
\t\t        </ul>
\t\t\t</div>
\t\t</div>

    </section>";
    }

    // line 121
    public function block_content($context, array $blocks = array())
    {
        // line 122
        $context["importTypes"] = $this->loadTemplate("@galleries/shortcode/import.twig", "@galleries/sort.twig", 122);
        // line 123
        if (( !array_key_exists("gallery", $context) || (null === ($context["gallery"] ?? null)))) {
            // line 124
            echo "        <p>";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("The gallery is does not exists")), "html", null, true);
            echo "</p>";
        } else {
            // line 126
            if (twig_test_empty($this->getAttribute(($context["gallery"] ?? null), "photos", array()))) {
                // line 127
                echo "            <h2 style=\"text-align: center; color: #bfbfbf; margin: 50px 0 25px 0;\">
                <span style=\"margin-bottom: 20px; display: block;\">";
                // line 129
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Currently this gallery has no images")), "html", null, true);
                echo "
                </span>";
                // line 131
                echo $context["importTypes"]->getshow("1000", $this->getAttribute(($context["gallery"] ?? null), "id", array()));
                echo "
            </h2>";
            } else {
                // line 134
                $context["view"] = $this;
                // line 135
                echo "        \t<div class=\"gg-entities\">
\t        \t<ul class=\"sg-photos gg-sort-entities gg-all-container\" style=\"margin:0 0 0 -15px;\">";
                // line 137
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["gallery"] ?? null), "photos", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                    // line 138
                    echo $context["view"]->getblock_image($context["image"]);
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 140
                echo "\t    \t\t</ul>
\t    \t</div>";
                // line 142
                if (($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == true)) {
                    // line 143
                    echo "\t\t    \t<div class=\"gg-categories ggSettingsDisplNone\">";
                    // line 144
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["gallery"] ?? null), "tags", array()));
                    foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                        // line 145
                        echo "\t    \t\t\t\t<div class=\"gg-category ggImgVertMoveCol\">
\t        \t\t\t\t<div class=\"gg-category-caption\">
\t        \t\t\t\t\t<i class=\"fa fa-arrows-v ggImgVerticalMove\" style=\"padding:4px\" aria-hidden=\"true\"></i>
\t        \t\t\t\t\t<a href=\"#gg-rename\" class=\"gg-rename-category\">";
                        // line 148
                        echo twig_escape_filter($this->env, $context["category"], "html", null, true);
                        echo "</a>: <label data-count>0</label>";
                        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("media")), "html", null, true);
                        echo "
\t        \t\t\t\t</div>
\t        \t\t\t\t<ul class=\"sg-photos gg-sort-entities gg-category-container\" data-category=\"";
                        // line 150
                        echo twig_escape_filter($this->env, $context["category"], "html", null, true);
                        echo "\"></ul>\t        \t\t
\t        \t\t\t</div>";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 153
                    echo "\t\t        \t<div class=\"gg-category\">
\t\t        \t\t<div class=\"gg-category-caption\">
\t\t        \t\t\t<i class=\"fa fa-arrows-v ggImgVerticalMove\" style=\"padding:4px\" aria-hidden=\"true\"></i>
\t\t        \t\t\t<label class>";
                    // line 156
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("No category")), "html", null, true);
                    echo ":</label> <label data-count>0</label>";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("media")), "html", null, true);
                    echo "
\t\t        \t\t</div>
\t\t        \t\t<ul class=\"sg-photos gg-sort-entities gg-category-container\" data-category=\"\"></ul>\t        \t\t
\t\t        \t</div>
\t\t    \t</div>";
                }
            }
        }
        // line 164
        echo $context["importTypes"]->getview_dialogs($this->getAttribute(($context["gallery"] ?? null), "id", array()));
        echo "
   \t<div id=\"ggRenameCategory\" title=\"";
        // line 165
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Rename Category")), "html", null, true);
        echo "\" style=\"display:none;\">
        <label>";
        // line 166
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("New Name")), "html", null, true);
        echo ": </label>
        <input id=\"newCategoryName\" type=\"text\" value=\"\">
    </div>";
    }

    // line 172
    public function getblock_image($__image__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "image" => $__image__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 173
            echo "    <li class=\"gg-list-item\" data-entity data-entity-id=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["image"] ?? null), "id", array()), "html", null, true);
            echo "\" data-entity-type=\"photo\" data-entity-tag=\";";
            echo twig_join_filter($this->getAttribute(($context["image"] ?? null), "tags", array()), ";");
            echo ";\">";
            // line 174
            if (twig_test_empty($this->getAttribute($this->getAttribute($this->getAttribute(($context["image"] ?? null), "attachment", array()), "sizes", array()), "thumbnail", array()))) {
                // line 175
                $context["src"] = $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["image"] ?? null), "attachment", array()), "sizes", array()), "full", array()), "url", array());
            } else {
                // line 177
                $context["src"] = $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["image"] ?? null), "attachment", array()), "sizes", array()), "thumbnail", array()), "url", array());
            }
            // line 179
            echo "        <img class=\"supsystic-lazy gg-image-thumbnail\" data-original=\"";
            echo twig_escape_filter($this->env, ($context["src"] ?? null), "html", null, true);
            echo "\" alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["image"] ?? null), "attachment", array()), "title", array()), "html", null, true);
            echo "\" width=\"150\" height=\"150\"/>
    </li>";
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
        return "@galleries/sort.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  406 => 179,  403 => 177,  400 => 175,  398 => 174,  392 => 173,  380 => 172,  373 => 166,  369 => 165,  365 => 164,  353 => 156,  348 => 153,  340 => 150,  333 => 148,  328 => 145,  324 => 144,  322 => 143,  320 => 142,  317 => 140,  311 => 138,  307 => 137,  304 => 135,  302 => 134,  297 => 131,  293 => 129,  290 => 127,  288 => 126,  283 => 124,  281 => 123,  279 => 122,  276 => 121,  264 => 111,  254 => 107,  245 => 105,  236 => 102,  228 => 101,  223 => 100,  217 => 99,  211 => 98,  205 => 97,  199 => 96,  193 => 95,  188 => 93,  185 => 92,  177 => 86,  172 => 83,  166 => 79,  163 => 77,  161 => 76,  155 => 72,  151 => 71,  147 => 70,  143 => 69,  136 => 64,  130 => 62,  115 => 50,  110 => 47,  101 => 41,  96 => 38,  85 => 30,  80 => 27,  73 => 23,  68 => 20,  56 => 13,  49 => 11,  42 => 9,  34 => 7,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@galleries/sort.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Galleries\\views\\sort.twig");
    }
}
