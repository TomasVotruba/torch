<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Twig\Node\Expression\Binary;

use Torch202308\Twig\Compiler;
class RangeBinary extends AbstractBinary
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('range(')->subcompile($this->getNode('left'))->raw(', ')->subcompile($this->getNode('right'))->raw(')');
    }
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('..');
    }
}
\class_alias('Torch202308\\Twig\\Node\\Expression\\Binary\\RangeBinary', 'Torch202308\\Twig_Node_Expression_Binary_Range');