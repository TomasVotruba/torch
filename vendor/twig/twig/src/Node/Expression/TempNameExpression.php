<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Node\Expression;

use Torch202401\Twig\Compiler;
class TempNameExpression extends \Twig\Node\Expression\AbstractExpression
{
    public function __construct(string $name, int $lineno)
    {
        parent::__construct([], ['name' => $name], $lineno);
    }
    public function compile(Compiler $compiler)
    {
        $compiler->raw('$_')->raw($this->getAttribute('name'))->raw('_');
    }
}
\class_alias('Twig\\Node\\Expression\\TempNameExpression', 'Torch202401\\Twig_Node_Expression_TempName');
