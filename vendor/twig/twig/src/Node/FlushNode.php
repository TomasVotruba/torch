<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Twig\Node;

use Torch202308\Twig\Compiler;
/**
 * Represents a flush node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FlushNode extends Node
{
    public function __construct(int $lineno, string $tag)
    {
        parent::__construct([], [], $lineno, $tag);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this)->write("flush();\n");
    }
}
\class_alias('Torch202308\\Twig\\Node\\FlushNode', 'Torch202308\\Twig_Node_Flush');
