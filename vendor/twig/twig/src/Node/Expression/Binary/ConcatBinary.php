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
namespace Twig\Node\Expression\Binary;

use Torch202401\Twig\Compiler;
class ConcatBinary extends \Twig\Node\Expression\Binary\AbstractBinary
{
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('.');
    }
}
\class_alias('Twig\\Node\\Expression\\Binary\\ConcatBinary', 'Torch202401\\Twig_Node_Expression_Binary_Concat');
