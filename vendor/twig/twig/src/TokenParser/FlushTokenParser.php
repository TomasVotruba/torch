<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Twig\TokenParser;

use Torch202308\Twig\Node\FlushNode;
use Torch202308\Twig\Token;
/**
 * Flushes the output to the client.
 *
 * @see flush()
 */
final class FlushTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $this->parser->getStream()->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        return new FlushNode($token->getLine(), $this->getTag());
    }
    public function getTag()
    {
        return 'flush';
    }
}
\class_alias('Torch202308\\Twig\\TokenParser\\FlushTokenParser', 'Torch202308\\Twig_TokenParser_Flush');
