<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Node\Expression\Binary;

use Torch202401\Twig\Compiler;
class NotEqualBinary extends \Twig\Node\Expression\Binary\AbstractBinary
{
    public function operator(Compiler $compiler)
    {
        return $compiler->raw('!=');
    }
}
\class_alias('Twig\\Node\\Expression\\Binary\\NotEqualBinary', 'Torch202401\\Twig_Node_Expression_Binary_NotEqual');
