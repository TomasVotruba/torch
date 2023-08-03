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

use Torch202308\Symfony\Component\Yaml\Dumper as YamlDumper;
use Torch202308\Twig\Extension\AbstractExtension;
use Torch202308\Twig\TwigFilter;
/**
 * Provides integration of the Yaml component with Twig.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class YamlExtension extends AbstractExtension
{
    public function getFilters() : array
    {
        return [new TwigFilter('yaml_encode', \Closure::fromCallable([$this, 'encode'])), new TwigFilter('yaml_dump', \Closure::fromCallable([$this, 'dump']))];
    }
    /**
     * @param mixed $input
     */
    public function encode($input, int $inline = 0, int $dumpObjects = 0) : string
    {
        static $dumper;
        $dumper = $dumper ?? new YamlDumper();
        if (\defined('Torch202308\\Symfony\\Component\\Yaml\\Yaml::DUMP_OBJECT')) {
            return $dumper->dump($input, $inline, 0, $dumpObjects);
        }
        return $dumper->dump($input, $inline, 0, \false, $dumpObjects);
    }
    /**
     * @param mixed $value
     */
    public function dump($value, int $inline = 0, int $dumpObjects = 0) : string
    {
        if (\is_resource($value)) {
            return '%Resource%';
        }
        if (\is_array($value) || \is_object($value)) {
            return '%' . \gettype($value) . '% ' . $this->encode($value, $inline, $dumpObjects);
        }
        return $this->encode($value, $inline, $dumpObjects);
    }
}
