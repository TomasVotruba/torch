<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Symfony\Bridge\Twig\Extension;

use Torch202308\Symfony\Component\ExpressionLanguage\Expression;
use Torch202308\Twig\Extension\AbstractExtension;
use Torch202308\Twig\TwigFunction;
/**
 * ExpressionExtension gives a way to create Expressions from a template.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class ExpressionExtension extends AbstractExtension
{
    public function getFunctions() : array
    {
        return [new TwigFunction('expression', \Closure::fromCallable([$this, 'createExpression']))];
    }
    public function createExpression(string $expression) : Expression
    {
        return new Expression($expression);
    }
}
