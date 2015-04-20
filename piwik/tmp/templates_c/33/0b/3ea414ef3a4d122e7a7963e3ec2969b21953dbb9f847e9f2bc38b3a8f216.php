<?php

/* @PrivacyManager/privacySettings.twig */
class __TwigTemplate_330b3ea414ef3a4d122e7a7963e3ec2969b21953dbb9f847e9f2bc38b3a8f216 extends Twig_Template
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
        $context["piwik"] = $this->env->loadTemplate("macros.twig");
        // line 5
        if ((isset($context["isSuperUser"]) ? $context["isSuperUser"] : $this->getContext($context, "isSuperUser"))) {
            // line 6
            echo "    <h2 piwik-enriched-headline
        help-url=\"http://piwik.org/docs/privacy/\">";
            // line 7
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_TeaserHeadline")), "html", null, true);
            echo "</h2>
    <p>";
            // line 8
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_Teaser", "<a href=\"#anonymizeIPAnchor\">", "</a>", "<a href=\"#deleteLogsAnchor\">", "</a>", "<a href=\"#optOutAnchor\">", "</a>"));
            echo "
        ";
            // line 9
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_SeeAlsoOurOfficialGuidePrivacy", "<a href=\"http://piwik.org/privacy/\" rel=\"noreferrer\"  target=\"_blank\">", "</a>"));
            echo "</p>
    <h2 id=\"anonymizeIPAnchor\">";
            // line 10
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_UseAnonymizeIp")), "html", null, true);
            echo "</h2>
    <form method=\"post\" action=\"";
            // line 11
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('urlRewriteWithParameters')->getCallable(), array(array("action" => "saveSettings", "form" => "formMaskLength", "token_auth" => (isset($context["token_auth"]) ? $context["token_auth"] : $this->getContext($context, "token_auth"))))), "html", null, true);
            echo "\" id=\"formMaskLength\">
        <div id='anonymizeIpSettings'>
            <table class=\"adminTable\" style='width:800px;'>
                <tr>
                    <td width=\"250\">";
            // line 15
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_UseAnonymizeIp")), "html", null, true);
            echo "<br/>
                        <span class=\"form-description\">";
            // line 16
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_AnonymizeIpDescription")), "html", null, true);
            echo "</span>
                    </td>
                    <td width='500'>
                        <input id=\"anonymizeIPEnable-1\" type=\"radio\" name=\"anonymizeIPEnable\" value=\"1\" ";
            // line 19
            if (($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "enabled", array()) == "1")) {
                echo "checked ";
            }
            echo "/>
                        <label for=\"anonymizeIPEnable-1\">";
            // line 20
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
            echo "</label>
                        <input class=\"indented-radio-button\" id=\"anonymizeIPEnable-0\" type=\"radio\" name=\"anonymizeIPEnable\" value=\"0\" ";
            // line 21
            if (($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "enabled", array()) == "0")) {
                echo " checked ";
            }
            echo "/>
                        <label for=\"anonymizeIPEnable-0\">";
            // line 22
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
            echo "</label>
                        <input type=\"hidden\" name=\"token_auth\" value=\"";
            // line 23
            echo twig_escape_filter($this->env, (isset($context["token_auth"]) ? $context["token_auth"] : $this->getContext($context, "token_auth")), "html", null, true);
            echo "\"/>
                    </td>
                    <td width=\"200\">
                        <div style=\"width:180px\">
                            ";
            // line 27
            echo $context["piwik"]->getinlineHelp(call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_AnonymizeIpInlineHelp")));
            echo "
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div id=\"anonymizeIPenabled\">
            <table class=\"adminTable\" style='width:800px;'>
                <tr>
                    <td width=\"250\">";
            // line 36
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_AnonymizeIpMaskLengtDescription")), "html", null, true);
            echo "</td>
                    <td width=\"500\">
                        <input id=\"maskLength-1\" type=\"radio\" name=\"maskLength\" value=\"1\" ";
            // line 38
            if (($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "maskLength", array()) == "1")) {
                // line 39
                echo "                            checked ";
            }
            echo "/>
                        <label for=\"maskLength-1\">";
            // line 40
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_AnonymizeIpMaskLength", "1", "192.168.100.xxx")), "html", null, true);
            echo "</label><br/>
                        <input id=\"maskLength-2\" type=\"radio\" name=\"maskLength\" value=\"2\" ";
            // line 41
            if (($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "maskLength", array()) == "2")) {
                // line 42
                echo "                            checked ";
            }
            echo "/>
                        <label for=\"maskLength-2\">";
            // line 43
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_AnonymizeIpMaskLength", "2", "192.168.xxx.xxx")), "html", null, true);
            echo " <span
                                    class=\"form-description\">";
            // line 44
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Recommended")), "html", null, true);
            echo "</span></label><br/>
                        <input id=\"maskLength-3\" type=\"radio\" name=\"maskLength\" value=\"3\" ";
            // line 45
            if (($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "maskLength", array()) == "3")) {
                // line 46
                echo "                            checked ";
            }
            echo "/>
                        <label for=\"maskLength-3\">";
            // line 47
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_AnonymizeIpMaskLength", "3", "192.xxx.xxx.xxx")), "html", null, true);
            echo "</label>
                    </td>
                    <td width=\"200\">
                        <div style=\"width:180px\">
                            ";
            // line 51
            echo $context["piwik"]->getinlineHelp(call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_GeolocationAnonymizeIpNote")));
            echo "
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width=\"250\">
                        ";
            // line 57
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_UseAnonymizedIpForVisitEnrichment")), "html", null, true);
            echo "
                    </td>
                    <td width='500'>
                        <input id=\"useAnonymizedIpForVisitEnrichment-1\" type=\"radio\" name=\"useAnonymizedIpForVisitEnrichment\" value=\"1\" ";
            // line 60
            if (($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "useAnonymizedIpForVisitEnrichment", array()) == "1")) {
                echo "checked ";
            }
            echo "/>
                        <label for=\"useAnonymizedIpForVisitEnrichment-1\">";
            // line 61
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
            echo "</label>
                        <span class=\"form-description\">
                            ";
            // line 63
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_RecommendedForPrivacy")), "html", null, true);
            echo "
                        </span>
                        <br/>
                        <input id=\"useAnonymizedIpForVisitEnrichment-2\" type=\"radio\" name=\"useAnonymizedIpForVisitEnrichment\" value=\"0\" ";
            // line 66
            if (($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "useAnonymizedIpForVisitEnrichment", array()) == "0")) {
                echo " checked ";
            }
            echo "/>
                        <label for=\"useAnonymizedIpForVisitEnrichment-2\">";
            // line 67
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
            echo "</label>
                    </td>
                    <td width=\"200\">
                        <div style=\"width:180px\">
                            ";
            // line 71
            echo $context["piwik"]->getinlineHelp(call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_UseAnonymizedIpForVisitEnrichmentNote")));
            echo "
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <input type=\"hidden\" name=\"nonce\" value=\"";
            // line 78
            if ($this->getAttribute((isset($context["anonymizeIP"]) ? $context["anonymizeIP"] : $this->getContext($context, "anonymizeIP")), "enabled", array())) {
                echo twig_escape_filter($this->env, (isset($context["deactivateNonce"]) ? $context["deactivateNonce"] : $this->getContext($context, "deactivateNonce")), "html", null, true);
            } else {
                echo twig_escape_filter($this->env, (isset($context["activateNonce"]) ? $context["activateNonce"] : $this->getContext($context, "activateNonce")), "html", null, true);
            }
            echo "\">

        <input type=\"submit\" value=\"";
            // line 80
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Save")), "html", null, true);
            echo "\" id=\"privacySettingsSubmit\" class=\"submit\"/>
    </form>

    ";
            // line 83
            if ((isset($context["isDataPurgeSettingsEnabled"]) ? $context["isDataPurgeSettingsEnabled"] : $this->getContext($context, "isDataPurgeSettingsEnabled"))) {
                // line 84
                echo "    <div class=\"ui-confirm\" id=\"confirmDeleteSettings\">
        <h2 id=\"deleteLogsConfirm\">";
                // line 85
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteLogsConfirm")), "html", null, true);
                echo "</h2>

        <h2 id=\"deleteReportsConfirm\">";
                // line 87
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteReportsConfirm")), "html", null, true);
                echo "</h2>

        <h2 id=\"deleteBothConfirm\">";
                // line 89
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteBothConfirm")), "html", null, true);
                echo "</h2>
        <input role=\"yes\" type=\"button\" value=\"";
                // line 90
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
                echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
                // line 91
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
                echo "\"/>
    </div>
    <div class=\"ui-confirm\" id=\"saveSettingsBeforePurge\">
        <h2>";
                // line 94
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_SaveSettingsBeforePurge")), "html", null, true);
                echo "</h2>
        <input role=\"yes\" type=\"button\" value=\"";
                // line 95
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
                echo "\"/>
    </div>
    <div class=\"ui-confirm\" id=\"confirmPurgeNow\">
        <h2>";
                // line 98
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_PurgeNowConfirm")), "html", null, true);
                echo "</h2>
        <input role=\"yes\" type=\"button\" value=\"";
                // line 99
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
                echo "\"/>
        <input role=\"no\" type=\"button\" value=\"";
                // line 100
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
                echo "\"/>
    </div>
    <h2 id=\"deleteLogsAnchor\">";
                // line 102
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteDataSettings")), "html", null, true);
                echo "</h2>
    <p>";
                // line 103
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteDataDescription")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteDataDescription2")), "html", null, true);
                echo "</p>
    <form method=\"post\" action=\"";
                // line 104
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('urlRewriteWithParameters')->getCallable(), array(array("action" => "saveSettings", "form" => "formDeleteSettings", "token_auth" => (isset($context["token_auth"]) ? $context["token_auth"] : $this->getContext($context, "token_auth"))))), "html", null, true);
                echo "\" id=\"formDeleteSettings\">
        <table class=\"adminTable\" style='width:800px;'>
            <tr id='deleteLogSettingEnabled'>
                <td width=\"250\">";
                // line 107
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_UseDeleteLog")), "html", null, true);
                echo "<br/>

                </td>
                <td width='500'>
                    <input id=\"deleteEnable-1\" type=\"radio\" name=\"deleteEnable\" value=\"1\" ";
                // line 111
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_logs_enable", array()) == "1")) {
                    // line 112
                    echo "                        checked ";
                }
                echo "/>
                    <label for=\"deleteEnable-1\">";
                // line 113
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
                echo "</label>
                    <input class=\"indented-radio-button\" id=\"deleteEnable-2\" type=\"radio\" name=\"deleteEnable\" value=\"0\"
                                  ";
                // line 115
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_logs_enable", array()) == "0")) {
                    // line 116
                    echo "                        checked ";
                }
                echo "/>
                    <label for=\"deleteEnable-2\">";
                // line 117
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
                echo "</label>
\t\t\t\t<span id=\"privacyManagerDeleteLogDescription\" style=\"margin-top: 10px;display:inline-block;\">
                    ";
                // line 119
                ob_start();
                // line 120
                echo "                        ";
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteLogDescription2"));
                echo "
                        <a href=\"http://piwik.org/faq/general/#faq_125\" rel=\"noreferrer\"  target=\"_blank\">
                            ";
                // line 122
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_ClickHere")), "html", null, true);
                echo "
                        </a>
                    ";
                $context["deleteLogDescription"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 125
                echo "                    ";
                echo call_user_func_array($this->env->getFilter('notification')->getCallable(), array((isset($context["deleteLogDescription"]) ? $context["deleteLogDescription"] : $this->getContext($context, "deleteLogDescription")), array("raw" => true, "placeat" => "#privacyManagerDeleteLogDescription", "noclear" => true, "context" => "warning")));
                echo "
\t\t\t\t</span>
                </td>
                <td width=\"200\">
                    ";
                // line 129
                ob_start();
                // line 130
                echo "                        ";
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteLogInfo", $this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "deleteTables", array())));
                echo "
                        ";
                // line 131
                if ( !(isset($context["canDeleteLogActions"]) ? $context["canDeleteLogActions"] : $this->getContext($context, "canDeleteLogActions"))) {
                    // line 132
                    echo "                            <br/>
                            <br/>
                            ";
                    // line 134
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_CannotLockSoDeleteLogActions", (isset($context["dbUser"]) ? $context["dbUser"] : $this->getContext($context, "dbUser")))), "html", null, true);
                    echo "
                        ";
                }
                // line 136
                echo "                    ";
                $context["deleteLogInfo"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 137
                echo "                    ";
                echo $context["piwik"]->getinlineHelp((isset($context["deleteLogInfo"]) ? $context["deleteLogInfo"] : $this->getContext($context, "deleteLogInfo")));
                echo "
                </td>
            </tr>
            <tr id=\"deleteLogSettings\">
                <td width=\"250\">&nbsp;</td>
                <td width=\"500\">
                    <label>";
                // line 143
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteLogsOlderThan")), "html", null, true);
                echo "
                        <input type=\"text\" id=\"deleteOlderThan\" value=\"";
                // line 144
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_logs_older_than", array()), "html", null, true);
                echo "\" style=\"width:55px;\"
                               name=\"deleteOlderThan\"/>
                        ";
                // line 146
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_PeriodDays")), "html", null, true);
                echo "</label><br/>
                    <span class=\"form-description\">";
                // line 147
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_LeastDaysInput", "1")), "html", null, true);
                echo "</span>
                </td>
                <td width=\"200\">

                </td>
            </tr>
            <tr id='deleteReportsSettingEnabled'>
                <td width=\"250\">";
                // line 154
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_UseDeleteReports")), "html", null, true);
                echo "
                </td>
                <td width=\"500\">
                    <input id=\"deleteReportsEnable-1\" type=\"radio\" name=\"deleteReportsEnable\" value=\"1\" ";
                // line 157
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_enable", array()) == "1")) {
                    echo "checked=\"true\"";
                }
                echo " />
                    <label for=\"deleteReportsEnable-1\">";
                // line 158
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
                echo "</label>
                    <input class=\"indented-radio-button\" id=\"deleteReportsEnable-2\" type=\"radio\" name=\"deleteReportsEnable\" value=\"0\" ";
                // line 159
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_enable", array()) == "0")) {
                    echo "checked=\"true\"";
                }
                echo "/>
                    <label for=\"deleteReportsEnable-2\">";
                // line 160
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
                echo "</label>

                    ";
                // line 162
                ob_start();
                // line 163
                echo "                        ";
                ob_start();
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_UseDeleteLog")), "html", null, true);
                $context["deleteOldLogs"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 164
                echo "                        ";
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteReportsInfo", "<em>", "</em>"));
                echo "
                        <span id='deleteOldReportsMoreInfo'><br/><br/>
                            ";
                // line 166
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteReportsInfo2", (isset($context["deleteOldLogs"]) ? $context["deleteOldLogs"] : $this->getContext($context, "deleteOldLogs")))), "html", null, true);
                echo "<br/><br/>
                            ";
                // line 167
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteReportsInfo3", (isset($context["deleteOldLogs"]) ? $context["deleteOldLogs"] : $this->getContext($context, "deleteOldLogs")))), "html", null, true);
                echo "</span>
                    ";
                $context["useDeleteLog"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 169
                echo "                    <span id=\"privacyManagerUseDeleteLog\" style=\"margin-top: 10px;display:inline-block;\">
                        ";
                // line 170
                echo call_user_func_array($this->env->getFilter('notification')->getCallable(), array((isset($context["useDeleteLog"]) ? $context["useDeleteLog"] : $this->getContext($context, "useDeleteLog")), array("raw" => true, "placeat" => "#privacyManagerUseDeleteLog", "noclear" => true, "context" => "warning")));
                echo "
                    </span>
                </td>
                <td width=\"200\">
                    ";
                // line 174
                echo $context["piwik"]->getinlineHelp(call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteReportsDetailedInfo", "archive_numeric_*", "archive_blob_*")));
                echo "
                </td>
            </tr>
            <tr id='deleteReportsSettings'>
                <td width=\"250\">&nbsp;</td>
                <td width=\"500\">
                    <label>";
                // line 180
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteReportsOlderThan")), "html", null, true);
                echo "
                        <input type=\"text\" id=\"deleteReportsOlderThan\" value=\"";
                // line 181
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_older_than", array()), "html", null, true);
                echo "\" style=\"width:42px;\"
                               name=\"deleteReportsOlderThan\"/>
                        ";
                // line 183
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_PeriodMonths")), "html", null, true);
                echo "
                    </label><br/>
                    <span class=\"form-description\">";
                // line 185
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_LeastMonthsInput", "3")), "html", null, true);
                echo "</span><br/><br/>
                    <input id=\"deleteReportsKeepBasic\" type=\"checkbox\" name=\"deleteReportsKeepBasic\" value=\"1\"
                                  ";
                // line 187
                if ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_keep_basic_metrics", array())) {
                    echo "checked=\"true\"";
                }
                echo ">
                    <label for=\"deleteReportsKeepBasic\">";
                // line 188
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_KeepBasicMetrics")), "html", null, true);
                echo "
                        <span class=\"form-description\">";
                // line 189
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Recommended")), "html", null, true);
                echo "</span>
                    </label><br/><br/>
                    ";
                // line 191
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_KeepDataFor")), "html", null, true);
                echo "<br/><br/>
                    <input id=\"deleteReportsKeepDay\" type=\"checkbox\" name=\"deleteReportsKeepDay\" value=\"1\"
                                  ";
                // line 193
                if ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_keep_day_reports", array())) {
                    echo "checked=\"true\"";
                }
                echo ">
                    <label for=\"deleteReportsKeepDay\">";
                // line 194
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_DailyReports")), "html", null, true);
                echo "</label><br/>
                    <input type=\"checkbox\" name=\"deleteReportsKeepWeek\" value=\"1\" id=\"deleteReportsKeepWeek\"
                                  ";
                // line 196
                if ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_keep_week_reports", array())) {
                    echo "checked=\"true\"";
                }
                echo ">
                    <label for=\"deleteReportsKeepWeek\">";
                // line 197
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_WeeklyReports")), "html", null, true);
                echo "</label><br/>
                    <input type=\"checkbox\" name=\"deleteReportsKeepMonth\" value=\"1\" id=\"deleteReportsKeepMonth\"
                                  ";
                // line 199
                if ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_keep_month_reports", array())) {
                    echo "checked=\"true\"";
                }
                echo ">
                    <label for=\"deleteReportsKeepMonth\">";
                // line 200
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_MonthlyReports")), "html", null, true);
                echo "<span
                                class=\"form-description\">";
                // line 201
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Recommended")), "html", null, true);
                echo "</span></label><br/>
                    <input type=\"checkbox\" name=\"deleteReportsKeepYear\" value=\"1\" id=\"deleteReportsKeepYear\"
                                  ";
                // line 203
                if ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_keep_year_reports", array())) {
                    echo "checked=\"true\"";
                }
                echo ">
                    <label for=\"deleteReportsKeepYear\">";
                // line 204
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_YearlyReports")), "html", null, true);
                echo "<span
                                class=\"form-description\">";
                // line 205
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Recommended")), "html", null, true);
                echo "</span></label><br/>
                    <input type=\"checkbox\" name=\"deleteReportsKeepRange\" value=\"1\" id=\"deleteReportsKeepRange\"
                                  ";
                // line 207
                if ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_keep_range_reports", array())) {
                    echo "checked=\"true\"";
                }
                echo ">
                    <label for=\"deleteReportsKeepRange\">";
                // line 208
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_RangeReports")), "html", null, true);
                echo "
                    </label><br/><br/>
                    <input type=\"checkbox\" name=\"deleteReportsKeepSegments\" value=\"1\" id=\"deleteReportsKeepSegments\"
                                  ";
                // line 211
                if ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_keep_segment_reports", array())) {
                    echo "checked=\"true\"";
                }
                echo ">
                    <label for=\"deleteReportsKeepSegments\">";
                // line 212
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_KeepReportSegments")), "html", null, true);
                echo "</label><br/>
                </td>
                <td width=\"200\">

                </td>
            </tr>
            <tr id=\"deleteDataEstimateSect\"
                ";
                // line 219
                if ((($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_reports_enable", array()) == "0") && ($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_logs_enable", array()) == "0"))) {
                    echo "style=\"display:none;\"";
                }
                echo ">
                <td width=\"250\">";
                // line 220
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_ReportsDataSavedEstimate")), "html", null, true);
                echo "<br/></td>
                <td width=\"500\">
                    <div id=\"deleteDataEstimate\"></div>
                    <span class=\"loadingPiwik\" style=\"display:none;\"><img
                                src=\"./plugins/Morpheus/images/loading-blue.gif\"/> ";
                // line 224
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_LoadingData")), "html", null, true);
                echo "</span>
                </td>
                <td width=\"200\">
                    ";
                // line 227
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "enable_auto_database_size_estimate", array()) == "0")) {
                    // line 228
                    echo "                        ";
                    ob_start();
                    // line 229
                    echo "                            <em><a id=\"getPurgeEstimateLink\" style=\"width:280px\" class=\"ui-inline-help\" href=\"#\">";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_GetPurgeEstimate")), "html", null, true);
                    echo "</a></em>
                        ";
                    $context["manualEstimate"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                    // line 231
                    echo "                        ";
                    echo $context["piwik"]->getinlineHelp((isset($context["manualEstimate"]) ? $context["manualEstimate"] : $this->getContext($context, "manualEstimate")));
                    echo "
                    ";
                }
                // line 233
                echo "                </td>
            </tr>
            <tr id=\"deleteSchedulingSettings\">
                <td width=\"250\">";
                // line 236
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteSchedulingSettings")), "html", null, true);
                echo "<br/></td>
                <td width=\"500\">
                    <label>";
                // line 238
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DeleteDataInterval")), "html", null, true);
                echo "
                        <select id=\"deleteLowestInterval\" name=\"deleteLowestInterval\">
                            <option ";
                // line 240
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_logs_schedule_lowest_interval", array()) == "1")) {
                    echo " selected=\"selected\" ";
                }
                // line 241
                echo "                                    value=\"1\"> ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_PeriodDay")), "html", null, true);
                echo "</option>
                            <option ";
                // line 242
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_logs_schedule_lowest_interval", array()) == "7")) {
                    echo " selected=\"selected\" ";
                }
                // line 243
                echo "                                    value=\"7\">";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_PeriodWeek")), "html", null, true);
                echo "</option>
                            <option ";
                // line 244
                if (($this->getAttribute($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "config", array()), "delete_logs_schedule_lowest_interval", array()) == "30")) {
                    echo " selected=\"selected\" ";
                }
                // line 245
                echo "                                    value=\"30\">";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_PeriodMonth")), "html", null, true);
                echo "</option>
                        </select></label><br/><br/>
                </td>
                <td width=\"200\">
                    ";
                // line 249
                ob_start();
                // line 250
                echo "                        ";
                if ($this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "lastRun", array())) {
                    echo "<strong>";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_LastDelete")), "html", null, true);
                    echo ":</strong>
                            ";
                    // line 251
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "lastRunPretty", array()), "html", null, true);
                    echo "
                            <br/>
                            <br/>
                        ";
                }
                // line 255
                echo "                        <strong>";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_NextDelete")), "html", null, true);
                echo ":</strong>
                        ";
                // line 256
                echo $this->getAttribute((isset($context["deleteData"]) ? $context["deleteData"] : $this->getContext($context, "deleteData")), "nextRunPretty", array());
                echo "
                        <br/>
                        <br/>
                        <em><a id=\"purgeDataNowLink\" href=\"#\">";
                // line 259
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_PurgeNow")), "html", null, true);
                echo "</a></em>
                        <span class=\"loadingPiwik\" style=\"display:none;\"><img
                                    src=\"./plugins/Morpheus/images/loading-blue.gif\"/> ";
                // line 261
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_PurgingData")), "html", null, true);
                echo "</span>
                        <span id=\"db-purged-message\" style=\"display: none;\"><em>";
                // line 262
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DBPurged")), "html", null, true);
                echo "</em></span>
                    ";
                $context["purgeStats"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 264
                echo "                    ";
                echo $context["piwik"]->getinlineHelp((isset($context["purgeStats"]) ? $context["purgeStats"] : $this->getContext($context, "purgeStats")));
                echo "
                </td>
            </tr>
        </table>
        <input type=\"button\" value=\"";
                // line 268
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Save")), "html", null, true);
                echo "\" id=\"deleteLogSettingsSubmit\" class=\"submit\"/>
    </form>

    ";
            }
            // line 272
            echo "
    <h2 id=\"DNT\">";
            // line 273
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_SupportDNTPreference")), "html", null, true);
            echo "</h2>
    <table class=\"adminTable\" style='width:800px;'>
        <tr>
            <td width=\"650\">
                <p>
                    ";
            // line 278
            if ((isset($context["dntSupport"]) ? $context["dntSupport"] : $this->getContext($context, "dntSupport"))) {
                // line 279
                echo "                        ";
                $context["action"] = "deactivateDoNotTrack";
                // line 280
                echo "                        ";
                $context["nonce"] = (isset($context["deactivateNonce"]) ? $context["deactivateNonce"] : $this->getContext($context, "deactivateNonce"));
                // line 281
                echo "                        <strong>";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_Enabled")), "html", null, true);
                echo "</strong>
                        <br/>
                        ";
                // line 283
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_EnabledMoreInfo")), "html", null, true);
                echo "
                    ";
            } else {
                // line 285
                echo "                        ";
                $context["action"] = "activateDoNotTrack";
                // line 286
                echo "                        ";
                $context["nonce"] = (isset($context["activateNonce"]) ? $context["activateNonce"] : $this->getContext($context, "activateNonce"));
                // line 287
                echo "                        ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_Disabled")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_DisabledMoreInfo")), "html", null, true);
                echo "
                    ";
            }
            // line 289
            echo "                </p>
\t\t\t<span style=\"margin-left:20px;\">
\t\t\t<a href='";
            // line 291
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('urlRewriteWithParameters')->getCallable(), array(array("module" => "PrivacyManager", "nonce" => (isset($context["nonce"]) ? $context["nonce"] : $this->getContext($context, "nonce")), "action" => (isset($context["action"]) ? $context["action"] : $this->getContext($context, "action"))))), "html", null, true);
            echo "#DNT'>&rsaquo;
                ";
            // line 292
            if ((isset($context["dntSupport"]) ? $context["dntSupport"] : $this->getContext($context, "dntSupport"))) {
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_Disable")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_NotRecommended")), "html", null, true);
                echo "
                ";
            } else {
                // line 293
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_Enable")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Recommended")), "html", null, true);
            }
            // line 294
            echo "                <br/>
            </a></span>
            </td>
            <td width=\"200\">
                ";
            // line 298
            echo $context["piwik"]->getinlineHelp(call_user_func_array($this->env->getFilter('translate')->getCallable(), array("PrivacyManager_DoNotTrack_Description")));
            echo "
            </td>
        </tr>
    </table>
";
        }
        // line 303
        echo "
<h2 id=\"optOutAnchor\">";
        // line 304
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_OptOutForYourVisitors")), "html", null, true);
        echo "</h2>
<p>";
        // line 305
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_OptOutExplanation")), "html", null, true);
        echo "
    ";
        // line 306
        ob_start();
        echo twig_escape_filter($this->env, (isset($context["piwikUrl"]) ? $context["piwikUrl"] : $this->getContext($context, "piwikUrl")), "html", null, true);
        echo "index.php?module=CoreAdminHome&action=optOut&language=";
        echo twig_escape_filter($this->env, (isset($context["language"]) ? $context["language"] : $this->getContext($context, "language")), "html", null, true);
        $context["optOutUrl"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 307
        echo "    ";
        ob_start();
        echo "<iframe style=\"border: 0; height: 200px; width: 600px;\" src=\"";
        echo twig_escape_filter($this->env, (isset($context["optOutUrl"]) ? $context["optOutUrl"] : $this->getContext($context, "optOutUrl")), "html", null, true);
        echo "\"></iframe>";
        $context["iframeOptOut"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 308
        echo "    <code>";
        echo twig_escape_filter($this->env, (isset($context["iframeOptOut"]) ? $context["iframeOptOut"] : $this->getContext($context, "iframeOptOut")), "html");
        echo "</code>
    <br/>
    ";
        // line 310
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_OptOutExplanationBis", (("<a href='" . (isset($context["optOutUrl"]) ? $context["optOutUrl"] : $this->getContext($context, "optOutUrl"))) . "' rel='noreferrer' target='_blank'>"), "</a>"));
        echo "
</p>

<div style=\"height:100px;\"></div>
";
    }

    public function getTemplateName()
    {
        return "@PrivacyManager/privacySettings.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  841 => 310,  835 => 308,  828 => 307,  822 => 306,  818 => 305,  814 => 304,  811 => 303,  803 => 298,  797 => 294,  792 => 293,  784 => 292,  780 => 291,  776 => 289,  768 => 287,  765 => 286,  762 => 285,  757 => 283,  751 => 281,  748 => 280,  745 => 279,  743 => 278,  735 => 273,  732 => 272,  725 => 268,  717 => 264,  712 => 262,  708 => 261,  703 => 259,  697 => 256,  692 => 255,  685 => 251,  678 => 250,  676 => 249,  668 => 245,  664 => 244,  659 => 243,  655 => 242,  650 => 241,  646 => 240,  641 => 238,  636 => 236,  631 => 233,  625 => 231,  619 => 229,  616 => 228,  614 => 227,  608 => 224,  601 => 220,  595 => 219,  585 => 212,  579 => 211,  573 => 208,  567 => 207,  562 => 205,  558 => 204,  552 => 203,  547 => 201,  543 => 200,  537 => 199,  532 => 197,  526 => 196,  521 => 194,  515 => 193,  510 => 191,  505 => 189,  501 => 188,  495 => 187,  490 => 185,  485 => 183,  480 => 181,  476 => 180,  467 => 174,  460 => 170,  457 => 169,  452 => 167,  448 => 166,  442 => 164,  437 => 163,  435 => 162,  430 => 160,  424 => 159,  420 => 158,  414 => 157,  408 => 154,  398 => 147,  394 => 146,  389 => 144,  385 => 143,  375 => 137,  372 => 136,  367 => 134,  363 => 132,  361 => 131,  356 => 130,  354 => 129,  346 => 125,  340 => 122,  334 => 120,  332 => 119,  327 => 117,  322 => 116,  320 => 115,  315 => 113,  310 => 112,  308 => 111,  301 => 107,  295 => 104,  289 => 103,  285 => 102,  280 => 100,  276 => 99,  272 => 98,  266 => 95,  262 => 94,  256 => 91,  252 => 90,  248 => 89,  243 => 87,  238 => 85,  235 => 84,  233 => 83,  227 => 80,  218 => 78,  208 => 71,  201 => 67,  195 => 66,  189 => 63,  184 => 61,  178 => 60,  172 => 57,  163 => 51,  156 => 47,  151 => 46,  149 => 45,  145 => 44,  141 => 43,  136 => 42,  134 => 41,  130 => 40,  125 => 39,  123 => 38,  118 => 36,  106 => 27,  99 => 23,  95 => 22,  89 => 21,  85 => 20,  79 => 19,  73 => 16,  69 => 15,  62 => 11,  58 => 10,  54 => 9,  50 => 8,  46 => 7,  43 => 6,  41 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
