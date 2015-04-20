<?php

/* @Installation/trackingCode.twig */
class __TwigTemplate_2dc795872c59d2608bf77e240d5a4b99dc2014a64d53c627cfc4159612ae8216 extends Twig_Template
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
        if (array_key_exists("displayfirstWebsiteSetupSuccess", $context)) {
            // line 5
            echo "    <span id=\"feedback\" class=\"success\">
\t";
            // line 6
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SetupWebsiteSetupSuccess", (isset($context["displaySiteName"]) ? $context["displaySiteName"] : $this->getContext($context, "displaySiteName")))), "html", null, true);
            echo "
        <img src=\"plugins/Morpheus/images/success_medium.png\"/>
</span>
";
        }
        // line 10
        echo "
";
        // line 11
        echo (isset($context["trackingHelp"]) ? $context["trackingHelp"] : $this->getContext($context, "trackingHelp"));
        echo "
<br/><br/>
<h2>";
        // line 13
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_LargePiwikInstances")), "html", null, true);
        echo "</h2>
";
        // line 14
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_JsTagArchivingHelp1", "<a rel=\"noreferrer\" target=\"_blank\" href=\"http://piwik.org/docs/setup-auto-archiving/\">", "</a>"));
        echo "
";
        // line 15
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_ReadThisToLearnMore", "<a rel=\"noreferrer\" target=\"_blank\" href=\"http://piwik.org/docs/optimize/\">", "</a>"));
        echo "

";
    }

    public function getTemplateName()
    {
        return "@Installation/trackingCode.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 15,  63 => 14,  59 => 13,  54 => 11,  51 => 10,  44 => 6,  41 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
