<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202308\Symfony\Bridge\Twig\Extension;

use Torch202308\Symfony\Component\AssetMapper\ImportMap\ImportMapRenderer;
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
    public function importmap(?string $entryPoint = 'app', array $attributes = []) : string
    {
        return $this->importMapRenderer->render($entryPoint, $attributes);
    }
}
