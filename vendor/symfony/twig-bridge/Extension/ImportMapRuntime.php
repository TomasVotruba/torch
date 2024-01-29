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

use Torch202401\Symfony\Component\AssetMapper\ImportMap\ImportMapRenderer;
/**
 * @author Kévin Dunglas <kevin@dunglas.dev>
 */
class ImportMapRuntime
{
    /**
     * @readonly
     * @var \Symfony\Component\AssetMapper\ImportMap\ImportMapRenderer
     */
    private $importMapRenderer;
    public function __construct(ImportMapRenderer $importMapRenderer)
    {
        $this->importMapRenderer = $importMapRenderer;
    }
    /**
     * @param string|mixed[]|null $entryPoint
     */
    public function importmap($entryPoint = 'app', array $attributes = []) : string
    {
        if (null === $entryPoint) {
            trigger_deprecation('symfony/twig-bridge', '6.4', 'Passing null as the first argument of the "importmap" Twig function is deprecated, pass an empty array if no entrypoints are desired.');
        }
        return $this->importMapRenderer->render($entryPoint, $attributes);
    }
}
