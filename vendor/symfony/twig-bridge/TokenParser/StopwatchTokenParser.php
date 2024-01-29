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

use Torch202401\Symfony\Bridge\Twig\Node\StopwatchNode;
use Torch202401\Twig\Node\Expression\AssignNameExpression;
use Torch202401\Twig\Node\Node;
use Torch202401\Twig\Token;
use Torch202401\Twig\TokenParser\AbstractTokenParser;
/**
 * Token Parser for the stopwatch tag.
 *
 * @author Wouter J <wouter@wouterj.nl>
 */
final class StopwatchTokenParser extends AbstractTokenParser
{
    /**
     * @var bool
     */
    private $stopwatchIsAvailable;
    public function __construct(bool $stopwatchIsAvailable)
    {
        $this->stopwatchIsAvailable = $stopwatchIsAvailable;
    }
    public function parse(Token $token) : Node
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        // {% stopwatch 'bar' %}
        $name = $this->parser->getExpressionParser()->parseExpression();
        $stream->expect(Token::BLOCK_END_TYPE);
        // {% endstopwatch %}
        $body = $this->parser->subparse(\Closure::fromCallable([$this, 'decideStopwatchEnd']), \true);
        $stream->expect(Token::BLOCK_END_TYPE);
        if ($this->stopwatchIsAvailable) {
            return new StopwatchNode($name, $body, new AssignNameExpression($this->parser->getVarName(), $token->getLine()), $lineno, $this->getTag());
        }
        return $body;
    }
    public function decideStopwatchEnd(Token $token) : bool
    {
        return $token->test('endstopwatch');
    }
    public function getTag() : string
    {
        return 'stopwatch';
    }
}
