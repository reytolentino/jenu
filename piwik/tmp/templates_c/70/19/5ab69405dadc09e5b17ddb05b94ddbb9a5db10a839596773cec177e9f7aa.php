<?php

/* @CoreAdminHome/trackingCodeGenerator.twig */
class __TwigTemplate_70195ab69405dadc09e5b17ddb05b94ddbb9a5db10a839596773cec177e9f7aa extends Twig_Template
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
            'head' => array($this, 'block_head'),
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
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" href=\"plugins/CoreAdminHome/stylesheets/jsTrackingGenerator.css\" />
    <script type=\"text/javascript\" src=\"plugins/CoreAdminHome/javascripts/jsTrackingGenerator.js\"></script>
";
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "<div id=\"js-tracking-generator-data\" max-custom-variables=\"";
        echo twig_escape_filter($this->env, (isset($context["maxCustomVariables"]) ? $context["maxCustomVariables"] : $this->getContext($context, "maxCustomVariables")), "html_attr");
        echo "\" data-currencies=\"";
        echo twig_escape_filter($this->env, twig_jsonencode_filter((isset($context["currencySymbols"]) ? $context["currencySymbols"] : $this->getContext($context, "currencySymbols"))), "html", null, true);
        echo "\"></div>

<h2 piwik-enriched-headline
    feature-name=\"";
        // line 13
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_TrackingCode")), "html", null, true);
        echo "\"
    help-url=\"http://piwik.org/docs/tracking-api/\">";
        // line 14
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JavaScriptTracking")), "html", null, true);
        echo "</h2>

<div id=\"js-code-options\">

    <p>
        ";
        // line 19
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro1")), "html", null, true);
        echo "
        <br/><br/>
        ";
        // line 21
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro2")), "html", null, true);
        echo " ";
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro3", "<a href=\"http://piwik.org/integrate/\" rel=\"noreferrer\"  target=\"_blank\">", "</a>"));
        echo "
        <br/><br/>
        ";
        // line 23
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro4", "<a href=\"#image-tracking-link\">", "</a>"));
        echo "
        <br/><br/>
        ";
        // line 25
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro5", "<a rel=\"noreferrer\"  target=\"_blank\" href=\"http://piwik.org/docs/javascript-tracking/\">", "</a>"));
        echo "
    </p>

    <div>
        ";
        // line 30
        echo "        <label class=\"website-label\"><strong>";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Website")), "html", null, true);
        echo "</strong></label>

        <div piwik-siteselector
             class=\"sites_autocomplete\"
             siteid=\"";
        // line 34
        echo twig_escape_filter($this->env, (isset($context["idSite"]) ? $context["idSite"] : $this->getContext($context, "idSite")), "html", null, true);
        echo "\"
             sitename=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["defaultReportSiteName"]) ? $context["defaultReportSiteName"] : $this->getContext($context, "defaultReportSiteName")), "html", null, true);
        echo "\"
             show-all-sites-item=\"false\"
             switch-site-on-select=\"false\"
             id=\"js-tracker-website\"
             show-selected-site=\"true\"></div>

        <br/><br/><br/>
    </div>

    <table id=\"optional-js-tracking-options\" class=\"adminTable\">
        <tr>
            <th>";
        // line 46
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Options")), "html", null, true);
        echo "</th>
            <th>";
        // line 47
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Mobile_Advanced")), "html", null, true);
        echo "
                <a href=\"#\" class=\"section-toggler-link\" data-section-id=\"javascript-advanced-options\">(";
        // line 48
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Show")), "html", null, true);
        echo ")</a>
            </th>
        </tr>
        <tr>
            <td>
                ";
        // line 54
        echo "                <div class=\"tracking-option-section\">
                    <input type=\"checkbox\" id=\"javascript-tracking-all-subdomains\"/>
                    <label for=\"javascript-tracking-all-subdomains\">";
        // line 56
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeSubdomains")), "html", null, true);
        echo "
                        <span class='current-site-name'>";
        // line 57
        echo (isset($context["defaultReportSiteName"]) ? $context["defaultReportSiteName"] : $this->getContext($context, "defaultReportSiteName"));
        echo "</span>
                    </label>

                    <div class=\"small-form-description\">
                        ";
        // line 61
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeSubdomainsDesc", (("x.<span class='current-site-host'>" . (isset($context["defaultReportSiteDomain"]) ? $context["defaultReportSiteDomain"] : $this->getContext($context, "defaultReportSiteDomain"))) . "</span>"), (("y.<span class='current-site-host'>" . (isset($context["defaultReportSiteDomain"]) ? $context["defaultReportSiteDomain"] : $this->getContext($context, "defaultReportSiteDomain"))) . "</span>")));
        echo "
                    </div>
                </div>

                ";
        // line 66
        echo "                <div class=\"tracking-option-section\">
                    <input type=\"checkbox\" id=\"javascript-tracking-group-by-domain\"/>
                    <label for=\"javascript-tracking-group-by-domain\">";
        // line 68
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_GroupPageTitlesByDomain")), "html", null, true);
        echo "</label>

                    <div class=\"small-form-description\">
                        ";
        // line 71
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_GroupPageTitlesByDomainDesc1", (("<span class='current-site-host'>" . (isset($context["defaultReportSiteDomain"]) ? $context["defaultReportSiteDomain"] : $this->getContext($context, "defaultReportSiteDomain"))) . "</span>")));
        echo "
                    </div>
                </div>

                ";
        // line 76
        echo "                <div class=\"tracking-option-section\">
                    <input type=\"checkbox\" id=\"javascript-tracking-all-aliases\"/>
                    <label for=\"javascript-tracking-all-aliases\">";
        // line 78
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeAliases")), "html", null, true);
        echo "
                        <span class='current-site-name'>";
        // line 79
        echo (isset($context["defaultReportSiteName"]) ? $context["defaultReportSiteName"] : $this->getContext($context, "defaultReportSiteName"));
        echo "</span>
                    </label>

                    <div class=\"small-form-description\">
                        ";
        // line 83
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeAliasesDesc", (("<span class='current-site-alias'>" . (isset($context["defaultReportSiteAlias"]) ? $context["defaultReportSiteAlias"] : $this->getContext($context, "defaultReportSiteAlias"))) . "</span>")));
        echo "
                    </div>
                </div>

            </td>
            <td>
                <div id=\"javascript-advanced-options\" style=\"display:none;\">
                    ";
        // line 91
        echo "                    <div class=\"custom-variable tracking-option-section\" id=\"javascript-tracking-visitor-cv\">
                        <input class=\"section-toggler-link\" type=\"checkbox\" id=\"javascript-tracking-visitor-cv-check\" data-section-id=\"js-visitor-cv-extra\"/>
                        <label for=\"javascript-tracking-visitor-cv-check\">";
        // line 93
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_VisitorCustomVars")), "html", null, true);
        echo "</label>

                        <div class=\"small-form-description\">
                            ";
        // line 96
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_VisitorCustomVarsDesc")), "html", null, true);
        echo "
                        </div>

                        <table style=\"display:none;\" id=\"js-visitor-cv-extra\">
                            <tr>
                                <td><strong>";
        // line 101
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Name")), "html", null, true);
        echo "</strong></td>
                                <td><input type=\"textbox\" class=\"custom-variable-name\" placeholder=\"e.g. Type\"/></td>
                                <td><strong>";
        // line 103
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Value")), "html", null, true);
        echo "</strong></td>
                                <td><input type=\"textbox\" class=\"custom-variable-value\" placeholder=\"e.g. Customer\"/></td>
                            </tr>
                            <tr>
                                <td colspan=\"4\" style=\"text-align:right;\">
                                    <a href=\"#\" class=\"add-custom-variable\">";
        // line 108
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Add")), "html", null, true);
        echo "</a>
                                </td>
                            </tr>
                        </table>
                    </div>

                    ";
        // line 115
        echo "                    <div class=\"custom-variable tracking-option-section\" id=\"javascript-tracking-page-cv\">
                        <input class=\"section-toggler-link\" type=\"checkbox\" id=\"javascript-tracking-page-cv-check\" data-section-id=\"js-page-cv-extra\"/>
                        <label for=\"javascript-tracking-page-cv-check\">";
        // line 117
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_PageCustomVars")), "html", null, true);
        echo "</label>

                        <div class=\"small-form-description\">
                            ";
        // line 120
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_PageCustomVarsDesc")), "html", null, true);
        echo "
                        </div>

                        <table style=\"display:none;\" id=\"js-page-cv-extra\">
                            <tr>
                                <td><strong>";
        // line 125
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Name")), "html", null, true);
        echo "</strong></td>
                                <td><input type=\"textbox\" class=\"custom-variable-name\" placeholder=\"e.g. Category\"/></td>
                                <td><strong>";
        // line 127
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Value")), "html", null, true);
        echo "</strong></td>
                                <td><input type=\"textbox\" class=\"custom-variable-value\" placeholder=\"e.g. White Papers\"/></td>
                            </tr>
                            <tr>
                                <td colspan=\"4\" style=\"text-align:right;\">
                                    <a href=\"#\" class=\"add-custom-variable\">";
        // line 132
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Add")), "html", null, true);
        echo "</a>
                                </td>
                            </tr>
                        </table>
                    </div>

                    ";
        // line 139
        echo "                    <div class=\"tracking-option-section\">
                        <input type=\"checkbox\" id=\"javascript-tracking-do-not-track\"/>
                        <label for=\"javascript-tracking-do-not-track\">";
        // line 141
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_EnableDoNotTrack")), "html", null, true);
        echo "</label>

                        <div class=\"small-form-description\">
                            ";
        // line 144
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_EnableDoNotTrackDesc")), "html", null, true);
        echo "
                            ";
        // line 145
        if ((isset($context["serverSideDoNotTrackEnabled"]) ? $context["serverSideDoNotTrackEnabled"] : $this->getContext($context, "serverSideDoNotTrackEnabled"))) {
            // line 146
            echo "                                <br/>
                                <br/>
                                ";
            // line 148
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_EnableDoNotTrack_AlreadyEnabled")), "html", null, true);
            echo "
                            ";
        }
        // line 150
        echo "                        </div>
                    </div>

                    ";
        // line 154
        echo "                    <div class=\"tracking-option-section\">
                        <input type=\"checkbox\" id=\"javascript-tracking-disable-cookies\"/>
                        <label for=\"javascript-tracking-disable-cookies\">";
        // line 156
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_DisableCookies")), "html", null, true);
        echo "</label>

                        <div class=\"small-form-description\">
                            ";
        // line 159
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_DisableCookiesDesc")), "html", null, true);
        echo "
                        </div>
                    </div>

                    ";
        // line 164
        echo "                    <div class=\"tracking-option-section\">
                        <input class=\"section-toggler-link\" type=\"checkbox\" id=\"custom-campaign-query-params-check\"
                               data-section-id=\"js-campaign-query-param-extra\"/>
                        <label for=\"custom-campaign-query-params-check\">";
        // line 167
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CustomCampaignQueryParam")), "html", null, true);
        echo "</label>

                        <div class=\"small-form-description\">
                            ";
        // line 170
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CustomCampaignQueryParamDesc", "<a href=\"http://piwik.org/faq/general/#faq_119\" rel=\"noreferrer\"  target=\"_blank\">", "</a>"));
        echo "
                        </div>

                        <table style=\"display:none;\" id=\"js-campaign-query-param-extra\">
                            <tr>
                                <td><strong>";
        // line 175
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CampaignNameParam")), "html", null, true);
        echo "</strong></td>
                                <td><input type=\"text\" id=\"custom-campaign-name-query-param\"/></td>
                            </tr>
                            <tr>
                                <td><strong>";
        // line 179
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CampaignKwdParam")), "html", null, true);
        echo "</strong></td>
                                <td><input type=\"text\" id=\"custom-campaign-keyword-query-param\"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</div>

<div id=\"javascript-output-section\">
    <h3>";
        // line 192
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_JsTrackingTag")), "html", null, true);
        echo "</h3>

    <p class=\"form-description\">";
        // line 194
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CodeNote", "&lt;/body&gt;"));
        echo "</p>

    <div id=\"javascript-text\">
        <textarea> </textarea>
    </div>
    <br/>
</div>

<h2 id=\"image-tracking-link\">";
        // line 202
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTracking")), "html", null, true);
        echo "</h2>

<div id=\"image-tracking-code-options\">

    <p>
        ";
        // line 207
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingIntro1")), "html", null, true);
        echo " ";
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingIntro2", "<em>&lt;noscript&gt;&lt;/noscript&gt;</em>"));
        echo "
        <br/><br/>
        ";
        // line 209
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingIntro3", "<a href=\"http://piwik.org/docs/tracking-api/reference/\" rel=\"noreferrer\"  target=\"_blank\">", "</a>"));
        echo "
    </p>

    <div>
        ";
        // line 214
        echo "        <label class=\"website-label\"><strong>";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Website")), "html", null, true);
        echo "</strong></label>
        <div piwik-siteselector
             class=\"sites_autocomplete\"
             siteid=\"";
        // line 217
        echo twig_escape_filter($this->env, (isset($context["idSite"]) ? $context["idSite"] : $this->getContext($context, "idSite")), "html", null, true);
        echo "\"
             sitename=\"";
        // line 218
        echo twig_escape_filter($this->env, (isset($context["defaultReportSiteName"]) ? $context["defaultReportSiteName"] : $this->getContext($context, "defaultReportSiteName")), "html", null, true);
        echo "\"
             id=\"image-tracker-website\"
             show-all-sites-item=\"false\"
             switch-site-on-select=\"false\"
             show-selected-site=\"true\"></div>

        <br/><br/><br/>
    </div>

    <table id=\"image-tracking-section\" class=\"adminTable\">
        <tr>
            <th>";
        // line 229
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Options")), "html", null, true);
        echo "</th>
            <th>";
        // line 230
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Mobile_Advanced")), "html", null, true);
        echo "
                <a href=\"#\" class=\"section-toggler-link\" data-section-id=\"image-tracker-advanced-options\">
                    (";
        // line 232
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Show")), "html", null, true);
        echo ")
                </a>
            </th>
        </tr>
        <tr>
            <td>
                ";
        // line 239
        echo "                <div class=\"tracking-option-section\">
                    <label for=\"image-tracker-action-name\">";
        // line 240
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Actions_ColumnPageName")), "html", null, true);
        echo "</label>
                    <input type=\"text\" id=\"image-tracker-action-name\"/>
                </div>
            </td>
            <td>
                <div id=\"image-tracker-advanced-options\" style=\"display:none;\">
                    ";
        // line 247
        echo "                    <div class=\"goal-picker tracking-option-section\">
                        <input class=\"section-toggler-link\" type=\"checkbox\" id=\"image-tracking-goal-check\" data-section-id=\"image-goal-picker-extra\"/>
                        <label for=\"image-tracking-goal-check\">";
        // line 249
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_TrackAGoal")), "html", null, true);
        echo "</label>

                        <div style=\"display:none;\" id=\"image-goal-picker-extra\">
                            <select id=\"image-tracker-goal\">
                                <option value=\"\">";
        // line 253
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountryMap_None")), "html", null, true);
        echo "</option>
                            </select>
                            <span>";
        // line 255
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_WithOptionalRevenue")), "html", null, true);
        echo "</span>
                            <span class=\"currency\">";
        // line 256
        echo twig_escape_filter($this->env, (isset($context["defaultSiteRevenue"]) ? $context["defaultSiteRevenue"] : $this->getContext($context, "defaultSiteRevenue")), "html", null, true);
        echo "</span>
                            <input type=\"text\" class=\"revenue\" value=\"\"/>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div id=\"image-link-output-section\" width=\"560px\">
        <h3>";
        // line 266
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingLink")), "html", null, true);
        echo "</h3><br/><br/>

        <div id=\"image-tracking-text\">
            <textarea> </textarea>
        </div>
        <br/>
    </div>

</div>

<h2>";
        // line 276
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImportingServerLogs")), "html", null, true);
        echo "</h2>

<p>
    ";
        // line 279
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImportingServerLogsDesc", "<a href=\"http://piwik.org/log-analytics/\" rel=\"noreferrer\"  target=\"_blank\">", "</a>"));
        echo "
</p>

";
    }

    public function getTemplateName()
    {
        return "@CoreAdminHome/trackingCodeGenerator.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  517 => 279,  511 => 276,  498 => 266,  485 => 256,  481 => 255,  476 => 253,  469 => 249,  465 => 247,  456 => 240,  453 => 239,  444 => 232,  439 => 230,  435 => 229,  421 => 218,  417 => 217,  410 => 214,  403 => 209,  396 => 207,  388 => 202,  377 => 194,  372 => 192,  356 => 179,  349 => 175,  341 => 170,  335 => 167,  330 => 164,  323 => 159,  317 => 156,  313 => 154,  308 => 150,  303 => 148,  299 => 146,  297 => 145,  293 => 144,  287 => 141,  283 => 139,  274 => 132,  266 => 127,  261 => 125,  253 => 120,  247 => 117,  243 => 115,  234 => 108,  226 => 103,  221 => 101,  213 => 96,  207 => 93,  203 => 91,  193 => 83,  186 => 79,  182 => 78,  178 => 76,  171 => 71,  165 => 68,  161 => 66,  154 => 61,  147 => 57,  143 => 56,  139 => 54,  131 => 48,  127 => 47,  123 => 46,  109 => 35,  105 => 34,  97 => 30,  90 => 25,  85 => 23,  78 => 21,  73 => 19,  65 => 14,  61 => 13,  52 => 10,  49 => 9,  40 => 4,  37 => 3,  11 => 1,);
    }
}
