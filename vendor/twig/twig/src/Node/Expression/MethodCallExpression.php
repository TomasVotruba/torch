<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Node\Expression;

use Torch202401\Twig\Compiler;
class MethodCallExpression extends \Twig\Node\Expression\AbstractExpression
{
    public function __construct(\Twig\Node\Expression\AbstractExpression $node, string $method, \Twig\Node\Expression\ArrayExpression $arguments, int $lineno)
    {
        parent::__construct(['node' => $node, 'arguments' => $arguments], ['method' => $method, 'safe' => \false, 'is_defined_test' => \false], $lineno);
        if ($node instanceof \Twig\Node\Expression\NameExpression) {
            $node->setAttribute('always_defined', \true);
        }
    }
    public function compile(Compiler $compiler)
    {
        if ($this->getAttribute('is_defined_test')) {
            $compiler->raw('method_exists($macros[')->repr($this->getNode('node')->getAttribute('name'))->raw('], ')->repr($this->getAttribute('method'))->raw(')');
            return;
        }
        $compiler->raw('twig_call_macro($macros[')->repr($this->getNode('node')->getAttribute('name'))->raw('], ')->repr($this->getAttribute('method'))->raw(', [');
        $first = \true;
        foreach ($this->getNode('arguments')->getKeyValuePairs() as $pair) {
            if (!$first) {
                $compiler->raw(', ');
            }
            $first = \false;
            $compiler->subcompile($pair['value']);
        }
        $compiler->raw('], ')->repr($this->getTemplateLine())->raw(', $context, $this->getSourceContext())');
    }
}
\class_alias('Twig\\Node\\Expression\\MethodCallExpression', 'Torch202401\\Twig_Node_Expression_MethodCall');
