<?php

/* @core/form.twig */
class __TwigTemplate_4e1bf49ffb4532ef4121d6506d364070946a63a091e2b357350683e8744ff6f0 extends Twig_Template
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
    public function getopen($__method__ = null, $__action__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "method" => $__method__,
            "action" => $__action__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "    <form method=\"";
            echo twig_escape_filter($this->env, twig_upper_filter($this->env, ($context["method"] ?? null)), "html", null, true);
            echo "\"";
            if ( !twig_test_empty(($context["action"] ?? null))) {
                echo "action=\"";
                echo twig_escape_filter($this->env, ($context["action"] ?? null), "html", null, true);
                echo "\"";
            }
            // line 3
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo ">";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 6
    public function getclose(...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 7
            echo "    </form>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 10
    public function getshow_tooltip($__id__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "id" => $__id__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 12
            $context["title"] = $this->getAttribute(($context["tooltips"] ?? null), ($context["id"] ?? null), array(), "array");
            // line 14
            if ( !twig_test_empty(($context["title"] ?? null))) {
                // line 15
                echo "        <i class=\"fa fa-";
                echo twig_escape_filter($this->env, (($this->getAttribute(($context["tooltips_icon"] ?? null), "icon", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["tooltips_icon"] ?? null), "icon", array()), "question")) : ("question")), "html", null, true);
                echo " supsystic-tooltip\"
           title=\"";
                // line 16
                echo ($context["title"] ?? null);
                echo "\"
           style=\"";
                // line 17
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["tooltips_icon"] ?? null), "style", array()));
                foreach ($context['_seq'] as $context["property"] => $context["value"]) {
                    echo twig_escape_filter($this->env, twig_trim_filter($context["property"]), "html", null, true);
                    echo ":";
                    echo twig_escape_filter($this->env, twig_trim_filter($context["value"]), "html", null, true);
                    echo ";";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['property'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo "\"></i>";
            }
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 21
    public function getrow($__label__ = null, $__element__ = null, $__id__ = null, $__titleRow__ = null, $__row_id__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "label" => $__label__,
            "element" => $__element__,
            "id" => $__id__,
            "titleRow" => $__titleRow__,
            "row_id" => $__row_id__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 22
            $context["form"] = $this;
            // line 24
            if ( !twig_test_empty(($context["row_id"] ?? null))) {
                // line 25
                echo "    <tr id=\"";
                echo twig_escape_filter($this->env, ($context["row_id"] ?? null), "html", null, true);
                echo "\">";
            } else {
                // line 27
                echo "    <tr>";
            }
            // line 29
            echo "        <th scope=\"row\">";
            // line 30
            if (((twig_length_filter($this->env, ($context["titleRow"] ?? null)) == 2) && (($context["titleRow"] ?? null) == "h4"))) {
                // line 31
                echo "\t\t\t\t<h4 style=\"margin: 0 !important;\"";
                if ( !twig_test_empty(($context["id"] ?? null))) {
                    echo "id=\"label-";
                    echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                    echo "\"";
                }
                echo ">";
                // line 32
                echo ($context["label"] ?? null);
                // line 33
                echo $context["form"]->getshow_tooltip(($context["id"] ?? null));
                echo "
\t\t\t\t</h4>";
            } elseif ( !twig_test_empty(            // line 35
($context["titleRow"] ?? null))) {
                // line 36
                echo "                <h3 style=\"margin: 0 !important;\"";
                if ( !twig_test_empty(($context["id"] ?? null))) {
                    echo "id=\"label-";
                    echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                    echo "\"";
                }
                echo ">";
                // line 37
                echo ($context["label"] ?? null);
                // line 38
                echo $context["form"]->getshow_tooltip(($context["id"] ?? null));
                echo "
                </h3>";
            } else {
                // line 41
                echo "                <label";
                if ( !twig_test_empty(($context["id"] ?? null))) {
                    echo "id=\"label-";
                    echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                    echo "\" for=\"";
                    echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                    echo "\"";
                }
                echo ">";
                // line 42
                echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
                // line 43
                echo $context["form"]->getshow_tooltip(($context["id"] ?? null));
                echo "
                </label>";
            }
            // line 46
            echo "        </th>";
            // line 47
            if ( !twig_test_empty(($context["id"] ?? null))) {
                // line 48
                echo "        <td id=\"";
                echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                echo "\">";
            } else {
                // line 50
                echo "        <td>";
            }
            // line 52
            echo ($context["element"] ?? null);
            echo "
        </td>
    </tr>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 57
    public function getrowpro($__label__ = null, $__link__ = null, $__id__ = null, $__element__ = null, $__titleRow__ = null, $__notAddBr__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "label" => $__label__,
            "link" => $__link__,
            "id" => $__id__,
            "element" => $__element__,
            "titleRow" => $__titleRow__,
            "notAddBr" => $__notAddBr__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 58
            $context["form"] = $this;
            // line 59
            echo "    
    <tr>
        <th scope=\"row\">";
            // line 62
            if ( !twig_test_empty(($context["titleRow"] ?? null))) {
                // line 63
                echo "                <h3 style=\"margin: 0 !important;\">";
                // line 64
                echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
                // line 65
                echo $context["form"]->getshow_tooltip(($context["id"] ?? null));
                echo "
                </h3>";
            } else {
                // line 68
                echo "                <label";
                if ( !twig_test_empty(($context["id"] ?? null))) {
                    echo "id=\"label-";
                    echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                    echo "\" for=\"";
                    echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                    echo "\"";
                }
                echo ">";
                // line 69
                echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
                // line 70
                echo $context["form"]->getshow_tooltip(($context["id"] ?? null));
                echo "
                </label>";
            }
            // line 73
            if ((($context["notAddBr"] ?? null) == null)) {
                // line 74
                echo "\t\t\t\t<br/>";
            }
            // line 76
            echo "\t\t\t<label><a href=\"";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('getProUrl')->getCallable(), array(($context["link"] ?? null))), "html", null, true);
            echo "\" target=\"_blank\" style=\"color: #0074a2; font-size: 10px; text-decoration: none;\" class=\"sggLinkToProVer\">PRO Option</a> </label>
        </th>
        <td>";
            // line 78
            echo ($context["element"] ?? null);
            echo "</td>
    </tr>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 82
    public function getinput($__type__ = "text", $__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "type" => $__type__,
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 83
            echo "    <input type=\"";
            echo twig_escape_filter($this->env, ($context["type"] ?? null), "html", null, true);
            echo "\" name=\"";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\" value=\"";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "\"";
            // line 84
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
            foreach ($context['_seq'] as $context["attribute"] => $context["val"]) {
                // line 85
                if (twig_test_iterable($context["val"])) {
                    // line 86
                    echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                    echo "=\"";
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable($context["val"]);
                    foreach ($context['_seq'] as $context["attr"] => $context["param"]) {
                        echo twig_escape_filter($this->env, $context["attr"], "html", null, true);
                        echo ":";
                        echo twig_escape_filter($this->env, $context["param"], "html", null, true);
                        echo ";";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['attr'], $context['param'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    echo "\"";
                } else {
                    // line 88
                    echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                    echo "=\"";
                    echo twig_escape_filter($this->env, $context["val"], "html", null, true);
                    echo "\"";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['val'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 91
            echo "    />";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 94
    public function gettext($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 95
            $context["form"] = $this;
            // line 97
            echo $context["form"]->getinput("text", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 100
    public function getpassword($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 101
            $context["form"] = $this;
            // line 103
            echo $context["form"]->getinput("password", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 106
    public function getbutton($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 107
            $context["form"] = $this;
            // line 109
            if ($this->getAttribute(($context["attributes"] ?? null), "class", array(), "any", true, true)) {
                // line 110
                $context["attributes"] = twig_array_merge(($context["attributes"] ?? null), array("class" => ($this->getAttribute(($context["attributes"] ?? null), "class", array()) . " button button-primary")));
            }
            // line 113
            echo $context["form"]->getinput("button", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 116
    public function getcheckbox($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 117
            $context["form"] = $this;
            // line 119
            echo $context["form"]->getinput("checkbox", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 122
    public function getfile($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 123
            $context["form"] = $this;
            // line 125
            echo $context["form"]->getinput("file", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 128
    public function gethidden($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 129
            $context["form"] = $this;
            // line 131
            echo $context["form"]->getinput("hidden", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 134
    public function getradio($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 135
            $context["form"] = $this;
            // line 137
            echo $context["form"]->getinput("radio", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 140
    public function getcolor($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 141
            $context["form"] = $this;
            // line 143
            echo $context["form"]->getinput("color", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 146
    public function getsubmit($__name__ = null, $__value__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 147
            $context["form"] = $this;
            // line 149
            if ($this->getAttribute(($context["attributes"] ?? null), "class", array(), "any", true, true)) {
                // line 150
                $context["attributes"] = twig_array_merge(($context["attributes"] ?? null), array("class" => ($this->getAttribute(($context["attributes"] ?? null), "class", array()) . " button button-primary")));
            }
            // line 153
            echo $context["form"]->getinput("submit", ($context["name"] ?? null), ($context["value"] ?? null), ($context["attributes"] ?? null));
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 156
    public function getselect($__name__ = null, $__options__ = null, $__selected__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "options" => $__options__,
            "selected" => $__selected__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 157
            echo "\t<select name=\"";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\"";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo ">";
            // line 158
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["options"] ?? null));
            foreach ($context['_seq'] as $context["value"] => $context["text"]) {
                // line 159
                echo "        <option value=\"";
                echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                echo "\" name = \"";
                echo twig_escape_filter($this->env, twig_lower_filter($this->env, $context["text"]), "html", null, true);
                echo "\"";
                if ((($context["selected"] ?? null) == $context["value"])) {
                    echo "selected";
                }
                echo ">";
                echo twig_escape_filter($this->env, $context["text"], "html", null, true);
                echo "</option>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['value'], $context['text'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 161
            echo "    </select>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 164
    public function getselectv($__name__ = null, $__options__ = null, $__selected__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "options" => $__options__,
            "selected" => $__selected__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 165
            echo "    <select name=\"";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\"";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo ">";
            // line 166
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["options"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["text"]) {
                // line 167
                echo "        <option value=\"";
                echo twig_escape_filter($this->env, $context["text"], "html", null, true);
                echo "\" name = \"";
                echo twig_escape_filter($this->env, twig_lower_filter($this->env, $context["text"]), "html", null, true);
                echo "\"";
                if ((($context["selected"] ?? null) == $context["text"])) {
                    echo "selected";
                }
                echo ">";
                echo twig_escape_filter($this->env, $context["text"], "html", null, true);
                echo "</option>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['text'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 169
            echo "    </select>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 172
    public function getselectWithElem($__name__ = null, $__options__ = null, $__selected__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "options" => $__options__,
            "selected" => $__selected__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 173
            echo "\t<select name=\"";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\"";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo ">";
            // line 174
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["options"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
                // line 175
                echo "\t\t<option value=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["value"], "value", array()), "html", null, true);
                echo "\" name = \"";
                echo twig_escape_filter($this->env, twig_lower_filter($this->env, $this->getAttribute($context["value"], "title", array())), "html", null, true);
                echo "\"";
                // line 176
                if ((($context["selected"] ?? null) == $this->getAttribute($context["value"], "value", array()))) {
                    echo "selected=\"selected\"";
                }
                // line 177
                if (($this->getAttribute($context["value"], "disabled", array()) == 1)) {
                    echo " disabled=\"disabled\"";
                }
                // line 178
                echo "\t\t>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["value"], "title", array()), "html", null, true);
                echo "</option>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 180
            echo "\t</select>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 183
    public function getspan($__name__ = null, $__text__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "text" => $__text__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 184
            echo "    <span name=\"";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\"";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo ">";
            // line 185
            echo twig_escape_filter($this->env, twig_lower_filter($this->env, ($context["text"] ?? null)), "html", null, true);
            echo "
    </span>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 189
    public function getselected($__actual__ = null, $__expected__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "actual" => $__actual__,
            "expected" => $__expected__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 190
            if ((($context["actual"] ?? null) == ($context["expected"] ?? null))) {
                echo "selected=\"selected\"";
            }
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 193
    public function getlabel($__label__ = null, $__for__ = null, $__attributes__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "label" => $__label__,
            "for" => $__for__,
            "attributes" => $__attributes__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 194
            echo "\t<label for=\"";
            echo twig_escape_filter($this->env, ($context["for"] ?? null), "html", null, true);
            echo "\"";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
            foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                echo twig_escape_filter($this->env, $context["attribute"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo ">";
            echo twig_escape_filter($this->env, ($context["label"] ?? null), "html", null, true);
            echo "</label>";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    // line 197
    public function geticon($__name__ = null, $__size__ = null, $__id__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "size" => $__size__,
            "id" => $__id__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 198
            echo "    <i class=\"fa";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo " mp-icon-preview\" style=\"font-size:";
            echo twig_escape_filter($this->env, ($context["size"] ?? null), "html", null, true);
            echo "px;\" id=\"";
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\"></i>";
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
        return "@core/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1036 => 198,  1022 => 197,  991 => 194,  977 => 193,  960 => 190,  947 => 189,  930 => 185,  914 => 184,  900 => 183,  885 => 180,  877 => 178,  873 => 177,  869 => 176,  863 => 175,  859 => 174,  843 => 173,  828 => 172,  813 => 169,  797 => 167,  793 => 166,  777 => 165,  762 => 164,  747 => 161,  731 => 159,  727 => 158,  711 => 157,  696 => 156,  681 => 153,  678 => 150,  676 => 149,  674 => 147,  660 => 146,  645 => 143,  643 => 141,  629 => 140,  614 => 137,  612 => 135,  598 => 134,  583 => 131,  581 => 129,  567 => 128,  552 => 125,  550 => 123,  536 => 122,  521 => 119,  519 => 117,  505 => 116,  490 => 113,  487 => 110,  485 => 109,  483 => 107,  469 => 106,  454 => 103,  452 => 101,  438 => 100,  423 => 97,  421 => 95,  407 => 94,  392 => 91,  382 => 88,  366 => 86,  364 => 85,  360 => 84,  352 => 83,  337 => 82,  320 => 78,  314 => 76,  311 => 74,  309 => 73,  304 => 70,  302 => 69,  292 => 68,  287 => 65,  285 => 64,  283 => 63,  281 => 62,  277 => 59,  275 => 58,  258 => 57,  240 => 52,  237 => 50,  232 => 48,  230 => 47,  228 => 46,  223 => 43,  221 => 42,  211 => 41,  206 => 38,  204 => 37,  196 => 36,  194 => 35,  190 => 33,  188 => 32,  180 => 31,  178 => 30,  176 => 29,  173 => 27,  168 => 25,  166 => 24,  164 => 22,  148 => 21,  121 => 17,  117 => 16,  112 => 15,  110 => 14,  108 => 12,  96 => 10,  81 => 7,  70 => 6,  44 => 3,  35 => 2,  21 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@core/form.twig", "C:\\xampp\\htdocs\\tuxcar\\wp-content\\plugins\\gallery-by-supsystic\\src\\GridGallery\\Core\\views\\form.twig");
    }
}
