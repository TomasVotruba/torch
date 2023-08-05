<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Symfony\Bridge\Twig\EventListener;

use Torch202308\Symfony\Bridge\Twig\Attribute\Template;
use Torch202308\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Torch202308\Symfony\Component\Form\FormInterface;
use Torch202308\Symfony\Component\HttpFoundation\Response;
use Torch202308\Symfony\Component\HttpFoundation\StreamedResponse;
use Torch202308\Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Torch202308\Symfony\Component\HttpKernel\Event\ViewEvent;
use Torch202308\Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
class TemplateAttributeListener implements EventSubscriberInterface
{
    /**
     * @var \Twig\Environment
     */
    private $twig;
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    /**
     * @return void
     */
    public function onKernelView(ViewEvent $event)
    {
        $parameters = $event->getControllerResult();
        if (!\is_array($parameters ?? [])) {
            return;
        }
        $attribute = $event->getRequest()->attributes->get('_template');
        if (!$attribute instanceof Template && !($attribute = (($eventControllerArgumentsEvent = $event->controllerArgumentsEvent) ? $eventControllerArgumentsEvent->getAttributes() : null)[Template::class][0] ?? null)) {
            return;
        }
        $parameters = $parameters ?? $this->resolveParameters($event->controllerArgumentsEvent, $attribute->vars);
        $status = 200;
        foreach ($parameters as $k => $v) {
            if (!$v instanceof FormInterface) {
                continue;
            }
            if ($v->isSubmitted() && !$v->isValid()) {
                $status = 422;
            }
            $parameters[$k] = $v->createView();
        }
        $event->setResponse($attribute->stream ? new StreamedResponse(function () use($attribute, $parameters) {
            return $this->twig->display($attribute->template, $parameters);
        }, $status) : new Response($this->twig->render($attribute->template, $parameters), $status));
    }
    public static function getSubscribedEvents() : array
    {
        return [KernelEvents::VIEW => ['onKernelView', -128]];
    }
    private function resolveParameters(ControllerArgumentsEvent $event, ?array $vars) : array
    {
        if ([] === $vars) {
            return [];
        }
        $parameters = $event->getNamedArguments();
        if (null !== $vars) {
            $parameters = \array_intersect_key($parameters, \array_flip($vars));
        }
        return $parameters;
    }
}
