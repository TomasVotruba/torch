<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Symfony\Bridge\Twig\Test\Traits;

use Torch202401\Symfony\Component\Form\FormRenderer;
use Twig\Environment;
use Torch202401\Twig\RuntimeLoader\RuntimeLoaderInterface;
trait RuntimeLoaderProvider
{
    protected function registerTwigRuntimeLoader(Environment $environment, FormRenderer $renderer)
    {
        $loader = $this->createMock(RuntimeLoaderInterface::class);
        $loader->expects($this->any())->method('load')->will($this->returnValueMap([['Torch202401\\Symfony\\Component\\Form\\FormRenderer', $renderer]]));
        $environment->addRuntimeLoader($loader);
    }
}
