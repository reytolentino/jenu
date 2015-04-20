<?php

/* @CorePluginsAdmin/plugins.twig */
class __TwigTemplate_5ec3cbe52ecd0cb613f55ff9abf26bebf686c36e24499e8703c954fbfad32e81 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("admin.twig");
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
        return "admin.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        $context["plugins"] = $this->env->loadTemplate("@CorePluginsAdmin/macros.twig");
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "<div>

    ";
        // line 8
        if (twig_length_filter($this->env, (isset($context["pluginsHavingUpdate"]) ? $context["pluginsHavingUpdate"] : $this->getContext($context, "pluginsHavingUpdate")))) {
            // line 9
            echo "        <h2>";
            echo twig_escape_filter($this->env, twig_length_filter($this->env, (isset($context["pluginsHavingUpdate"]) ? $context["pluginsHavingUpdate"] : $this->getContext($context, "pluginsHavingUpdate"))), "html", null, true);
            echo " Update(s) available</h2>

        <p>";
            // line 11
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CorePluginsAdmin_InfoPluginUpdateIsRecommended")), "html", null, true);
            echo "</p>

        ";
            // line 13
            echo $context["plugins"]->gettablePluginUpdates((isset($context["pluginsHavingUpdate"]) ? $context["pluginsHavingUpdate"] : $this->getContext($context, "pluginsHavingUpdate")), (isset($context["updateNonce"]) ? $context["updateNonce"] : $this->getContext($context, "updateNonce")), (isset($context["activateNonce"]) ? $context["activateNonce"] : $this->getContext($context, "activateNonce")), 0);
            echo "
    ";
        }
        // line 15
        echo "
    <h2 piwik-enriched-headline>";
        // line 16
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CorePluginsAdmin_PluginsManagement")), "html", null, true);
        echo "</h2>

    <p>";
        // line 18
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CorePluginsAdmin_PluginsExtendPiwik")), "html", null, true);
        echo "
        ";
        // line 19
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CorePluginsAdmin_OncePluginIsInstalledYouMayActivateHere")), "html", null, true);
        echo "

    ";
        // line 21
        if ( !(isset($context["isPluginsAdminEnabled"]) ? $context["isPluginsAdminEnabled"] : $this->getContext($context, "isPluginsAdminEnabled"))) {
            // line 22
            echo "        <br/>";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CorePluginsAdmin_DoMoreContactPiwikAdmins")), "html", null, true);
            echo "
    ";
        }
        // line 24
        echo "

    ";
        // line 26
        if ((isset($context["isMarketplaceEnabled"]) ? $context["isMarketplaceEnabled"] : $this->getContext($context, "isMarketplaceEnabled"))) {
            // line 27
            echo "        <br />
        ";
            // line 28
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CorePluginsAdmin_ChangeLookByManageThemes", (("<a href=\"" . call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("action" => "themes")))) . "\">"), "</a>"));
            echo "
    ";
        }
        // line 30
        echo "    </p>

    ";
        // line 32
        echo $context["plugins"]->getpluginsFilter(false, (isset($context["isMarketplaceEnabled"]) ? $context["isMarketplaceEnabled"] : $this->getContext($context, "isMarketplaceEnabled")));
        echo "

    ";
        // line 34
        echo $context["plugins"]->gettablePlugins((isset($context["pluginsInfo"]) ? $context["pluginsInfo"] : $this->getContext($context, "pluginsInfo")), (isset($context["pluginNamesHavingSettings"]) ? $context["pluginNamesHavingSettings"] : $this->getContext($context, "pluginNamesHavingSettings")), (isset($context["activateNonce"]) ? $context["activateNonce"] : $this->getContext($context, "activateNonce")), (isset($context["deactivateNonce"]) ? $context["deactivateNonce"] : $this->getContext($context, "deactivateNonce")), (isset($context["uninstallNonce"]) ? $context["uninstallNonce"] : $this->getContext($context, "uninstallNonce")), false, (isset($context["marketplacePluginNames"]) ? $context["marketplacePluginNames"] : $this->getContext($context, "marketplacePluginNames")), (isset($context["isPluginsAdminEnabled"]) ? $context["isPluginsAdminEnabled"] : $this->getContext($context, "isPluginsAdminEnabled")));
        echo "

</div>
";
    }

    public function getTemplateName()
    {
        return "@CorePluginsAdmin/plugins.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 34,  107 => 32,  103 => 30,  98 => 28,  95 => 27,  93 => 26,  89 => 24,  83 => 22,  81 => 21,  76 => 19,  72 => 18,  67 => 16,  64 => 15,  59 => 13,  54 => 11,  48 => 9,  46 => 8,  42 => 6,  39 => 5,  35 => 1,  33 => 3,  11 => 1,);
    }
}
