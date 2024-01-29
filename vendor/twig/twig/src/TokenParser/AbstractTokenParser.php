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

use Torch202401\Twig\Parser;
/**
 * Base class for all token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractTokenParser implements \Twig\TokenParser\TokenParserInterface
{
    /**
     * @var Parser
     */
    protected $parser;
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }
}
\class_alias('Twig\\TokenParser\\AbstractTokenParser', 'Torch202401\\Twig_TokenParser');
