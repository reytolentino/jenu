<?php

/* @SitesManager/siteWithoutData.twig */
class __TwigTemplate_d12bd6971982e1bbf81447779c49c79204cab627209843a3a2078dd1058e3990 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("dashboard.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'notification' => array($this, 'block_notification'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "dashboard.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_notification($context, array $blocks = array())
    {
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    ";
        // line 7
        $this->env->loadTemplate("@CoreHome/_siteSelectHeader.twig")->display($context);
        // line 8
        echo "
    <div class=\"site-without-data\">

        <h2>";
        // line 11
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataTitle")), "html", null, true);
        echo "</h2>

        <p>
            ";
        // line 14
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataDescription")), "html", null, true);
        echo "
            ";
        // line 15
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataSetupTracking", (("<a href=\"" . call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("module" => "CoreAdminHome", "action" => "trackingCodeGenerator")))) . "\">"), "</a>"));
        // line 18
        echo "
        </p>

        ";
        // line 21
        echo (isset($context["trackingHelp"]) ? $context["trackingHelp"] : $this->getContext($context, "trackingHelp"));
        echo "

    </div>

";
    }

    public function getTemplateName()
    {
        return "@SitesManager/siteWithoutData.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 21,  67 => 18,  65 => 15,  61 => 14,  55 => 11,  50 => 8,  48 => 7,  45 => 6,  42 => 5,  37 => 3,  11 => 1,);
    }
}
