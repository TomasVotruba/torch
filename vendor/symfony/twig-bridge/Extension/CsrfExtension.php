<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Symfony\Bridge\Twig\Extension;

use Torch202401\Twig\Extension\AbstractExtension;
use Torch202401\Twig\TwigFunction;
/**
 * @author Christian Flothmann <christian.flothmann@sensiolabs.de>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
final class CsrfExtension extends AbstractExtension
{
    public function getFunctions() : array
    {
        return [new TwigFunction('csrf_token', [CsrfRuntime::class, 'getCsrfToken'])];
    }
}
