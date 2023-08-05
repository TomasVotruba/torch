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
namespace Torch202308\Twig\Node;

use Torch202308\Twig\Compiler;
use Torch202308\Twig\Node\Expression\AbstractExpression;
/**
 * Represents a node that outputs an expression.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class PrintNode extends Node implements NodeOutputInterface
{
    public function __construct(AbstractExpression $expr, int $lineno, string $tag = null)
    {
        parent::__construct(['expr' => $expr], [], $lineno, $tag);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this)->write('echo ')->subcompile($this->getNode('expr'))->raw(";\n");
    }
}
\class_alias('Torch202308\\Twig\\Node\\PrintNode', 'Torch202308\\Twig_Node_Print');
