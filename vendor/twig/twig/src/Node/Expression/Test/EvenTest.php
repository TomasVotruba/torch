<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Twig\Node\Expression\Test;

use Torch202401\Twig\Compiler;
use Torch202401\Twig\Node\Expression\TestExpression;
/**
 * Checks if a number is even.
 *
 *  {{ var is even }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class EvenTest extends TestExpression
{
    public function compile(Compiler $compiler)
    {
        $compiler->raw('(')->subcompile($this->getNode('node'))->raw(' % 2 == 0')->raw(')');
    }
}
\class_alias('Torch202401\\Twig\\Node\\Expression\\Test\\EvenTest', 'Torch202401\\Twig_Node_Expression_Test_Even');
