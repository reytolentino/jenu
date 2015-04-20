<?php

/* @Installation/finished.twig */
class __TwigTemplate_e3bf60a245abf1211bbb2af2a47da155f7ef36b83d9dfc60c7272577127659fe extends Twig_Template
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
        echo "
<h2>";
        // line 5
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_Congratulations"));
        echo "</h2>
";
        // line 6
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_CongratulationsHelp"));
        echo "
<br/>

<h2>";
        // line 9
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_WelcomeToCommunity")), "html", null, true);
        echo "</h2>
<p>
    ";
        // line 11
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_CollaborativeProject")), "html", null, true);
        echo "
</p>
<p>
    ";
        // line 14
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_GetInvolved", "<a  rel=\"noreferrer\"  target=\"_blank\" href=\"http://piwik.org/get-involved/\">", "</a>"));
        echo "
    ";
        // line 15
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_HelpTranslatePiwik", "<a rel='noreferrer' target='_blank' href='http://piwik.org/translations/'>", "</a>"));
        echo "
</p>
<p>";
        // line 17
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_WeHopeYouWillEnjoyPiwik")), "html", null, true);
        echo "</p>
<p><i>";
        // line 18
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_HappyAnalysing")), "html", null, true);
        echo "</i></p>
<br/>

<h2>";
        // line 21
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_DefaultSettings")), "html", null, true);
        echo "</h2>
<p>";
        // line 22
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_DefaultSettingsHelp")), "html", null, true);
        echo "</p>
";
        // line 23
        if (array_key_exists("errorMessage", $context)) {
            // line 24
            echo "    <div class=\"error\">
        <img src=\"plugins/Morpheus/images/error_medium.png\"/>
        ";
            // line 26
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Error")), "html", null, true);
            echo ":
        <br/>- ";
            // line 27
            echo (isset($context["errorMessage"]) ? $context["errorMessage"] : $this->getContext($context, "errorMessage"));
            echo "
    </div>
";
        }
        // line 30
        if (array_key_exists("form_data", $context)) {
            // line 31
            echo "    ";
            $this->env->loadTemplate("genericForm.twig")->display($context);
        }
        // line 33
        echo "
";
    }

    public function getTemplateName()
    {
        return "@Installation/finished.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 33,  108 => 31,  106 => 30,  100 => 27,  96 => 26,  92 => 24,  90 => 23,  86 => 22,  82 => 21,  76 => 18,  72 => 17,  67 => 15,  63 => 14,  57 => 11,  52 => 9,  46 => 6,  42 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
