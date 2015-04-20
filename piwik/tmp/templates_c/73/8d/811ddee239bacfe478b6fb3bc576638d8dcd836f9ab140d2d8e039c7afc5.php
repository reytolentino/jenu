<?php

/* @API/listAllAPI.twig */
class __TwigTemplate_738d811ddee239bacfe478b6fb3bc576638d8dcd836f9ab140d2d8e039c7afc5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("user.twig");
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
        return "user.twig";
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
<div>

    <h2>";
        // line 7
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("API_QuickDocumentationTitle")), "html", null, true);
        echo "</h2>

    ";
        // line 9
        $this->env->loadTemplate("@CoreHome/_siteSelectHeader.twig")->display($context);
        // line 10
        echo "
    <div class=\"top_controls\">
        ";
        // line 12
        $this->env->loadTemplate("@CoreHome/_periodSelect.twig")->display($context);
        // line 13
        echo "    </div>

    <p>";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("API_PluginDescription")), "html", null, true);
        echo "</p>

    <p>
        ";
        // line 18
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("API_MoreInformation", "<a target='_blank' href='?module=Proxy&action=redirect&url=http://piwik.org/docs/analytics-api'>", "</a>", "<a target='_blank' href='?module=Proxy&action=redirect&url=http://piwik.org/docs/analytics-api/reference'>", "</a>"));
        echo "
    </p>

    <h2>";
        // line 21
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("API_UserAuthentication")), "html", null, true);
        echo "</h2>

    <p>
        ";
        // line 24
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("API_UsingTokenAuth", "", "", ""));
        echo "<br/>
        <span id='token_auth'>&amp;token_auth=<strong>";
        // line 25
        echo twig_escape_filter($this->env, (isset($context["token_auth"]) ? $context["token_auth"] : $this->getContext($context, "token_auth")), "html", null, true);
        echo "</strong></span><br/>
        ";
        // line 26
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("API_KeepTokenSecret", "<b>", "</b>"));
        echo "
        ";
        // line 27
        echo (isset($context["list_api_methods_with_links"]) ? $context["list_api_methods_with_links"] : $this->getContext($context, "list_api_methods_with_links"));
        echo "
        <br/>
</div>
";
    }

    public function getTemplateName()
    {
        return "@API/listAllAPI.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 27,  87 => 26,  83 => 25,  79 => 24,  73 => 21,  67 => 18,  61 => 15,  57 => 13,  55 => 12,  51 => 10,  49 => 9,  44 => 7,  39 => 4,  36 => 3,  11 => 1,);
    }
}
