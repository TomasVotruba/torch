<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\TokenParser;

use Twig\Node\DoNode;
use Torch202401\Twig\Token;
/**
 * Evaluates an expression, discarding the returned value.
 */
final class DoTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        $this->parser->getStream()->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        return new DoNode($expr, $token->getLine(), $this->getTag());
    }
    public function getTag()
    {
        return 'do';
    }
}
\class_alias('Twig\\TokenParser\\DoTokenParser', 'Torch202401\\Twig_TokenParser_Do');
