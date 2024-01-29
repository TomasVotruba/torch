<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Symfony\Bridge\Twig\ErrorRenderer;

use Torch202401\Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Torch202401\Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Torch202401\Symfony\Component\ErrorHandler\Exception\FlattenException;
use Torch202401\Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
/**
 * Provides the ability to render custom Twig-based HTML error pages
 * in non-debug mode, otherwise falls back to HtmlErrorRenderer.
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class TwigErrorRenderer implements ErrorRendererInterface
{
    /**
     * @var \Twig\Environment
     */
    private $twig;
    /**
     * @var \Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer
     */
    private $fallbackErrorRenderer;
    /**
     * @var \Closure|bool
     */
    private $debug;
    /**
     * @param bool|callable $debug The debugging mode as a boolean or a callable that should return it
     */
    public function __construct(Environment $twig, HtmlErrorRenderer $fallbackErrorRenderer = null, $debug = \false)
    {
        $this->twig = $twig;
        $this->fallbackErrorRenderer = $fallbackErrorRenderer ?? new HtmlErrorRenderer();
        $this->debug = \is_bool($debug) ? $debug : \Closure::fromCallable($debug);
    }
    public function render(\Throwable $exception) : FlattenException
    {
        $flattenException = FlattenException::createFromThrowable($exception);
        $debug = \is_bool($this->debug) ? $this->debug : ($this->debug)($flattenException);
        if ($debug || !($template = $this->findTemplate($flattenException->getStatusCode()))) {
            return $this->fallbackErrorRenderer->render($exception);
        }
        return $flattenException->setAsString($this->twig->render($template, ['exception' => $flattenException, 'status_code' => $flattenException->getStatusCode(), 'status_text' => $flattenException->getStatusText()]));
    }
    public static function isDebug(RequestStack $requestStack, bool $debug) : \Closure
    {
        return static function () use($requestStack, $debug) : bool {
            if (!($request = $requestStack->getCurrentRequest())) {
                return $debug;
            }
            return $debug && $request->attributes->getBoolean('showException', \true);
        };
    }
    private function findTemplate(int $statusCode) : ?string
    {
        $template = \sprintf('@Twig/Exception/error%s.html.twig', $statusCode);
        if ($this->twig->getLoader()->exists($template)) {
            return $template;
        }
        $template = '@Twig/Exception/error.html.twig';
        if ($this->twig->getLoader()->exists($template)) {
            return $template;
        }
        return null;
    }
}
