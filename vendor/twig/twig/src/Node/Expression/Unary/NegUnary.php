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
namespace Torch202308\Twig\Node\Expression\Unary;

use Torch202308\Twig\Compiler;
class NegUnary extends AbstractUnary
{
    public function operator(Compiler $compiler)
    {
        $compiler->raw('-');
    }
}
\class_alias('Torch202308\\Twig\\Node\\Expression\\Unary\\NegUnary', 'Torch202308\\Twig_Node_Expression_Unary_Neg');
