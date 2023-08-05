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

use Torch202308\Twig\Error\SyntaxError;
use Torch202308\Twig\Node\IncludeNode;
use Torch202308\Twig\Node\SandboxNode;
use Torch202308\Twig\Node\TextNode;
use Torch202308\Twig\Token;
/**
 * Marks a section of a template as untrusted code that must be evaluated in the sandbox mode.
 *
 *    {% sandbox %}
 *        {% include 'user.html' %}
 *    {% endsandbox %}
 *
 * @see https://twig.symfony.com/doc/api.html#sandbox-extension for details
 */
final class SandboxTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $stream = $this->parser->getStream();
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        // in a sandbox tag, only include tags are allowed
        if (!$body instanceof IncludeNode) {
            foreach ($body as $node) {
                if ($node instanceof TextNode && \ctype_space($node->getAttribute('data'))) {
                    continue;
                }
                if (!$node instanceof IncludeNode) {
                    throw new SyntaxError('Only "include" tags are allowed within a "sandbox" section.', $node->getTemplateLine(), $stream->getSourceContext());
                }
            }
        }
        return new SandboxNode($body, $token->getLine(), $this->getTag());
    }
    public function decideBlockEnd(Token $token)
    {
        return $token->test('endsandbox');
    }
    public function getTag()
    {
        return 'sandbox';
    }
}
\class_alias('Torch202308\\Twig\\TokenParser\\SandboxTokenParser', 'Torch202308\\Twig_TokenParser_Sandbox');
