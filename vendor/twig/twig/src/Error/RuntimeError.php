<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Torch202401\Twig\Error;

/**
 * Exception thrown when an error occurs at runtime.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class RuntimeError extends Error
{
}
\class_alias('Torch202401\\Twig\\Error\\RuntimeError', 'Torch202401\\Twig_Error_Runtime');
