<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Twig\TokenParser;

use Symfony\Bridge\Twig\TokenParser\FormThemeTokenParser;
use Twig\Node\Node;
use Twig\Parser;
use Twig\Token;
use Twig\TokenParser\TokenParserInterface;
/**
 * Override of @see \Symfony\Bridge\Twig\TokenParser\FormThemeTokenParser
 *
 * @see https://stackoverflow.com/questions/26843059/twig-token-parser-how-to-parse-tags-with-prefixes
 */
final class TolerantFormThemeTokenParser implements TokenParserInterface
{
    /**
     * @var \Twig\Parser
     */
    private $parser;
    /**
     * @return Node<Node>
     */
    public function parse(Token $token) : Node
    {
        // this is needed to process all the expected params
        $formThemeTokenParser = new FormThemeTokenParser();
        $formThemeTokenParser->setParser($this->parser);
        $formThemeTokenParser->parse($token);
        return new Node([], [], $token->getLine(), 'div');
    }
    public function setParser(Parser $parser) : void
    {
        $this->parser = $parser;
    }
    public function getTag() : string
    {
        return 'form_theme';
    }
}
