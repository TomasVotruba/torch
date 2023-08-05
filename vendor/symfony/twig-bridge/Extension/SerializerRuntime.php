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

use Torch202308\Symfony\Component\Serializer\SerializerInterface;
use Torch202308\Twig\Extension\RuntimeExtensionInterface;
/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class SerializerRuntime implements RuntimeExtensionInterface
{
    /**
     * @var \Symfony\Component\Serializer\SerializerInterface
     */
    private $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    /**
     * @param mixed $data
     */
    public function serialize($data, string $format = 'json', array $context = []) : string
    {
        return $this->serializer->serialize($data, $format, $context);
    }
}