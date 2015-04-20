<?php

/* @MobileMessaging/macros.twig */
class __TwigTemplate_4f578d0767c479a1a8db18251a9c9cfbf677f790c481d7d8fb9bb44014377351 extends Twig_Template
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
    }

    // line 1
    public function getmanageSmsApi($__credentialSupplied__ = null, $__creditLeft__ = null, $__smsProviders__ = null, $__provider__ = null)
    {
        $context = $this->env->mergeGlobals(array(
            "credentialSupplied" => $__credentialSupplied__,
            "creditLeft" => $__creditLeft__,
            "smsProviders" => $__smsProviders__,
            "provider" => $__provider__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            echo "    ";
            if ((isset($context["credentialSupplied"]) ? $context["credentialSupplied"] : $this->getContext($context, "credentialSupplied"))) {
                // line 3
                echo "        ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_CredentialProvided", (isset($context["provider"]) ? $context["provider"] : $this->getContext($context, "provider")))), "html", null, true);
                echo "
        ";
                // line 4
                echo twig_escape_filter($this->env, (isset($context["creditLeft"]) ? $context["creditLeft"] : $this->getContext($context, "creditLeft")), "html", null, true);
                echo "
        <br/>
        ";
                // line 6
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_UpdateOrDeleteAccount", "<a id='displayAccountForm'>", "</a>", "<a id='deleteAccount'>", "</a>"));
                echo "
    ";
            } else {
                // line 8
                echo "        ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_PleaseSignUp")), "html", null, true);
                echo "
    ";
            }
            // line 10
            echo "    <div id='accountForm' ";
            if ((isset($context["credentialSupplied"]) ? $context["credentialSupplied"] : $this->getContext($context, "credentialSupplied"))) {
                echo "style='display: none;'";
            }
            echo ">
        <br/>
        ";
            // line 12
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_SMSProvider")), "html", null, true);
            echo "
        <select id='smsProviders'>
            ";
            // line 14
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["smsProviders"]) ? $context["smsProviders"] : $this->getContext($context, "smsProviders")));
            foreach ($context['_seq'] as $context["smsProvider"] => $context["description"]) {
                // line 15
                echo "                <option value='";
                echo twig_escape_filter($this->env, $context["smsProvider"], "html", null, true);
                echo "'>
                    ";
                // line 16
                echo twig_escape_filter($this->env, $context["smsProvider"], "html", null, true);
                echo "
                </option>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['smsProvider'], $context['description'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo "        </select>

        ";
            // line 21
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_APIKey")), "html", null, true);
            echo "
        <input size='25' id='apiKey'/>

        <input type='submit' value='";
            // line 24
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Save")), "html", null, true);
            echo "' id='apiAccountSubmit' class='submit'/>

        ";
            // line 26
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["smsProviders"]) ? $context["smsProviders"] : $this->getContext($context, "smsProviders")));
            foreach ($context['_seq'] as $context["smsProvider"] => $context["description"]) {
                // line 27
                echo "            <div class='providerDescription' id='";
                echo twig_escape_filter($this->env, $context["smsProvider"], "html", null, true);
                echo "'>
                ";
                // line 28
                echo $context["description"];
                echo "
            </div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['smsProvider'], $context['description'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 31
            echo "
    </div>
";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "@MobileMessaging/macros.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  123 => 31,  114 => 28,  109 => 27,  105 => 26,  100 => 24,  94 => 21,  90 => 19,  81 => 16,  76 => 15,  72 => 14,  67 => 12,  59 => 10,  53 => 8,  48 => 6,  43 => 4,  38 => 3,  35 => 2,  21 => 1,);
    }
}
