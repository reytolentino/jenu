<?php

/* @Installation/firstWebsiteSetup.twig */
class __TwigTemplate_1ea8fdc159510adad25d351673ad17edc7a1aad2529de638713b414773d97df4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("@Installation/layout.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Installation/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        if (array_key_exists("displayGeneralSetupSuccess", $context)) {
            // line 5
            echo "    <span id=\"feedback\" class=\"success\">
\t    ";
            // line 6
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SuperUserSetupSuccess")), "html", null, true);
            echo "
        <img src=\"plugins/Morpheus/images/success_medium.png\"/>
    </span>
";
        }
        // line 10
        echo "
<h2>";
        // line 11
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SetupWebsite")), "html", null, true);
        echo "</h2>
<p>";
        // line 12
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SiteSetup")), "html", null, true);
        echo "</p>
";
        // line 13
        if (array_key_exists("errorMessage", $context)) {
            // line 14
            echo "    <div class=\"error\">
        <img src=\"plugins/Morpheus/images/error_medium.png\"/>
        ";
            // line 16
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SetupWebsiteError")), "html", null, true);
            echo ":
        <br/>- ";
            // line 17
            echo (isset($context["errorMessage"]) ? $context["errorMessage"] : $this->getContext($context, "errorMessage"));
            echo "

    </div>
";
        }
        // line 21
        echo "
";
        // line 22
        if (array_key_exists("form_data", $context)) {
            // line 23
            echo "    ";
            $this->env->loadTemplate("genericForm.twig")->display($context);
        }
        // line 25
        echo "<br/>
<p><em>";
        // line 26
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SiteSetupFootnote")), "html", null, true);
        echo "</em></p>
";
    }

    public function getTemplateName()
    {
        return "@Installation/firstWebsiteSetup.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 26,  88 => 25,  84 => 23,  82 => 22,  79 => 21,  72 => 17,  68 => 16,  64 => 14,  62 => 13,  58 => 12,  54 => 11,  51 => 10,  44 => 6,  41 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
