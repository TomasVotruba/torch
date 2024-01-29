<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Symfony\Bridge\Twig\TokenParser;

use Torch202401\Symfony\Bridge\Twig\Node\TransDefaultDomainNode;
use Twig\Node\Node;
use Torch202401\Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
/**
 * Token Parser for the 'trans_default_domain' tag.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class TransDefaultDomainTokenParser extends AbstractTokenParser
{
    public function parse(Token $token) : Node
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
        return new TransDefaultDomainNode($expr, $token->getLine(), $this->getTag());
    }
    public function getTag() : string
    {
        return 'trans_default_domain';
    }
}
