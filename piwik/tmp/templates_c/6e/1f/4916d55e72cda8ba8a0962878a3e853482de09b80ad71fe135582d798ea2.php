<?php

/* genericForm.twig */
class __TwigTemplate_6e1f4916d55e72cda8ba8a0962878a3e853482de09b80ad71fe135582d798ea2 extends Twig_Template
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
        // line 1
        if ($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), "errors", array())) {
            // line 2
            echo "\t<div class=\"warning\">
\t\t<img src=\"plugins/Morpheus/images/warning_medium.png\">
\t\t<strong>";
            // line 4
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_PleaseFixTheFollowingErrors")), "html", null, true);
            echo ":</strong>
\t\t<ul>
            ";
            // line 6
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), "errors", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["data"]) {
                // line 7
                echo "\t\t\t\t<li>";
                echo $context["data"];
                echo "</li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['data'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 9
            echo "\t\t</ul>
\t</div>
";
        }
        // line 12
        echo "
<form ";
        // line 13
        echo $this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), "attributes", array());
        echo ">
\t<div class=\"centrer\">
\t\t<table class=\"centrer\">
            ";
        // line 16
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["element_list"]) ? $context["element_list"] : $this->getContext($context, "element_list")));
        foreach ($context['_seq'] as $context["_key"] => $context["fieldname"]) {
            // line 17
            echo "\t\t\t\t";
            if (($this->getAttribute($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "type", array()) == "checkbox")) {
                // line 18
                echo "\t\t\t\t\t<tr>
\t\t\t\t\t\t<td colspan=2>";
                // line 19
                echo $this->getAttribute($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "html", array());
                echo "</td>
\t\t\t\t\t</tr>
\t\t\t\t";
            } elseif ($this->getAttribute($this->getAttribute(            // line 21
(isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "label", array())) {
                // line 22
                echo "\t\t\t\t\t<tr>
\t\t\t\t\t\t<td>";
                // line 23
                echo $this->getAttribute($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "label", array());
                echo "</td>
\t\t\t\t\t\t<td>";
                // line 24
                echo $this->getAttribute($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "html", array());
                echo "</td>
\t\t\t\t\t</tr>
\t\t\t\t";
            } elseif (($this->getAttribute($this->getAttribute(            // line 26
(isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "type", array()) == "hidden")) {
                // line 27
                echo "\t\t\t\t\t<tr>
\t\t\t\t\t\t<td colspan=2>";
                // line 28
                echo $this->getAttribute($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), $context["fieldname"], array(), "array"), "html", array());
                echo "</td>
\t\t\t\t\t</tr>
\t\t\t\t";
            }
            // line 31
            echo "\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['fieldname'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "\t\t</table>
\t</div>

\t";
        // line 35
        echo $this->getAttribute($this->getAttribute((isset($context["form_data"]) ? $context["form_data"] : $this->getContext($context, "form_data")), "submit", array()), "html", array());
        echo "
</form>
";
    }

    public function getTemplateName()
    {
        return "genericForm.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  108 => 35,  103 => 32,  97 => 31,  91 => 28,  88 => 27,  86 => 26,  81 => 24,  77 => 23,  74 => 22,  72 => 21,  67 => 19,  64 => 18,  61 => 17,  57 => 16,  51 => 13,  48 => 12,  43 => 9,  34 => 7,  30 => 6,  25 => 4,  21 => 2,  19 => 1,);
    }
}
