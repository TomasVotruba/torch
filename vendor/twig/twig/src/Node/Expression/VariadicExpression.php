<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Twig\Node\Expression;

use Torch202401\Twig\Compiler;
class VariadicExpression extends ArrayExpression
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('...');
        parent::compile($compiler);
    }
}
