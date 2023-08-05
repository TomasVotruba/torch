<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Symfony\Bridge\Twig\TokenParser;

use Torch202308\Symfony\Bridge\Twig\Node\FormThemeNode;
use Torch202308\Twig\Node\Expression\ArrayExpression;
use Torch202308\Twig\Node\Node;
use Torch202308\Twig\Token;
use Torch202308\Twig\TokenParser\AbstractTokenParser;
/**
 * Token Parser for the 'form_theme' tag.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class FormThemeTokenParser extends AbstractTokenParser
{
    public function parse(Token $token) : Node
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $form = $this->parser->getExpressionParser()->parseExpression();
        $only = \false;
        if ($this->parser->getStream()->test(Token::NAME_TYPE, 'with')) {
            $this->parser->getStream()->next();
            $resources = $this->parser->getExpressionParser()->parseExpression();
            if ($this->parser->getStream()->nextIf(Token::NAME_TYPE, 'only')) {
                $only = \true;
            }
        } else {
            $resources = new ArrayExpression([], $stream->getCurrent()->getLine());
            do {
                $resources->addElement($this->parser->getExpressionParser()->parseExpression());
            } while (!$stream->test(Token::BLOCK_END_TYPE));
        }
        $stream->expect(Token::BLOCK_END_TYPE);
        return new FormThemeNode($form, $resources, $lineno, $this->getTag(), $only);
    }
    public function getTag() : string
    {
        return 'form_theme';
    }
}
