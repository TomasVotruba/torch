<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Symfony\Bridge\Twig\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_FUNCTION)]
class Template
{
    /**
     * @var string
     */
    public $template;
    /**
     * @var mixed[]|null
     */
    public $vars;
    /**
     * @var bool
     */
    public $stream = \false;
    public function __construct(string $template, ?array $vars = null, bool $stream = \false)
    {
        /**
         * The name of the template to render.
         */
        $this->template = $template;
        /**
         * The controller method arguments to pass to the template.
         */
        $this->vars = $vars;
        /**
         * Enables streaming the template.
         */
        $this->stream = $stream;
    }
}
