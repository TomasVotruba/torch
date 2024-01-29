<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Twig\Loader;

/**
 * Empty interface for Twig 1.x compatibility.
 */
interface SourceContextLoaderInterface extends \Twig\Loader\LoaderInterface
{
}
\class_alias('Twig\\Loader\\SourceContextLoaderInterface', 'Torch202401\\Twig_SourceContextLoaderInterface');
