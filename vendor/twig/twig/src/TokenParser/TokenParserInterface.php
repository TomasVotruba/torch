<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Twig\TokenParser;

use Torch202401\Twig\Error\SyntaxError;
use Torch202401\Twig\Node\Node;
use Torch202401\Twig\Parser;
use Torch202401\Twig\Token;
/**
 * Interface implemented by token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface TokenParserInterface
{
    /**
     * Sets the parser associated with this token parser.
     */
    public function setParser(Parser $parser);
    /**
     * Parses a token and returns a node.
     *
     * @return Node
     *
     * @throws SyntaxError
     */
    public function parse(Token $token);
    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag();
}
\class_alias('Torch202401\\Twig\\TokenParser\\TokenParserInterface', 'Torch202401\\Twig_TokenParserInterface');
// Ensure that the aliased name is loaded to keep BC for classes implementing the typehint with the old aliased name.
\class_exists('Torch202401\\Twig\\Token');
\class_exists('Torch202401\\Twig\\Parser');
