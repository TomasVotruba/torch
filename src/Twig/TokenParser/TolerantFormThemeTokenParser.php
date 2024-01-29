<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Twig\TokenParser;

use Torch202401\Symfony\Bridge\Twig\TokenParser\FormThemeTokenParser;
use Torch202401\Twig\Node\Node;
use Torch202401\Twig\Parser;
use Torch202401\Twig\Token;
use Torch202401\Twig\TokenParser\TokenParserInterface;
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
