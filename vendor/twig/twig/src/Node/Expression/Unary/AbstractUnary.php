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
namespace Torch202401\Twig\Node\Expression\Unary;

use Torch202401\Twig\Compiler;
use Torch202401\Twig\Node\Expression\AbstractExpression;
use Torch202401\Twig\Node\Node;
abstract class AbstractUnary extends AbstractExpression
{
    public function __construct(Node $node, int $lineno)
    {
        parent::__construct(['node' => $node], [], $lineno);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->raw(' ');
        $this->operator($compiler);
        $compiler->subcompile($this->getNode('node'));
    }
    public abstract function operator(Compiler $compiler);
}
\class_alias('Torch202401\\Twig\\Node\\Expression\\Unary\\AbstractUnary', 'Torch202401\\Twig_Node_Expression_Unary');
