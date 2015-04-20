<?php

/* @Installation/systemCheckPage.twig */
class __TwigTemplate_f4b8f0ae70c315e8aeee77d24087901097ac461b4b3953d827cbdb9595a1aa9f extends Twig_Template
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
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        if ((isset($context["isSuperUser"]) ? $context["isSuperUser"] : $this->getContext($context, "isSuperUser"))) {
            // line 5
            echo "    <h2 piwik-enriched-headline>";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheck")), "html", null, true);
            echo "</h2>
    <p style=\"margin-left:0.2em;\">
        ";
            // line 7
            if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "has_errors", array())) {
                // line 8
                echo "            <img src=\"plugins/Morpheus/images/error.png\"/>
            ";
                // line 9
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckSummaryThereWereErrors", "<strong>", "</strong>", "<strong><em>", "</em></strong>"));
                echo " ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SeeBelowForMoreInfo")), "html", null, true);
                echo "
        ";
            } elseif ($this->getAttribute(            // line 10
(isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "has_warnings", array())) {
                // line 11
                echo "            <img src=\"plugins/Morpheus/images/warning.png\"/>
            ";
                // line 12
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckSummaryThereWereWarnings")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SeeBelowForMoreInfo")), "html", null, true);
                echo "
        ";
            } else {
                // line 14
                echo "            <img src=\"plugins/Morpheus/images/ok.png\"/>
            ";
                // line 15
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckSummaryNoProblems")), "html", null, true);
                echo "
        ";
            }
            // line 17
            echo "    </p>
    ";
            // line 18
            $this->env->loadTemplate("@Installation/_systemCheckSection.twig")->display($context);
        }
    }

    public function getTemplateName()
    {
        return "@Installation/systemCheckPage.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 18,  78 => 17,  73 => 15,  70 => 14,  63 => 12,  60 => 11,  58 => 10,  52 => 9,  49 => 8,  47 => 7,  41 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
