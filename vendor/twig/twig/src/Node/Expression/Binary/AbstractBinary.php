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
namespace Torch202401\Twig\Node\Expression\Binary;

use Torch202401\Twig\Compiler;
use Torch202401\Twig\Node\Expression\AbstractExpression;
use Torch202401\Twig\Node\Node;
abstract class AbstractBinary extends AbstractExpression
{
    public function __construct(Node $left, Node $right, int $lineno)
    {
        parent::__construct(['left' => $left, 'right' => $right], [], $lineno);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->raw('(')->subcompile($this->getNode('left'))->raw(' ');
        $this->operator($compiler);
        $compiler->raw(' ')->subcompile($this->getNode('right'))->raw(')');
    }
    public abstract function operator(Compiler $compiler);
}
\class_alias('Torch202401\\Twig\\Node\\Expression\\Binary\\AbstractBinary', 'Torch202401\\Twig_Node_Expression_Binary');
