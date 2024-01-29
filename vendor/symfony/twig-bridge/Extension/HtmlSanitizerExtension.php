<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Bridge\Twig\Extension;

use Torch202401\Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
final class HtmlSanitizerExtension extends AbstractExtension
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    private $sanitizers;
    /**
     * @var string
     */
    private $defaultSanitizer = 'default';
    public function __construct(ContainerInterface $sanitizers, string $defaultSanitizer = 'default')
    {
        $this->sanitizers = $sanitizers;
        $this->defaultSanitizer = $defaultSanitizer;
    }
    public function getFilters() : array
    {
        return [new TwigFilter('sanitize_html', \Closure::fromCallable([$this, 'sanitize']), ['is_safe' => ['html']])];
    }
    public function sanitize(string $html, string $sanitizer = null) : string
    {
        return $this->sanitizers->get($sanitizer ?? $this->defaultSanitizer)->sanitize($html);
    }
}
