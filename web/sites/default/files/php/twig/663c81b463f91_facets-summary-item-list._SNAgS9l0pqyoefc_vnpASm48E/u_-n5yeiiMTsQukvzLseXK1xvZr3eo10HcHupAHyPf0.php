<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* modules/contrib/facets/modules/facets_summary/templates/facets-summary-item-list.html.twig */
class __TwigTemplate_e41ae8a7eb0c82dd1c6c88486e5a1498 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 24
        if (($context["cache_hash"] ?? null)) {
            // line 25
            echo "  <!-- facets cacheable metadata
    hash: ";
            // line 26
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["cache_hash"] ?? null), 26, $this->source), "html", null, true);
            echo "
  ";
            // line 27
            if (($context["cache_contexts"] ?? null)) {
                // line 28
                echo "    contexts: ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["cache_contexts"] ?? null), 28, $this->source), "html", null, true);
            }
            // line 30
            echo "  ";
            if (($context["cache_tags"] ?? null)) {
                // line 31
                echo "    tags: ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["cache_tags"] ?? null), 31, $this->source), "html", null, true);
            }
            // line 33
            echo "  ";
            if (($context["cache_max_age"] ?? null)) {
                // line 34
                echo "    max age: ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["cache_max_age"] ?? null), 34, $this->source), "html", null, true);
            }
            // line 36
            echo "  -->";
        }
        // line 38
        if (twig_get_attribute($this->env, $this->source, ($context["context"] ?? null), "list_style", [], "any", false, false, true, 38)) {
            // line 39
            $context["attributes"] = twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [("item-list__" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["context"] ?? null), "list_style", [], "any", false, false, true, 39), 39, $this->source))], "method", false, false, true, 39);
        }
        // line 41
        if ((($context["items"] ?? null) || ($context["empty"] ?? null))) {
            // line 42
            if ( !twig_test_empty(($context["title"] ?? null))) {
                // line 43
                echo "<h3>";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 43, $this->source), "html", null, true);
                echo "</h3>";
            }
            // line 46
            if (($context["items"] ?? null)) {
                // line 47
                echo "<";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["list_type"] ?? null), 47, $this->source), "html", null, true);
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 47, $this->source), "html", null, true);
                echo ">";
                // line 48
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["items"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 49
                    echo "<li";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 49), 49, $this->source), "html", null, true);
                    echo ">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "value", [], "any", false, false, true, 49), 49, $this->source), "html", null, true);
                    echo "</li>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 51
                echo "</";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["list_type"] ?? null), 51, $this->source), "html", null, true);
                echo ">";
            } else {
                // line 53
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["empty"] ?? null), 53, $this->source), "html", null, true);
            }
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["cache_hash", "cache_contexts", "cache_tags", "cache_max_age", "context", "items", "empty", "title", "list_type"]);    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "modules/contrib/facets/modules/facets_summary/templates/facets-summary-item-list.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  111 => 53,  106 => 51,  96 => 49,  92 => 48,  87 => 47,  85 => 46,  80 => 43,  78 => 42,  76 => 41,  73 => 39,  71 => 38,  68 => 36,  64 => 34,  61 => 33,  57 => 31,  54 => 30,  50 => 28,  48 => 27,  44 => 26,  41 => 25,  39 => 24,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/facets/modules/facets_summary/templates/facets-summary-item-list.html.twig", "/var/www/html/web/modules/contrib/facets/modules/facets_summary/templates/facets-summary-item-list.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 24, "set" => 39, "for" => 48);
        static $filters = array("escape" => 26);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'set', 'for'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
