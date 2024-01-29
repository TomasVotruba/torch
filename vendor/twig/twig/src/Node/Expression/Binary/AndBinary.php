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
class AndBinary extends AbstractBinary
{
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('&&');
    }
}
\class_alias('Torch202401\\Twig\\Node\\Expression\\Binary\\AndBinary', 'Torch202401\\Twig_Node_Expression_Binary_And');
