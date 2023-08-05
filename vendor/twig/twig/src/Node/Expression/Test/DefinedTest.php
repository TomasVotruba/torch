<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Twig\Node\Expression\Test;

use Torch202308\Twig\Compiler;
use Torch202308\Twig\Error\SyntaxError;
use Torch202308\Twig\Node\Expression\ArrayExpression;
use Torch202308\Twig\Node\Expression\BlockReferenceExpression;
use Torch202308\Twig\Node\Expression\ConstantExpression;
use Torch202308\Twig\Node\Expression\FunctionExpression;
use Torch202308\Twig\Node\Expression\GetAttrExpression;
use Torch202308\Twig\Node\Expression\MethodCallExpression;
use Torch202308\Twig\Node\Expression\NameExpression;
use Torch202308\Twig\Node\Expression\TestExpression;
use Torch202308\Twig\Node\Node;
/**
 * Checks if a variable is defined in the current context.
 *
 *    {# defined works with variable names and variable attributes #}
 *    {% if foo is defined %}
 *        {# ... #}
 *    {% endif %}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DefinedTest extends TestExpression
{
    public function __construct(Node $node, string $name, ?Node $arguments, int $lineno)
    {
        if ($node instanceof NameExpression) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof GetAttrExpression) {
            $node->setAttribute('is_defined_test', \true);
            $this->changeIgnoreStrictCheck($node);
        } elseif ($node instanceof BlockReferenceExpression) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof FunctionExpression && 'constant' === $node->getAttribute('name')) {
            $node->setAttribute('is_defined_test', \true);
        } elseif ($node instanceof ConstantExpression || $node instanceof ArrayExpression) {
            $node = new ConstantExpression(\true, $node->getTemplateLine());
        } elseif ($node instanceof MethodCallExpression) {
            $node->setAttribute('is_defined_test', \true);
        } else {
            throw new SyntaxError('The "defined" test only works with simple variables.', $lineno);
        }
        parent::__construct($node, $name, $arguments, $lineno);
    }
    private function changeIgnoreStrictCheck(GetAttrExpression $node)
    {
        $node->setAttribute('optimizable', \false);
        $node->setAttribute('ignore_strict_check', \true);
        if ($node->getNode('node') instanceof GetAttrExpression) {
            $this->changeIgnoreStrictCheck($node->getNode('node'));
        }
    }
    public function compile(Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('node'));
    }
}
\class_alias('Torch202308\\Twig\\Node\\Expression\\Test\\DefinedTest', 'Torch202308\\Twig_Node_Expression_Test_Defined');