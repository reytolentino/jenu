<?php

/* @UsersManager/index.twig */
class __TwigTemplate_e338ee848af32c983d3c265190b1ad4a4d1e633ba7c1b687526bd81d79ed8633 extends Twig_Template
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
            'websiteAccessTable' => array($this, 'block_websiteAccessTable'),
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
        echo "
<h2 piwik-enriched-headline
    help-url=\"http://piwik.org/docs/manage-users/\">";
        // line 6
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ManageAccess")), "html", null, true);
        echo "</h2>
<div id=\"sites\" class=\"usersManager\">
    <section class=\"sites_selector_container\">
        <p>";
        // line 9
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_MainDescription")), "html", null, true);
        echo "</p>

        <div class=\"sites_selector_title\">";
        // line 11
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_Sites")), "html", null, true);
        echo ":</div>

        ";
        // line 13
        ob_start();
        // line 14
        echo "            <strong>";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ApplyToAllWebsites")), "html", null, true);
        echo "</strong>
        ";
        $context["applyAllSitesText"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 16
        echo "
        <div piwik-siteselector
             class=\"sites_autocomplete\"
             siteid=\"";
        // line 19
        echo twig_escape_filter($this->env, (isset($context["idSiteSelected"]) ? $context["idSiteSelected"] : $this->getContext($context, "idSiteSelected")), "html", null, true);
        echo "\"
             sitename=\"";
        // line 20
        echo twig_escape_filter($this->env, (isset($context["defaultReportSiteName"]) ? $context["defaultReportSiteName"] : $this->getContext($context, "defaultReportSiteName")), "html", null, true);
        echo "\"
             all-sites-text=\"";
        // line 21
        echo (isset($context["applyAllSitesText"]) ? $context["applyAllSitesText"] : $this->getContext($context, "applyAllSitesText"));
        echo "\"
             all-sites-location=\"top\"
             id=\"usersManagerSiteSelect\"
             switch-site-on-select=\"false\"></div>
    </section>
</div>

";
        // line 28
        $this->displayBlock('websiteAccessTable', $context, $blocks);
        // line 213
        echo "
";
    }

    // line 28
    public function block_websiteAccessTable($context, array $blocks = array())
    {
        // line 29
        echo "
";
        // line 30
        $context["ajax"] = $this->env->loadTemplate("ajaxMacros.twig");
        // line 31
        echo $context["ajax"]->geterrorDiv();
        echo "
";
        // line 32
        echo $context["ajax"]->getloadingDiv();
        echo "

<div class=\"entityContainer\" style=\"width:600px;\">
    ";
        // line 35
        if ((isset($context["anonymousHasViewAccess"]) ? $context["anonymousHasViewAccess"] : $this->getContext($context, "anonymousHasViewAccess"))) {
            // line 36
            echo "        <div style=\"display:inline-block;margin-top:10px;\" id=\"usersManagerAnonymousUserHasViewAccess\">
            ";
            // line 37
            echo call_user_func_array($this->env->getFilter('notification')->getCallable(), array(twig_join_filter(array(0 => call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_AnonymousUserHasViewAccess", "'anonymous'", "'view'")), 1 => call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_AnonymousUserHasViewAccess2"))), " "), array("placeAt" => "#usersManagerAnonymousUserHasViewAccess", "noclear" => true)));
            echo "
        </div>
    ";
        }
        // line 40
        echo "    <table class=\"entityTable dataTable\" id=\"access\" style=\"display:inline-table;width:500px;\">
        <thead>
        <tr>
            <th class='first'>";
        // line 43
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_User")), "html", null, true);
        echo "</th>
            <th>";
        // line 44
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_Alias")), "html", null, true);
        echo "</th>
            <th>";
        // line 45
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_PrivNone")), "html", null, true);
        echo "</th>
            <th>";
        // line 46
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_PrivView")), "html", null, true);
        echo "</th>
            <th>";
        // line 47
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_PrivAdmin")), "html", null, true);
        echo "</th>
        </tr>
        </thead>

        <tbody>
        ";
        // line 52
        $context["accesValid"] = ('' === $tmp = "<img src='plugins/UsersManager/images/ok.png' class='accessGranted' />") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 53
        echo "        ";
        $context["accesInvalid"] = ('' === $tmp = "<img src='plugins/UsersManager/images/no-access.png' class='updateAccess' />") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 54
        echo "        ";
        ob_start();
        echo "<span title=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ExceptionSuperUserAccess")), "html", null, true);
        echo "\">N/A</span>";
        $context["superUserAccess"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 55
        echo "        ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["usersAccessByWebsite"]) ? $context["usersAccessByWebsite"] : $this->getContext($context, "usersAccessByWebsite")));
        foreach ($context['_seq'] as $context["login"] => $context["access"]) {
            // line 56
            echo "            <tr>
                <td id='login'>";
            // line 57
            echo twig_escape_filter($this->env, $context["login"], "html", null, true);
            echo "</td>
                <td>";
            // line 58
            echo $this->getAttribute((isset($context["usersAliasByLogin"]) ? $context["usersAliasByLogin"] : $this->getContext($context, "usersAliasByLogin")), $context["login"], array(), "array");
            echo "</td>
                <td id='noaccess'>
                    ";
            // line 60
            if (twig_in_filter($context["login"], (isset($context["superUserLogins"]) ? $context["superUserLogins"] : $this->getContext($context, "superUserLogins")))) {
                // line 61
                echo "                        ";
                echo twig_escape_filter($this->env, (isset($context["superUserAccess"]) ? $context["superUserAccess"] : $this->getContext($context, "superUserAccess")), "html", null, true);
                echo "
                    ";
            } elseif (((            // line 62
$context["access"] == "noaccess") && ((isset($context["idSiteSelected"]) ? $context["idSiteSelected"] : $this->getContext($context, "idSiteSelected")) != "all"))) {
                // line 63
                echo "                        ";
                echo twig_escape_filter($this->env, (isset($context["accesValid"]) ? $context["accesValid"] : $this->getContext($context, "accesValid")), "html", null, true);
                echo "
                    ";
            } else {
                // line 65
                echo "                        ";
                echo twig_escape_filter($this->env, (isset($context["accesInvalid"]) ? $context["accesInvalid"] : $this->getContext($context, "accesInvalid")), "html", null, true);
                echo "
                    ";
            }
            // line 66
            echo "&nbsp;</td>
                <td id='view'>
                    ";
            // line 68
            if (twig_in_filter($context["login"], (isset($context["superUserLogins"]) ? $context["superUserLogins"] : $this->getContext($context, "superUserLogins")))) {
                // line 69
                echo "                        ";
                echo twig_escape_filter($this->env, (isset($context["superUserAccess"]) ? $context["superUserAccess"] : $this->getContext($context, "superUserAccess")), "html", null, true);
                echo "
                    ";
            } elseif (((            // line 70
$context["access"] == "view") && ((isset($context["idSiteSelected"]) ? $context["idSiteSelected"] : $this->getContext($context, "idSiteSelected")) != "all"))) {
                // line 71
                echo "                        ";
                echo twig_escape_filter($this->env, (isset($context["accesValid"]) ? $context["accesValid"] : $this->getContext($context, "accesValid")), "html", null, true);
                echo "
                    ";
            } else {
                // line 73
                echo "                        ";
                echo twig_escape_filter($this->env, (isset($context["accesInvalid"]) ? $context["accesInvalid"] : $this->getContext($context, "accesInvalid")), "html", null, true);
                echo "
                    ";
            }
            // line 74
            echo "&nbsp;</td>
                <td id='admin'>
                    ";
            // line 76
            if (twig_in_filter($context["login"], (isset($context["superUserLogins"]) ? $context["superUserLogins"] : $this->getContext($context, "superUserLogins")))) {
                // line 77
                echo "                        ";
                echo twig_escape_filter($this->env, (isset($context["superUserAccess"]) ? $context["superUserAccess"] : $this->getContext($context, "superUserAccess")), "html", null, true);
                echo "
                    ";
            } elseif ((            // line 78
$context["login"] == "anonymous")) {
                // line 79
                echo "                        N/A
                    ";
            } else {
                // line 81
                echo "                        ";
                if ((($context["access"] == "admin") && ((isset($context["idSiteSelected"]) ? $context["idSiteSelected"] : $this->getContext($context, "idSiteSelected")) != "all"))) {
                    echo twig_escape_filter($this->env, (isset($context["accesValid"]) ? $context["accesValid"] : $this->getContext($context, "accesValid")), "html", null, true);
                } else {
                    echo twig_escape_filter($this->env, (isset($context["accesInvalid"]) ? $context["accesInvalid"] : $this->getContext($context, "accesInvalid")), "html", null, true);
                }
                echo "&nbsp;
                    ";
            }
            // line 83
            echo "                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['login'], $context['access'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 86
        echo "        </tbody>
    </table>
    <div id=\"accessUpdated\" style=\"vertical-align:top;\"></div>
</div>

<div class=\"ui-confirm\" id=\"confirm\">
    <h2>";
        // line 92
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ChangeAllConfirm", "<span id='login'></span>"));
        echo "</h2>
    <input role=\"yes\" type=\"button\" value=\"";
        // line 93
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
        echo "\"/>
    <input role=\"no\" type=\"button\" value=\"";
        // line 94
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
        echo "\"/>
</div>

";
        // line 97
        if ((isset($context["userIsSuperUser"]) ? $context["userIsSuperUser"] : $this->getContext($context, "userIsSuperUser"))) {
            // line 98
            echo "    <div class=\"ui-confirm\" id=\"confirmUserRemove\">
        <h2></h2>
        <input role=\"yes\" type=\"button\" value=\"";
            // line 100
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
            echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
            // line 101
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
            echo "\"/>
    </div>
    <div class=\"ui-confirm\" id=\"confirmPasswordChange\">
        <h2>";
            // line 104
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ChangePasswordConfirm")), "html", null, true);
            echo "</h2>
        <input role=\"yes\" type=\"button\" value=\"";
            // line 105
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
            echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
            // line 106
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
            echo "\"/>
    </div>
    <br/>
    <h2>";
            // line 109
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_UsersManagement")), "html", null, true);
            echo "</h2>
    <p>";
            // line 110
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_UsersManagementMainDescription")), "html", null, true);
            echo "
        ";
            // line 111
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ThereAreCurrentlyNRegisteredUsers", (("<b>" . (isset($context["usersCount"]) ? $context["usersCount"] : $this->getContext($context, "usersCount"))) . "</b>")));
            echo "</p>
    ";
            // line 112
            $context["ajax"] = $this->env->loadTemplate("ajaxMacros.twig");
            // line 113
            echo "    ";
            echo $context["ajax"]->geterrorDiv("ajaxErrorUsersManagement");
            echo "
    ";
            // line 114
            echo $context["ajax"]->getloadingDiv("ajaxLoadingUsersManagement");
            echo "
    <div class=\"user entityContainer\" style=\"margin-bottom:50px;\">
        <table class=\"entityTable dataTable\" id=\"users\">
            <thead>
            <tr>
                <th>";
            // line 119
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Username")), "html", null, true);
            echo "</th>
                <th>";
            // line 120
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Password")), "html", null, true);
            echo "</th>
                <th>";
            // line 121
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_Email")), "html", null, true);
            echo "</th>
                <th>";
            // line 122
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_Alias")), "html", null, true);
            echo "</th>
                <th>token_auth</th>
                ";
            // line 124
            if ((array_key_exists("showLastSeen", $context) && (isset($context["showLastSeen"]) ? $context["showLastSeen"] : $this->getContext($context, "showLastSeen")))) {
                // line 125
                echo "                <th>";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_LastSeen")), "html", null, true);
                echo "</th>
                ";
            }
            // line 127
            echo "                <th>";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Edit")), "html", null, true);
            echo "</th>
                <th>";
            // line 128
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Delete")), "html", null, true);
            echo "</th>
            </tr>
            </thead>

            <tbody>
            ";
            // line 133
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["users"]) ? $context["users"] : $this->getContext($context, "users")));
            foreach ($context['_seq'] as $context["i"] => $context["user"]) {
                // line 134
                echo "                ";
                if (($this->getAttribute($context["user"], "login", array()) != "anonymous")) {
                    // line 135
                    echo "                    <tr class=\"editable\" id=\"row";
                    echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                    echo "\">
                        <td id=\"userLogin\" class=\"editable\">";
                    // line 136
                    echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "login", array()), "html", null, true);
                    echo "</td>
                        <td id=\"password\" class=\"editable\">-</td>
                        <td id=\"email\" class=\"editable\">";
                    // line 138
                    echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "email", array()), "html", null, true);
                    echo "</td>
                        <td id=\"alias\" class=\"editable\">";
                    // line 139
                    echo $this->getAttribute($context["user"], "alias", array());
                    echo "</td>
                        <td id=\"token_auth\" class=\"token_auth\" data-token=\"";
                    // line 140
                    echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "token_auth", array()), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_slice($this->env, $this->getAttribute($context["user"], "token_auth", array()), 0, 8), "html", null, true);
                    echo "…</td>
                        ";
                    // line 141
                    if ($this->getAttribute($context["user"], "last_seen", array(), "any", true, true)) {
                        // line 142
                        echo "                        <td id=\"last_seen\">";
                        if (twig_test_empty($this->getAttribute($context["user"], "last_seen", array()))) {
                            echo "-";
                        } else {
                            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_TimeAgo", $this->getAttribute($context["user"], "last_seen", array())));
                        }
                        echo "</td>
                        ";
                    }
                    // line 144
                    echo "                        <td>
                            <span class=\"edituser link_but\" id=\"row";
                    // line 145
                    echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                    echo "\">
                                <img title=\"";
                    // line 146
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Edit")), "html", null, true);
                    echo "\" src='plugins/Morpheus/images/ico_edit.png'/>
                                <span>";
                    // line 147
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Edit")), "html", null, true);
                    echo "</span>
                            </span>
                        </td>
                        <td>
                            <span class=\"deleteuser link_but\" id=\"row";
                    // line 151
                    echo twig_escape_filter($this->env, $context["i"], "html", null, true);
                    echo "\">
                                <img title=\"";
                    // line 152
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Delete")), "html", null, true);
                    echo "\" src='plugins/Morpheus/images/ico_delete.png'/>
                                <span>";
                    // line 153
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Delete")), "html", null, true);
                    echo "</span>
                            </span>
                        </td>
                    </tr>
                ";
                }
                // line 158
                echo "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['i'], $context['user'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 159
            echo "            </tbody>
        </table>
        <div class=\"addrow\"><img src='plugins/Morpheus/images/add.png'/> ";
            // line 161
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_AddUser")), "html", null, true);
            echo "</div>
    </div>

    <h2 id=\"super_user_access\">";
            // line 164
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_SuperUserAccessManagement")), "html", null, true);
            echo "</h2>
    <p>";
            // line 165
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_SuperUserAccessManagementMainDescription")), "html", null, true);
            echo " <br/>
    ";
            // line 166
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_SuperUserAccessManagementGrantMore")), "html", null, true);
            echo "</p>

    ";
            // line 168
            echo $context["ajax"]->geterrorDiv("ajaxErrorSuperUsersManagement");
            echo "
    ";
            // line 169
            echo $context["ajax"]->getloadingDiv("ajaxLoadingSuperUsersManagement");
            echo "

    <table class=\"entityTable dataTable\" id=\"superUserAccess\" style=\"display:inline-table;width:400px;\">
        <thead>
        <tr>
            <th class='first'>";
            // line 174
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_User")), "html", null, true);
            echo "</th>
            <th>";
            // line 175
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_Alias")), "html", null, true);
            echo "</th>
            <th>";
            // line 176
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SuperUser")), "html", null, true);
            echo "</th>
        </tr>
        </thead>

        <tbody>
        ";
            // line 181
            if ((twig_length_filter($this->env, (isset($context["users"]) ? $context["users"] : $this->getContext($context, "users"))) > 1)) {
                // line 182
                echo "            ";
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable((isset($context["usersAliasByLogin"]) ? $context["usersAliasByLogin"] : $this->getContext($context, "usersAliasByLogin")));
                foreach ($context['_seq'] as $context["login"] => $context["alias"]) {
                    if (($context["login"] != "anonymous")) {
                        // line 183
                        echo "                <tr>
                    <td id='login'>";
                        // line 184
                        echo twig_escape_filter($this->env, $context["login"], "html", null, true);
                        echo "</td>
                    <td>";
                        // line 185
                        echo $context["alias"];
                        echo "</td>
                    <td id='superuser' data-login=\"";
                        // line 186
                        echo twig_escape_filter($this->env, $context["login"], "html_attr");
                        echo "\">
                        <img src='plugins/UsersManager/images/ok.png' class='accessGranted' data-hasaccess=\"1\" ";
                        // line 187
                        if ( !twig_in_filter($context["login"], (isset($context["superUserLogins"]) ? $context["superUserLogins"] : $this->getContext($context, "superUserLogins")))) {
                            echo "style=\"display:none\"";
                        }
                        echo " />
                        <img src='plugins/UsersManager/images/no-access.png' class='updateAccess' data-hasaccess=\"0\" ";
                        // line 188
                        if (twig_in_filter($context["login"], (isset($context["superUserLogins"]) ? $context["superUserLogins"] : $this->getContext($context, "superUserLogins")))) {
                            echo "style=\"display:none\"";
                        }
                        echo " />
                        &nbsp;
                    </td>
                </tr>
            ";
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['login'], $context['alias'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 193
                echo "        ";
            } else {
                // line 194
                echo "            <tr>
                <td colspan=\"3\">
                    ";
                // line 196
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_NoUsersExist")), "html", null, true);
                echo "
                </td>
            </tr>
        ";
            }
            // line 200
            echo "        </tbody>
    </table>

    <div id=\"superUserAccessUpdated\" style=\"vertical-align:top;\"></div>

    <div class=\"ui-confirm\" id=\"superUserAccessConfirm\">
        <h2> </h2>
        <input role=\"yes\" type=\"button\" value=\"";
            // line 207
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
            echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
            // line 208
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
            echo "\"/>
    </div>

";
        }
    }

    public function getTemplateName()
    {
        return "@UsersManager/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  587 => 208,  583 => 207,  574 => 200,  567 => 196,  563 => 194,  560 => 193,  546 => 188,  540 => 187,  536 => 186,  532 => 185,  528 => 184,  525 => 183,  519 => 182,  517 => 181,  509 => 176,  505 => 175,  501 => 174,  493 => 169,  489 => 168,  484 => 166,  480 => 165,  476 => 164,  470 => 161,  466 => 159,  460 => 158,  452 => 153,  448 => 152,  444 => 151,  437 => 147,  433 => 146,  429 => 145,  426 => 144,  416 => 142,  414 => 141,  408 => 140,  404 => 139,  400 => 138,  395 => 136,  390 => 135,  387 => 134,  383 => 133,  375 => 128,  370 => 127,  364 => 125,  362 => 124,  357 => 122,  353 => 121,  349 => 120,  345 => 119,  337 => 114,  332 => 113,  330 => 112,  326 => 111,  322 => 110,  318 => 109,  312 => 106,  308 => 105,  304 => 104,  298 => 101,  294 => 100,  290 => 98,  288 => 97,  282 => 94,  278 => 93,  274 => 92,  266 => 86,  258 => 83,  248 => 81,  244 => 79,  242 => 78,  237 => 77,  235 => 76,  231 => 74,  225 => 73,  219 => 71,  217 => 70,  212 => 69,  210 => 68,  206 => 66,  200 => 65,  194 => 63,  192 => 62,  187 => 61,  185 => 60,  180 => 58,  176 => 57,  173 => 56,  168 => 55,  161 => 54,  158 => 53,  156 => 52,  148 => 47,  144 => 46,  140 => 45,  136 => 44,  132 => 43,  127 => 40,  121 => 37,  118 => 36,  116 => 35,  110 => 32,  106 => 31,  104 => 30,  101 => 29,  98 => 28,  93 => 213,  91 => 28,  81 => 21,  77 => 20,  73 => 19,  68 => 16,  62 => 14,  60 => 13,  55 => 11,  50 => 9,  44 => 6,  40 => 4,  37 => 3,  11 => 1,);
    }
}
