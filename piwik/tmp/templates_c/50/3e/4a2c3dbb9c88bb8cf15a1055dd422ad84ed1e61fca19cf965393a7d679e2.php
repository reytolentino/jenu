<?php

/* @UserCountry/adminIndex.twig */
class __TwigTemplate_503e4a2c3dbb9c88bb8cf15a1055dd422ad84ed1e61fca19cf965393a7d679e2 extends Twig_Template
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
        echo "
<h2 piwik-enriched-headline
    help-url=\"http://piwik.org/docs/geo-locate/\"
    id=\"location-providers\">";
        // line 8
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_Geolocation")), "html", null, true);
        echo "</h2>

<div style=\"width:900px;\">

    <p>";
        // line 12
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_GeolocationPageDesc")), "html", null, true);
        echo "</p>

    ";
        // line 14
        if ( !(isset($context["isThereWorkingProvider"]) ? $context["isThereWorkingProvider"] : $this->getContext($context, "isThereWorkingProvider"))) {
            // line 15
            echo "        <h3 style=\"margin-top:0;\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_HowToSetupGeoIP")), "html", null, true);
            echo "</h3>
        <p>";
            // line 16
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_HowToSetupGeoIPIntro")), "html", null, true);
            echo "</p>
        <ul style=\"list-style:disc;margin-left:2em;\">
            <li>";
            // line 18
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_HowToSetupGeoIP_Step1", "<a href=\"http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz\">", "</a>", "<a rel=\"noreferrer\"  target=\"_blank\" href=\"http://www.maxmind.com/?rId=piwik\">", "</a>"));
            echo "</li>
            <li>";
            // line 19
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_HowToSetupGeoIP_Step2", "'GeoLiteCity.dat'", "<strong>", "</strong>"));
            echo "</li>
            <li>";
            // line 20
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_HowToSetupGeoIP_Step3", "<strong>", "</strong>", "<span style=\"color:green\"><strong>", "</strong></span>"));
            echo "</li>
            <li>";
            // line 21
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_HowToSetupGeoIP_Step4")), "html", null, true);
            echo "</li>
        </ul>
        <p>&nbsp;</p>
    ";
        }
        // line 25
        echo "
    <table class=\"adminTable locationProviderTable\">
        <tr>
            <th>";
        // line 28
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_LocationProvider")), "html", null, true);
        echo "</th>
            <th>";
        // line 29
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Description")), "html", null, true);
        echo "</th>
            <th>";
        // line 30
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_InfoFor", (isset($context["thisIP"]) ? $context["thisIP"] : $this->getContext($context, "thisIP")))), "html", null, true);
        echo "</th>
        </tr>
        ";
        // line 32
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["locationProviders"]) ? $context["locationProviders"] : $this->getContext($context, "locationProviders")));
        foreach ($context['_seq'] as $context["id"] => $context["provider"]) {
            // line 33
            echo "        <tr>
            <td width=\"150\">
                <p>
                    <input class=\"location-provider\" name=\"location-provider\" value=\"";
            // line 36
            echo twig_escape_filter($this->env, $context["id"], "html", null, true);
            echo "\" type=\"radio\" ";
            if (((isset($context["currentProviderId"]) ? $context["currentProviderId"] : $this->getContext($context, "currentProviderId")) == $context["id"])) {
                echo "checked=\"checked\"";
            }
            // line 37
            echo "                           id=\"provider_input_";
            echo twig_escape_filter($this->env, $context["id"], "html", null, true);
            echo "\" ";
            if (($this->getAttribute($context["provider"], "status", array()) != 1)) {
                echo "disabled=\"disabled\"";
            }
            echo "/>
                    <label for=\"provider_input_";
            // line 38
            echo twig_escape_filter($this->env, $context["id"], "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($this->getAttribute($context["provider"], "title", array()))), "html", null, true);
            echo "</label><br/>
                    <span class=\"loadingPiwik\" style=\"display:none;\"><img src=\"./plugins/Morpheus/images/loading-blue.gif\"/></span>
                    <span class=\"success\" ></span>
                </p>

                <p class=\"loc-provider-status\">
                    <strong><em>
                            ";
            // line 45
            if (($this->getAttribute($context["provider"], "status", array()) == 0)) {
                // line 46
                echo "                                <span class=\"is-not-installed\">";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_NotInstalled")), "html", null, true);
                echo "</span>
                            ";
            } elseif (($this->getAttribute(            // line 47
$context["provider"], "status", array()) == 1)) {
                // line 48
                echo "                                <span class=\"is-installed\">";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Installed")), "html", null, true);
                echo "</span>
                            ";
            } elseif (($this->getAttribute(            // line 49
$context["provider"], "status", array()) == 2)) {
                // line 50
                echo "                                <span class=\"is-broken\">";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Broken")), "html", null, true);
                echo "</span>
                            ";
            }
            // line 52
            echo "                        </em></strong>
                </p>
            </td>
            <td>
                <p>";
            // line 56
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array($this->getAttribute($context["provider"], "description", array())));
            echo "</p>
                ";
            // line 57
            if ((($this->getAttribute($context["provider"], "status", array()) != 1) && $this->getAttribute($context["provider"], "install_docs", array(), "any", true, true))) {
                // line 58
                echo "                    <p>";
                echo $this->getAttribute($context["provider"], "install_docs", array());
                echo "</p>
                ";
            }
            // line 60
            echo "            </td>
            <td width=\"164\">
                ";
            // line 62
            if (($this->getAttribute($context["provider"], "status", array()) == 1)) {
                // line 63
                echo "                    ";
                ob_start();
                // line 64
                echo "                        ";
                if (((isset($context["thisIP"]) ? $context["thisIP"] : $this->getContext($context, "thisIP")) != "127.0.0.1")) {
                    // line 65
                    echo "                            ";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_CurrentLocationIntro")), "html", null, true);
                    echo ":
                            <div style=\"text-align:left;\">
                                <br/>
                                <span class=\"loadingPiwik\" style=\"display:none;position:absolute;\">
                                    <img src=\"./plugins/Morpheus/images/loading-blue.gif\"/> ";
                    // line 69
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Loading")), "html", null, true);
                    echo "</span>
                                <span class=\"location\"><strong><em>";
                    // line 70
                    echo $this->getAttribute($context["provider"], "location", array());
                    echo "</em></strong></span>
                            </div>
                            <div style=\"text-align:right;\">
                                <a href=\"#\" class=\"refresh-loc\" data-impl-id=\"";
                    // line 73
                    echo twig_escape_filter($this->env, $context["id"], "html", null, true);
                    echo "\"><em>";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Refresh")), "html", null, true);
                    echo "</em></a>
                            </div>
                        ";
                } else {
                    // line 76
                    echo "                            ";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_CannotLocalizeLocalIP", (isset($context["thisIP"]) ? $context["thisIP"] : $this->getContext($context, "thisIP")))), "html", null, true);
                    echo "
                        ";
                }
                // line 78
                echo "                    ";
                $context["currentLocation"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 79
                echo "                    ";
                echo $context["piwik"]->getinlineHelp((isset($context["currentLocation"]) ? $context["currentLocation"] : $this->getContext($context, "currentLocation")));
                echo "
                ";
            }
            // line 81
            echo "                ";
            if (($this->getAttribute($context["provider"], "statusMessage", array(), "any", true, true) && $this->getAttribute($context["provider"], "statusMessage", array()))) {
                // line 82
                echo "                    ";
                ob_start();
                // line 83
                echo "                        ";
                if (($this->getAttribute($context["provider"], "status", array()) == 2)) {
                    echo "<strong><em>";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Error")), "html", null, true);
                    echo ":</em></strong> ";
                }
                echo $this->getAttribute($context["provider"], "statusMessage", array());
                echo "
                    ";
                $context["brokenReason"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 85
                echo "                    ";
                echo $context["piwik"]->getinlineHelp((isset($context["brokenReason"]) ? $context["brokenReason"] : $this->getContext($context, "brokenReason")));
                echo "
                ";
            }
            // line 87
            echo "                ";
            if (($this->getAttribute($context["provider"], "extra_message", array(), "any", true, true) && $this->getAttribute($context["provider"], "extra_message", array()))) {
                // line 88
                echo "                    ";
                ob_start();
                // line 89
                echo "                        ";
                echo $this->getAttribute($context["provider"], "extra_message", array());
                echo "
                    ";
                $context["extraMessage"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 91
                echo "                    <br/>
                    ";
                // line 92
                echo $context["piwik"]->getinlineHelp((isset($context["extraMessage"]) ? $context["extraMessage"] : $this->getContext($context, "extraMessage")));
                echo "
                ";
            }
            // line 94
            echo "            </td>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['id'], $context['provider'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 96
        echo "    </table>

</div>

";
        // line 100
        if ( !(isset($context["geoIPDatabasesInstalled"]) ? $context["geoIPDatabasesInstalled"] : $this->getContext($context, "geoIPDatabasesInstalled"))) {
            // line 101
            echo "    <h2 id=\"geoip-db-mangement\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_GeoIPDatabases")), "html", null, true);
            echo "</h2>
";
        } else {
            // line 103
            echo "    <h2 id=\"geoip-db-mangement\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_SetupAutomaticUpdatesOfGeoIP")), "html", null, true);
            echo "</h2>
";
        }
        // line 105
        echo "
";
        // line 106
        if ((isset($context["showGeoIPUpdateSection"]) ? $context["showGeoIPUpdateSection"] : $this->getContext($context, "showGeoIPUpdateSection"))) {
            // line 107
            echo "    <div id=\"manage-geoip-dbs\" style=\"width:900px;\" class=\"adminTable\">

    ";
            // line 109
            if ( !(isset($context["geoIPDatabasesInstalled"]) ? $context["geoIPDatabasesInstalled"] : $this->getContext($context, "geoIPDatabasesInstalled"))) {
                // line 110
                echo "        <div id=\"geoipdb-screen1\">
            <p>";
                // line 111
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_PiwikNotManagingGeoIPDBs")), "html", null, true);
                echo "</p>

            <div class=\"geoipdb-column-1\">
                <p>";
                // line 114
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_IWantToDownloadFreeGeoIP"));
                echo "</p>
                <input type=\"button\" class=\"submit\" value=\"";
                // line 115
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_GetStarted")), "html", null, true);
                echo "...\" id=\"start-download-free-geoip\"/>
            </div>
            <div class=\"geoipdb-column-2\">
                <p>";
                // line 118
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_IPurchasedGeoIPDBs", "<a href=\"http://www.maxmind.com/en/geolocation_landing?rId=piwik\">", "</a>"));
                echo "</p>
                <input type=\"button\" class=\"submit\" value=\"";
                // line 119
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_GetStarted")), "html", null, true);
                echo "...\" id=\"start-automatic-update-geoip\"/>
            </div>
        </div>
        <div id=\"geoipdb-screen2-download\" style=\"display:none;\">
            <p class='loadingPiwik'><img src='./plugins/Morpheus/images/loading-blue.gif'/>
            ";
                // line 124
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_DownloadingDb", (("<a href=\"" . (isset($context["geoLiteUrl"]) ? $context["geoLiteUrl"] : $this->getContext($context, "geoLiteUrl"))) . "\">GeoLiteCity.dat</a>")));
                echo "...</p>
\t        <div id=\"geoip-download-progress\"></div>
        </div>
    ";
            }
            // line 128
            echo "    ";
            $this->env->loadTemplate("@UserCountry/_updaterManage.twig")->display($context);
        } else {
            // line 130
            echo "<p style=\"width:900px;\" class=\"form-description\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_CannotSetupGeoIPAutoUpdating")), "html", null, true);
            echo "</p>
";
        }
        // line 132
        echo "</div>

";
    }

    public function getTemplateName()
    {
        return "@UserCountry/adminIndex.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  365 => 132,  359 => 130,  355 => 128,  348 => 124,  340 => 119,  336 => 118,  330 => 115,  326 => 114,  320 => 111,  317 => 110,  315 => 109,  311 => 107,  309 => 106,  306 => 105,  300 => 103,  294 => 101,  292 => 100,  286 => 96,  279 => 94,  274 => 92,  271 => 91,  265 => 89,  262 => 88,  259 => 87,  253 => 85,  242 => 83,  239 => 82,  236 => 81,  230 => 79,  227 => 78,  221 => 76,  213 => 73,  207 => 70,  203 => 69,  195 => 65,  192 => 64,  189 => 63,  187 => 62,  183 => 60,  177 => 58,  175 => 57,  171 => 56,  165 => 52,  159 => 50,  157 => 49,  152 => 48,  150 => 47,  145 => 46,  143 => 45,  131 => 38,  122 => 37,  116 => 36,  111 => 33,  107 => 32,  102 => 30,  98 => 29,  94 => 28,  89 => 25,  82 => 21,  78 => 20,  74 => 19,  70 => 18,  65 => 16,  60 => 15,  58 => 14,  53 => 12,  46 => 8,  41 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
