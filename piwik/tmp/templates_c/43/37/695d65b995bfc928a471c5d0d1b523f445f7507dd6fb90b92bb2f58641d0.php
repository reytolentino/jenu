<?php

/* @Installation/_systemCheckSection.twig */
class __TwigTemplate_4337695d65b995bfc928a471c5d0d1b523f445f7507dd6fb90b92bb2f58641d0 extends Twig_Template
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
        // line 1
        $context["ok"] = ('' === $tmp = "<img src='plugins/Morpheus/images/ok.png' />") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 2
        $context["error"] = ('' === $tmp = "<img src='plugins/Morpheus/images/error.png' />") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 3
        $context["warning"] = ('' === $tmp = "<img src='plugins/Morpheus/images/warning.png' />") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 4
        $context["link"] = ('' === $tmp = "<img src='plugins/Morpheus/images/link.gif' />") ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 5
        echo "
<table class=\"infosServer\" id=\"systemCheckRequired\">
    <tr>
        ";
        // line 8
        ob_start();
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckPhp")), "html", null, true);
        echo " &gt;= ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "phpVersion_minimum", array()), "html", null, true);
        $context["MinPHP"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 9
        echo "        <td class=\"label\">";
        echo twig_escape_filter($this->env, (isset($context["MinPHP"]) ? $context["MinPHP"] : $this->getContext($context, "MinPHP")), "html", null, true);
        echo "</td>

        <td>
            ";
        // line 12
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "phpVersion_ok", array())) {
            // line 13
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "phpVersion", array()), "html", null, true);
            echo "
            ";
        } else {
            // line 15
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "html", null, true);
            echo " <span class=\"err\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Error")), "html", null, true);
            echo ": ";
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Required", (isset($context["MinPHP"]) ? $context["MinPHP"] : $this->getContext($context, "MinPHP"))));
            echo "</span>
            ";
        }
        // line 17
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">PDO ";
        // line 20
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_Extension")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 22
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "pdo_ok", array())) {
            // line 23
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
        } else {
            // line 25
            echo "                -
            ";
        }
        // line 27
        echo "        </td>
    </tr>
    ";
        // line 29
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "adapters", array()));
        foreach ($context['_seq'] as $context["adapter"] => $context["port"]) {
            // line 30
            echo "        <tr>
            <td class=\"label\">";
            // line 31
            echo twig_escape_filter($this->env, $context["adapter"], "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_Extension")), "html", null, true);
            echo "</td>
            <td>";
            // line 32
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo "</td>
        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['adapter'], $context['port'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "    ";
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "adapters", array())) == 0)) {
            // line 36
            echo "        <tr>
            <td colspan=\"2\" class=\"error\" style=\"font-size: small;\">
                ";
            // line 38
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckDatabaseHelp")), "html", null, true);
            echo "
                <p>
                    ";
            // line 40
            if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "isWindows", array())) {
                // line 41
                echo "                        ";
                echo nl2br(call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckWinPdoAndMysqliHelp", "<br /><br /><code>extension=php_mysqli.dll</code><br /><code>extension=php_pdo.dll</code><br /><code>extension=php_pdo_mysql.dll</code><br />")));
                echo "
                    ";
            } else {
                // line 43
                echo "                        ";
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckPdoAndMysqliHelp", "<br /><br /><code>--with-mysqli</code><br /><code>--with-pdo-mysql</code><br /><br />", "<br /><br /><code>extension=mysqli.so</code><br /><code>extension=pdo.so</code><br /><code>extension=pdo_mysql.so</code><br />"));
                echo "
                    ";
            }
            // line 45
            echo "                    ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_RestartWebServer")), "html", null, true);
            echo "
                    <br/>
                    <br/>
                    ";
            // line 48
            echo nl2br(call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckPhpPdoAndMysqli", "<a style=\"color:red\" href=\"http://php.net/pdo\">", "</a>", "<a style=\"color:red\" href=\"http://php.net/mysqli\">", "</a>")));
            echo "
                </p>
            </td>
        </tr>
    ";
        }
        // line 53
        echo "    <tr>
        <td class=\"label\">";
        // line 54
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckExtensions")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 56
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "needed_extensions", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["needed_extension"]) {
            // line 57
            echo "                ";
            if (twig_in_filter($context["needed_extension"], $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "missing_extensions", array()))) {
                // line 58
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "html", null, true);
                echo "
                    <br/>";
                // line 59
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_RestartWebServer")), "html", null, true);
                echo "
                ";
            } else {
                // line 61
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo "
                ";
            }
            // line 63
            echo "                ";
            echo twig_escape_filter($this->env, $context["needed_extension"], "html", null, true);
            echo "
                <br/>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['needed_extension'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 66
        echo "        </td>
    </tr>
    ";
        // line 68
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "missing_extensions", array())) > 0)) {
            // line 69
            echo "        <tr>
            <td colspan=\"2\" class=\"error\" style=\"font-size: small;\">
                ";
            // line 71
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "missing_extensions", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["missing_extension"]) {
                // line 72
                echo "                    <p>
                        <em>";
                // line 73
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($this->getAttribute((isset($context["helpMessages"]) ? $context["helpMessages"] : $this->getContext($context, "helpMessages")), $context["missing_extension"], array(), "array"))), "html", null, true);
                echo "</em>
                    </p>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['missing_extension'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 76
            echo "            </td>
        </tr>
    ";
        }
        // line 79
        echo "    <tr>
        <td class=\"label\">";
        // line 80
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckFunctions")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 82
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "needed_functions", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["needed_function"]) {
            // line 83
            echo "                ";
            if (twig_in_filter($context["needed_function"], $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "missing_functions", array()))) {
                // line 84
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "html", null, true);
                echo "
                    <span class='err'>";
                // line 85
                echo twig_escape_filter($this->env, $context["needed_function"], "html", null, true);
                echo "</span>
                    <p>
                        <em>
                            ";
                // line 88
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($this->getAttribute((isset($context["helpMessages"]) ? $context["helpMessages"] : $this->getContext($context, "helpMessages")), $context["needed_function"], array(), "array"))), "html", null, true);
                echo "
                            <br/>";
                // line 89
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_RestartWebServer")), "html", null, true);
                echo "
                        </em>
                    </p>
                ";
            } else {
                // line 93
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $context["needed_function"], "html", null, true);
                echo "
                    <br/>
                ";
            }
            // line 96
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['needed_function'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 97
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 100
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckSettings")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 102
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "needed_settings", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["needed_setting"]) {
            // line 103
            echo "                ";
            if (twig_in_filter($context["needed_setting"], $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "missing_settings", array()))) {
                // line 104
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "html", null, true);
                echo "
                    <span class='err'>";
                // line 105
                echo twig_escape_filter($this->env, $context["needed_setting"], "html", null, true);
                echo "</span>
                    <p>
                        <em>
                            ";
                // line 108
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($this->getAttribute((isset($context["helpMessages"]) ? $context["helpMessages"] : $this->getContext($context, "helpMessages")), $context["needed_setting"], array(), "array"))), "html", null, true);
                echo "
                            <br/>";
                // line 109
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_RestartWebServer")), "html", null, true);
                echo "
                        </em>
                    </p>
                ";
            } else {
                // line 113
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $context["needed_setting"], "html", null, true);
                echo "
                    <br/>
                ";
            }
            // line 116
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['needed_setting'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 117
        echo "        </td>
    </tr>
    <tr>
        <td valign=\"top\">
            ";
        // line 121
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckWriteDirs")), "html", null, true);
        echo "
        </td>
        <td style=\"font-size: small;\">
            ";
        // line 124
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "directories", array()));
        foreach ($context['_seq'] as $context["dir"] => $context["bool"]) {
            // line 125
            echo "                ";
            if ($context["bool"]) {
                // line 126
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo "
                ";
            } else {
                // line 128
                echo "                    <span style=\"color:red;\">";
                echo twig_escape_filter($this->env, (isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "html", null, true);
                echo "</span>
                ";
            }
            // line 130
            echo "                ";
            echo twig_escape_filter($this->env, $context["dir"], "html", null, true);
            echo "
                <br/>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['dir'], $context['bool'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 133
        echo "        </td>
    </tr>
    ";
        // line 135
        if ((isset($context["problemWithSomeDirectories"]) ? $context["problemWithSomeDirectories"] : $this->getContext($context, "problemWithSomeDirectories"))) {
            // line 136
            echo "        <tr>
            <td colspan=\"2\" class=\"error\">
                ";
            // line 138
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckWriteDirsHelp")), "html", null, true);
            echo ":
                ";
            // line 139
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "directories", array()));
            foreach ($context['_seq'] as $context["dir"] => $context["bool"]) {
                // line 140
                echo "                    <ul>
                        ";
                // line 141
                if ( !$context["bool"]) {
                    // line 142
                    echo "                            <li>
                                <pre>chmod a+w ";
                    // line 143
                    echo twig_escape_filter($this->env, $context["dir"], "html", null, true);
                    echo "</pre>
                            </li>
                        ";
                }
                // line 146
                echo "                    </ul>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['dir'], $context['bool'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 148
            echo "            </td>
        </tr>
    ";
        }
        // line 151
        echo "</table>
<br/>

<h3>";
        // line 154
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_Optional")), "html", null, true);
        echo "</h3>
<table class=\"infos\" id=\"systemCheckOptional\">
    <tr>
        <td class=\"label\">";
        // line 157
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckFileIntegrity")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 159
        if (twig_test_empty($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "integrityErrorMessages", array()))) {
            // line 160
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo "
            ";
        } else {
            // line 162
            echo "                ";
            if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "integrity", array())) {
                // line 163
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
                echo "
                    <em>";
                // line 164
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "integrityErrorMessages", array()), 0, array(), "array"), "html", null, true);
                echo "</em>
                ";
            } else {
                // line 166
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), "html", null, true);
                echo "
                    <em>";
                // line 167
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "integrityErrorMessages", array()), 0, array(), "array"), "html", null, true);
                echo "</em>
                ";
            }
            // line 169
            echo "                ";
            if ((twig_length_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "integrityErrorMessages", array())) > 1)) {
                // line 170
                echo "                    <button id=\"more-results\" class=\"ui-button ui-state-default ui-corner-all\">";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Details")), "html", null, true);
                echo "</button>
                ";
            }
            // line 172
            echo "            ";
        }
        // line 173
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 176
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckTracker")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 178
        if (($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "tracker_status", array()) == 0)) {
            // line 179
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo "
            ";
        } else {
            // line 181
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo "
                <span class=\"warn\">";
            // line 182
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "tracker_status", array()), "html", null, true);
            echo "
                    <br/>";
            // line 183
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckTrackerHelp")), "html", null, true);
            echo " </span>
                <br/>
                ";
            // line 185
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_RestartWebServer")), "html", null, true);
            echo "
            ";
        }
        // line 187
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 190
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckMemoryLimit")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 192
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "memory_ok", array())) {
            // line 193
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "memoryCurrent", array()), "html", null, true);
            echo "
            ";
        } else {
            // line 195
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo "
                <span class=\"warn\">";
            // line 196
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "memoryCurrent", array()), "html", null, true);
            echo "</span>
                <br/>
                ";
            // line 198
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckMemoryLimitHelp")), "html", null, true);
            echo "
                ";
            // line 199
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_RestartWebServer")), "html", null, true);
            echo "
            ";
        }
        // line 201
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 204
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_Timezone")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 206
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "timezone", array())) {
            // line 207
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo "
            ";
        } else {
            // line 209
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo "
                <span class=\"warn\">";
            // line 210
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_AdvancedTimezoneSupportNotFound")), "html", null, true);
            echo " </span>
                <br/>
                <a href=\"http://php.net/manual/en/datetime.installation.php\" rel=\"noreferrer\" target=\"_blank\">Timezone PHP documentation</a>
                .
            ";
        }
        // line 215
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 218
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckOpenURL")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 220
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "openurl", array())) {
            // line 221
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "openurl", array()), "html", null, true);
            echo "
            ";
        } else {
            // line 223
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo "
                <span class=\"warn\">";
            // line 224
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckOpenURLHelp")), "html", null, true);
            echo "</span>
            ";
        }
        // line 226
        echo "            ";
        if ( !$this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "can_auto_update", array())) {
            // line 227
            echo "                <br/>
                ";
            // line 228
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo " <span class=\"warn\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckAutoUpdateHelp")), "html", null, true);
            echo "</span>
            ";
        }
        // line 230
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 233
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckPageSpeedDisabled")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 235
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "pagespeed_module_disabled_ok", array())) {
            // line 236
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo "
            ";
        } else {
            // line 238
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo " <span class=\"warn\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckPageSpeedWarn", "(eg. Apache, Nginx or IIS)")), "html", null, true);
            echo "</span>
            ";
        }
        // line 240
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 243
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckGDFreeType")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 245
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "gd_ok", array())) {
            // line 246
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo "
            ";
        } else {
            // line 248
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo " <span class=\"warn\">";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckGDFreeType")), "html", null, true);
            echo "
                <br/>
                ";
            // line 250
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckGDHelp")), "html", null, true);
            echo " </span>
            ";
        }
        // line 252
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 255
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckOtherExtensions")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 257
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "desired_extensions", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["desired_extension"]) {
            // line 258
            echo "                ";
            if (twig_in_filter($context["desired_extension"], $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "missing_desired_extensions", array()))) {
                // line 259
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
                echo "<span class=\"warn\">";
                echo twig_escape_filter($this->env, $context["desired_extension"], "html", null, true);
                echo "</span>
                    <p>";
                // line 260
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($this->getAttribute((isset($context["helpMessages"]) ? $context["helpMessages"] : $this->getContext($context, "helpMessages")), $context["desired_extension"], array(), "array"))), "html", null, true);
                echo "</p>
                ";
            } else {
                // line 262
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $context["desired_extension"], "html", null, true);
                echo "
                    <br/>
                ";
            }
            // line 265
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['desired_extension'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 266
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 269
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckOtherFunctions")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 271
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "desired_functions", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["desired_function"]) {
            // line 272
            echo "                ";
            if (twig_in_filter($context["desired_function"], $this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "missing_desired_functions", array()))) {
                // line 273
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
                echo "
                    <span class=\"warn\">";
                // line 274
                echo twig_escape_filter($this->env, $context["desired_function"], "html", null, true);
                echo "</span>
                    <p>";
                // line 275
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($this->getAttribute((isset($context["helpMessages"]) ? $context["helpMessages"] : $this->getContext($context, "helpMessages")), $context["desired_function"], array(), "array"))), "html", null, true);
                echo "</p>
                ";
            } else {
                // line 277
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, $context["desired_function"], "html", null, true);
                echo "
                    <br/>
                ";
            }
            // line 280
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['desired_function'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 281
        echo "        </td>
    </tr>
    <tr>
        <td class=\"label\">";
        // line 284
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_Filesystem")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 286
        if ( !$this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "is_nfs", array())) {
            // line 287
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
            echo "
                <br/>
            ";
        } else {
            // line 290
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo "
                <span class=\"warn\">";
            // line 291
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_NfsFilesystemWarning")), "html", null, true);
            echo "</span>
                ";
            // line 292
            if ( !twig_test_empty((isset($context["duringInstall"]) ? $context["duringInstall"] : $this->getContext($context, "duringInstall")))) {
                // line 293
                echo "                    <p>";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_NfsFilesystemWarningSuffixInstall")), "html", null, true);
                echo "</p>
                ";
            } else {
                // line 295
                echo "                    <p>";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_NfsFilesystemWarningSuffixAdmin")), "html", null, true);
                echo "</p>
                ";
            }
            // line 297
            echo "            ";
        }
        // line 298
        echo "        </td>
    </tr>

    <tr>
        <td class=\"label\">";
        // line 302
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckCronArchiveProcess")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 305
        echo "            ";
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "cli_process_ok", array())) {
            // line 306
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckCronArchiveProcessCLI")), "html", null, true);
            echo ": ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
            echo "
            ";
        } else {
            // line 308
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckCronArchiveProcessCLI")), "html", null, true);
            echo ":
                ";
            // line 309
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_NotSupported")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Goals_Optional")), "html", null, true);
            echo "
            ";
        }
        // line 311
        echo "        </td>
    </tr>

    ";
        // line 314
        if (twig_test_empty((isset($context["duringInstall"]) ? $context["duringInstall"] : $this->getContext($context, "duringInstall")))) {
            // line 315
            echo "    <tr>
        <td class=\"label\">";
            // line 316
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_Geolocation")), "html", null, true);
            echo "</td>
        <td>
            ";
            // line 318
            if ($this->getAttribute($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "extra", array()), "geolocation_ok", array())) {
                // line 319
                echo "                ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo " ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Ok")), "html", null, true);
                echo "
                <br/>
            ";
            } elseif ($this->getAttribute($this->getAttribute(            // line 321
(isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "extra", array()), "geolocation_using_non_recommended", array())) {
                // line 322
                echo "                ";
                echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
                echo "
                <span class=\"warn\">";
                // line 323
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_GeoIpLocationProviderNotRecomnended")), "html", null, true);
                echo "
                    ";
                // line 324
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_GeoIpLocationProviderDesc_ServerBased2", "<a href=\"http://piwik.org/docs/geo-locate/\" rel=\"noreferrer\" target=\"_blank\">", "", "", "</a>"));
                echo "</span>
                <br/>
            ";
            } else {
                // line 327
                echo "                ";
                echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
                echo "
                <span class=\"warn\">";
                // line 328
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_DefaultLocationProviderDesc1")), "html", null, true);
                echo "
                    ";
                // line 329
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UserCountry_DefaultLocationProviderDesc2", "<a href=\"http://piwik.org/docs/geo-locate/\" rel=\"noreferrer\" target=\"_blank\">", "", "", "</a>"));
                echo " </span>
                </span>
            ";
            }
            // line 332
            echo "        </td>
    </tr>
    ";
        }
        // line 335
        echo "    ";
        if ($this->getAttribute($this->getAttribute((isset($context["infos"]) ? $context["infos"] : null), "extra", array(), "any", false, true), "load_data_infile_available", array(), "any", true, true)) {
            // line 336
            echo "        <tr>
            <td class=\"label\">";
            // line 337
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_DatabaseAbilities")), "html", null, true);
            echo "</td>
            <td>
                ";
            // line 339
            if ($this->getAttribute($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "extra", array()), "load_data_infile_available", array())) {
                // line 340
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
                echo " LOAD DATA INFILE
                    <br/>
                ";
            } else {
                // line 343
                echo "                    ";
                echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
                echo "
                    <span class=\"warn\">LOAD DATA INFILE</span>
                    <br/>
                    <br/>
                    <p>";
                // line 347
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_LoadDataInfileUnavailableHelp", "LOAD DATA INFILE", "FILE")), "html", null, true);
                echo "</p>
                    <p>";
                // line 348
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_LoadDataInfileRecommended")), "html", null, true);
                echo "</p>
                    ";
                // line 349
                if ($this->getAttribute($this->getAttribute((isset($context["infos"]) ? $context["infos"] : null), "extra", array(), "any", false, true), "load_data_infile_error", array(), "any", true, true)) {
                    // line 350
                    echo "                        <em><strong>";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Error")), "html", null, true);
                    echo ":</strong></em>
                        ";
                    // line 351
                    echo $this->getAttribute($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "extra", array()), "load_data_infile_error", array());
                    echo "
                    ";
                }
                // line 353
                echo "                    <p>Troubleshooting: <a target='_blank' href=\"?module=Proxy&action=redirect&url=http://piwik.org/faq/troubleshooting/%23faq_194\">FAQ on piwik.org</a></p>
                ";
            }
            // line 355
            echo "            </td>
        </tr>
    ";
        }
        // line 358
        echo "
    <tr>
        <td class=\"label\">";
        // line 360
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckUpdateHttps")), "html", null, true);
        echo "</td>
        <td>
            ";
        // line 362
        if ($this->getAttribute((isset($context["infos"]) ? $context["infos"] : $this->getContext($context, "infos")), "https_update", array())) {
            // line 363
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["ok"]) ? $context["ok"] : $this->getContext($context, "ok")), "html", null, true);
            echo "
            ";
        } else {
            // line 365
            echo "                ";
            echo twig_escape_filter($this->env, (isset($context["warning"]) ? $context["warning"] : $this->getContext($context, "warning")), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_SystemCheckUpdateHttpsNotSupported")), "html", null, true);
            echo "
            ";
        }
        // line 367
        echo "        </td>
    </tr>

</table>

";
        // line 372
        $this->env->loadTemplate("@Installation/_integrityDetails.twig")->display($context);
    }

    public function getTemplateName()
    {
        return "@Installation/_systemCheckSection.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1006 => 372,  999 => 367,  991 => 365,  985 => 363,  983 => 362,  978 => 360,  974 => 358,  969 => 355,  965 => 353,  960 => 351,  955 => 350,  953 => 349,  949 => 348,  945 => 347,  937 => 343,  930 => 340,  928 => 339,  923 => 337,  920 => 336,  917 => 335,  912 => 332,  906 => 329,  902 => 328,  897 => 327,  891 => 324,  887 => 323,  882 => 322,  880 => 321,  872 => 319,  870 => 318,  865 => 316,  862 => 315,  860 => 314,  855 => 311,  848 => 309,  841 => 308,  831 => 306,  828 => 305,  823 => 302,  817 => 298,  814 => 297,  808 => 295,  802 => 293,  800 => 292,  796 => 291,  791 => 290,  782 => 287,  780 => 286,  775 => 284,  770 => 281,  764 => 280,  755 => 277,  750 => 275,  746 => 274,  741 => 273,  738 => 272,  734 => 271,  729 => 269,  724 => 266,  718 => 265,  709 => 262,  704 => 260,  697 => 259,  694 => 258,  690 => 257,  685 => 255,  680 => 252,  675 => 250,  667 => 248,  661 => 246,  659 => 245,  654 => 243,  649 => 240,  641 => 238,  635 => 236,  633 => 235,  628 => 233,  623 => 230,  616 => 228,  613 => 227,  610 => 226,  605 => 224,  600 => 223,  592 => 221,  590 => 220,  585 => 218,  580 => 215,  572 => 210,  567 => 209,  561 => 207,  559 => 206,  554 => 204,  549 => 201,  544 => 199,  540 => 198,  535 => 196,  530 => 195,  522 => 193,  520 => 192,  515 => 190,  510 => 187,  505 => 185,  500 => 183,  496 => 182,  491 => 181,  485 => 179,  483 => 178,  478 => 176,  473 => 173,  470 => 172,  464 => 170,  461 => 169,  456 => 167,  451 => 166,  446 => 164,  441 => 163,  438 => 162,  432 => 160,  430 => 159,  425 => 157,  419 => 154,  414 => 151,  409 => 148,  402 => 146,  396 => 143,  393 => 142,  391 => 141,  388 => 140,  384 => 139,  380 => 138,  376 => 136,  374 => 135,  370 => 133,  360 => 130,  354 => 128,  348 => 126,  345 => 125,  341 => 124,  335 => 121,  329 => 117,  323 => 116,  314 => 113,  307 => 109,  303 => 108,  297 => 105,  292 => 104,  289 => 103,  285 => 102,  280 => 100,  275 => 97,  269 => 96,  260 => 93,  253 => 89,  249 => 88,  243 => 85,  238 => 84,  235 => 83,  231 => 82,  226 => 80,  223 => 79,  218 => 76,  209 => 73,  206 => 72,  202 => 71,  198 => 69,  196 => 68,  192 => 66,  182 => 63,  176 => 61,  171 => 59,  166 => 58,  163 => 57,  159 => 56,  154 => 54,  151 => 53,  143 => 48,  136 => 45,  130 => 43,  124 => 41,  122 => 40,  117 => 38,  113 => 36,  110 => 35,  101 => 32,  95 => 31,  92 => 30,  88 => 29,  84 => 27,  80 => 25,  77 => 23,  75 => 22,  70 => 20,  65 => 17,  55 => 15,  47 => 13,  45 => 12,  38 => 9,  32 => 8,  27 => 5,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
