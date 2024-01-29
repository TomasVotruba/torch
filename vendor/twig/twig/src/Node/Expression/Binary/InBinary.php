<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Twig\Node\Expression\Binary;

use Torch202401\Twig\Compiler;
class InBinary extends AbstractBinary
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('twig_in_filter(')->subcompile($this->getNode('left'))->raw(', ')->subcompile($this->getNode('right'))->raw(')');
    }
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('in');
    }
}
\class_alias('Torch202401\\Twig\\Node\\Expression\\Binary\\InBinary', 'Torch202401\\Twig_Node_Expression_Binary_In');
