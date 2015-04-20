<?php

/* user.twig */
class __TwigTemplate_27a34db2fce7ece8f557b57d8677801b33b5228bd6fd79247fbc299136aa7dd5 extends Twig_Template
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
            'pageTitle' => array($this, 'block_pageTitle'),
            'body' => array($this, 'block_body'),
            'root' => array($this, 'block_root'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 5
        $context["bodyClass"] = call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.bodyClass", "admin"));
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_pageTitle($context, array $blocks = array())
    {
        if ( !(isset($context["isCustomLogo"]) ? $context["isCustomLogo"] : $this->getContext($context, "isCustomLogo"))) {
            echo "Piwik &rsaquo; ";
        }
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_Administration")), "html", null, true);
    }

    // line 7
    public function block_body($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        if ((isset($context["userIsAnonymous"]) ? $context["userIsAnonymous"] : $this->getContext($context, "userIsAnonymous"))) {
            // line 9
            echo "        ";
            $context["topMenuModule"] = "Feedback";
            // line 10
            echo "        ";
            $context["topMenuAction"] = "index";
            // line 11
            echo "    ";
        } else {
            // line 12
            echo "        ";
            $context["topMenuModule"] = "UsersManager";
            // line 13
            echo "        ";
            $context["topMenuAction"] = "userSettings";
            // line 14
            echo "    ";
        }
        // line 15
        echo "    ";
        $this->displayParentBlock("body", $context, $blocks);
        echo "
";
    }

    // line 18
    public function block_root($context, array $blocks = array())
    {
        // line 19
        echo "    ";
        $this->env->loadTemplate("@CoreHome/_topScreen.twig")->display($context);
        // line 20
        echo "
    ";
        // line 21
        $context["ajax"] = $this->env->loadTemplate("ajaxMacros.twig");
        // line 22
        echo "    ";
        echo $context["ajax"]->getrequestErrorDiv(((array_key_exists("emailSuperUser", $context)) ? (_twig_default_filter((isset($context["emailSuperUser"]) ? $context["emailSuperUser"] : $this->getContext($context, "emailSuperUser")), "")) : ("")));
        echo "
    ";
        // line 23
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.beforeContent", "user", (isset($context["currentModule"]) ? $context["currentModule"] : $this->getContext($context, "currentModule"))));
        echo "

    <div id=\"container\">

        ";
        // line 27
        if (( !array_key_exists("showMenu", $context) || (isset($context["showMenu"]) ? $context["showMenu"] : $this->getContext($context, "showMenu")))) {
            // line 28
            echo "            ";
            $this->env->loadTemplate("@CoreHome/_userMenu.twig")->display($context);
            // line 29
            echo "        ";
        }
        // line 30
        echo "
        <div id=\"content\" class=\"admin user\">

            ";
        // line 33
        $this->env->loadTemplate("@CoreHome/_notifications.twig")->display($context);
        // line 34
        echo "
            <div class=\"ui-confirm\" id=\"alert\">
                <h2></h2>
                <input role=\"no\" type=\"button\" value=\"";
        // line 37
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
        echo "\"/>
            </div>

            ";
        // line 40
        $this->displayBlock('content', $context, $blocks);
        // line 42
        echo "
        </div>
    </div>
";
    }

    // line 40
    public function block_content($context, array $blocks = array())
    {
        // line 41
        echo "            ";
    }

    public function getTemplateName()
    {
        return "user.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  143 => 41,  140 => 40,  133 => 42,  131 => 40,  125 => 37,  120 => 34,  118 => 33,  113 => 30,  110 => 29,  107 => 28,  105 => 27,  98 => 23,  93 => 22,  91 => 21,  88 => 20,  85 => 19,  82 => 18,  75 => 15,  72 => 14,  69 => 13,  66 => 12,  63 => 11,  60 => 10,  57 => 9,  54 => 8,  51 => 7,  42 => 3,  38 => 1,  36 => 5,  11 => 1,);
    }
}
