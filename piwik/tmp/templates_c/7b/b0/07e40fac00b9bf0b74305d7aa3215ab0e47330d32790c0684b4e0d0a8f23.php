<?php

/* dashboard.twig */
class __TwigTemplate_7bb007e40fac00b9bf0b74305d7aa3215ab0e47330d32790c0684b4e0d0a8f23 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("layout.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'pageTitle' => array($this, 'block_pageTitle'),
            'pageDescription' => array($this, 'block_pageDescription'),
            'body' => array($this, 'block_body'),
            'root' => array($this, 'block_root'),
            'notification' => array($this, 'block_notification'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 14
        $context["bodyClass"] = call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.bodyClass", "dashboard"));
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "

    <!--[if lt IE 9]>
    <script language=\"javascript\" type=\"text/javascript\" src=\"libs/jqplot/excanvas.min.js\"></script>
    <![endif]-->
";
    }

    // line 11
    public function block_pageTitle($context, array $blocks = array())
    {
        echo (isset($context["siteName"]) ? $context["siteName"] : $this->getContext($context, "siteName"));
        echo " - ";
        if ( !(isset($context["isCustomLogo"]) ? $context["isCustomLogo"] : $this->getContext($context, "isCustomLogo"))) {
            echo "Piwik &rsaquo;";
        }
        echo " ";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_WebAnalyticsReports")), "html", null, true);
    }

    // line 12
    public function block_pageDescription($context, array $blocks = array())
    {
        echo "Web Analytics report for ";
        echo twig_escape_filter($this->env, (isset($context["siteName"]) ? $context["siteName"] : $this->getContext($context, "siteName")), "html_attr");
        echo " - Piwik";
    }

    // line 16
    public function block_body($context, array $blocks = array())
    {
        // line 17
        echo "    ";
        $this->displayParentBlock("body", $context, $blocks);
        echo "
    ";
        // line 18
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.footer"));
        echo "
";
    }

    // line 21
    public function block_root($context, array $blocks = array())
    {
        // line 22
        echo "    ";
        $this->env->loadTemplate("@CoreHome/_warningInvalidHost.twig")->display($context);
        // line 23
        echo "    ";
        $this->env->loadTemplate("@CoreHome/_topScreen.twig")->display($context);
        // line 24
        echo "
    ";
        // line 25
        $this->displayBlock('notification', $context, $blocks);
        // line 28
        echo "
    <div class=\"ui-confirm\" id=\"alert\">
        <h2></h2>
        <input role=\"yes\" type=\"button\" value=\"";
        // line 31
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
        echo "\"/>
    </div>

    ";
        // line 34
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.beforeContent", "dashboard", (isset($context["currentModule"]) ? $context["currentModule"] : $this->getContext($context, "currentModule"))));
        echo "

    ";
        // line 36
        $this->displayBlock('content', $context, $blocks);
    }

    // line 25
    public function block_notification($context, array $blocks = array())
    {
        // line 26
        echo "        ";
        $this->env->loadTemplate("@CoreHome/_notifications.twig")->display($context);
        // line 27
        echo "    ";
    }

    // line 36
    public function block_content($context, array $blocks = array())
    {
        // line 37
        echo "    ";
    }

    public function getTemplateName()
    {
        return "dashboard.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  140 => 37,  137 => 36,  133 => 27,  130 => 26,  127 => 25,  123 => 36,  118 => 34,  112 => 31,  107 => 28,  105 => 25,  102 => 24,  99 => 23,  96 => 22,  93 => 21,  87 => 18,  82 => 17,  79 => 16,  71 => 12,  59 => 11,  48 => 4,  45 => 3,  41 => 1,  39 => 14,  11 => 1,);
    }
}
