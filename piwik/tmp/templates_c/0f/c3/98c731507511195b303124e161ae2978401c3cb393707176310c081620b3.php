<?php

/* @MobileMessaging/index.twig */
class __TwigTemplate_0fc398c731507511195b303124e161ae2978401c3cb393707176310c081620b3 extends Twig_Template
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
        $context["macro"] = $this->env->loadTemplate("@MobileMessaging/macros.twig");
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
    ";
        // line 7
        if ((isset($context["isSuperUser"]) ? $context["isSuperUser"] : $this->getContext($context, "isSuperUser"))) {
            // line 8
            echo "        <h2>";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Settings")), "html", null, true);
            echo "</h2>
        <table class='adminTable' style='width:650px;'>
            <tr>
                <td style=\"width:400px;\">";
            // line 11
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_LetUsersManageAPICredential")), "html", null, true);
            echo "</td>
                <td style=\"width:250px;\">
                    <fieldset>
                        <input  type='radio'
                                value='false'
                                name='delegatedManagement' ";
            // line 16
            if ( !(isset($context["delegatedManagement"]) ? $context["delegatedManagement"] : $this->getContext($context, "delegatedManagement"))) {
                echo " checked='checked'";
            }
            // line 17
            echo "                                id=\"delegatedManagement\" />
                        <label for=\"delegatedManagement\">";
            // line 18
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
            echo "</label><br/>
                        <span class='form-description'>
                            (";
            // line 20
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Default")), "html", null, true);
            echo ") ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_LetUsersManageAPICredential_No_Help")), "html", null, true);
            echo "
                        </span>
                        <br/>
                        <br/>
                        <input
                                type='radio'
                                value='true'
                                name='delegatedManagement' ";
            // line 27
            if ((isset($context["delegatedManagement"]) ? $context["delegatedManagement"] : $this->getContext($context, "delegatedManagement"))) {
                echo " checked='checked'";
            }
            // line 28
            echo "                                id=\"delegatedManagement\" />
                        <label for=\"delegatedManagement\">";
            // line 29
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
            echo "</label><br/>
                        <span class='form-description'>";
            // line 30
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_LetUsersManageAPICredential_Yes_Help")), "html", null, true);
            echo "</span>

                    </fieldset>
            </tr>
        </table>
    ";
        }
        // line 36
        echo "
    ";
        // line 37
        if (((isset($context["accountManagedByCurrentUser"]) ? $context["accountManagedByCurrentUser"] : $this->getContext($context, "accountManagedByCurrentUser")) && (isset($context["delegatedManagement"]) ? $context["delegatedManagement"] : $this->getContext($context, "delegatedManagement")))) {
            // line 38
            echo "
        <h2 piwik-enriched-headline
                >";
            // line 40
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_SMSProvider")), "html", null, true);
            echo "</h2>
        To manage your SMS provider go to your <a href=\"";
            // line 41
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("action" => "userSettings"))), "html", null, true);
            echo "\">personal mobile messaging settings</a>.

    ";
        } elseif (        // line 43
(isset($context["accountManagedByCurrentUser"]) ? $context["accountManagedByCurrentUser"] : $this->getContext($context, "accountManagedByCurrentUser"))) {
            // line 44
            echo "
        <h2 piwik-enriched-headline
                >";
            // line 46
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_SMSProvider")), "html", null, true);
            echo "</h2>

        ";
            // line 48
            echo $context["macro"]->getmanageSmsApi((isset($context["credentialSupplied"]) ? $context["credentialSupplied"] : $this->getContext($context, "credentialSupplied")), (isset($context["creditLeft"]) ? $context["creditLeft"] : $this->getContext($context, "creditLeft")), (isset($context["smsProviders"]) ? $context["smsProviders"] : $this->getContext($context, "smsProviders")), (isset($context["provider"]) ? $context["provider"] : $this->getContext($context, "provider")));
            echo "
    ";
        }
        // line 50
        echo "
    ";
        // line 51
        $context["ajax"] = $this->env->loadTemplate("ajaxMacros.twig");
        // line 52
        echo "
    <div style=\"margin-top:10px\">
        ";
        // line 54
        echo $context["ajax"]->geterrorDiv("ajaxErrorMobileMessagingSettings");
        echo "
    </div>

    <h2>";
        // line 57
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_PhoneNumbers")), "html", null, true);
        echo "</h2>
    To manage your phone numbers go to your <a href=\"";
        // line 58
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("action" => "userSettings"))), "html", null, true);
        echo "\">personal mobile messaging settings</a>.

    ";
        // line 60
        echo $context["ajax"]->getloadingDiv("ajaxLoadingMobileMessagingSettings");
        echo "

    <div class='ui-confirm' id='confirmDeleteAccount'>
        <h2>";
        // line 63
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("MobileMessaging_Settings_DeleteAccountConfirm")), "html", null, true);
        echo "</h2>
        <input role='yes' type='button' value='";
        // line 64
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
        echo "'/>
        <input role='no' type='button' value='";
        // line 65
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
        echo "'/>
    </div>

";
    }

    public function getTemplateName()
    {
        return "@MobileMessaging/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  178 => 65,  174 => 64,  170 => 63,  164 => 60,  159 => 58,  155 => 57,  149 => 54,  145 => 52,  143 => 51,  140 => 50,  135 => 48,  130 => 46,  126 => 44,  124 => 43,  119 => 41,  115 => 40,  111 => 38,  109 => 37,  106 => 36,  97 => 30,  93 => 29,  90 => 28,  86 => 27,  74 => 20,  69 => 18,  66 => 17,  62 => 16,  54 => 11,  47 => 8,  45 => 7,  42 => 6,  39 => 5,  35 => 1,  33 => 3,  11 => 1,);
    }
}
