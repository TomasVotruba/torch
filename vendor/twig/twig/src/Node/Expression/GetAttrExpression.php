<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Node\Expression;

use Torch202401\Twig\Compiler;
use Twig\Extension\SandboxExtension;
use Torch202401\Twig\Template;
class GetAttrExpression extends \Twig\Node\Expression\AbstractExpression
{
    public function __construct(\Twig\Node\Expression\AbstractExpression $node, \Twig\Node\Expression\AbstractExpression $attribute, ?\Twig\Node\Expression\AbstractExpression $arguments, string $type, int $lineno)
    {
        $nodes = ['node' => $node, 'attribute' => $attribute];
        if (null !== $arguments) {
            $nodes['arguments'] = $arguments;
        }
        parent::__construct($nodes, ['type' => $type, 'is_defined_test' => \false, 'ignore_strict_check' => \false, 'optimizable' => \true], $lineno);
    }
    public function compile(Compiler $compiler)
    {
        $env = $compiler->getEnvironment();
        // optimize array calls
        if ($this->getAttribute('optimizable') && (!$env->isStrictVariables() || $this->getAttribute('ignore_strict_check')) && !$this->getAttribute('is_defined_test') && Template::ARRAY_CALL === $this->getAttribute('type')) {
            $var = '$' . $compiler->getVarName();
            $compiler->raw('((' . $var . ' = ')->subcompile($this->getNode('node'))->raw(') && is_array(')->raw($var)->raw(') || ')->raw($var)->raw(' instanceof ArrayAccess ? (')->raw($var)->raw('[')->subcompile($this->getNode('attribute'))->raw('] ?? null) : null)');
            return;
        }
        $compiler->raw('twig_get_attribute($this->env, $this->source, ');
        if ($this->getAttribute('ignore_strict_check')) {
            $this->getNode('node')->setAttribute('ignore_strict_check', \true);
        }
        $compiler->subcompile($this->getNode('node'))->raw(', ')->subcompile($this->getNode('attribute'));
        if ($this->hasNode('arguments')) {
            $compiler->raw(', ')->subcompile($this->getNode('arguments'));
        } else {
            $compiler->raw(', []');
        }
        $compiler->raw(', ')->repr($this->getAttribute('type'))->raw(', ')->repr($this->getAttribute('is_defined_test'))->raw(', ')->repr($this->getAttribute('ignore_strict_check'))->raw(', ')->repr($env->hasExtension(SandboxExtension::class))->raw(', ')->repr($this->getNode('node')->getTemplateLine())->raw(')');
    }
}
\class_alias('Twig\\Node\\Expression\\GetAttrExpression', 'Torch202401\\Twig_Node_Expression_GetAttr');
