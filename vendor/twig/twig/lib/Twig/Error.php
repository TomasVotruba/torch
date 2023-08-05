<?php

namespace Torch202308;

use Torch202308\Twig\Error\Error;
\class_exists('Torch202308\\Twig\\Error\\Error');
@\trigger_error('Using the "Twig_Error" class is deprecated since Twig version 2.7, use "Twig\\Error\\Error" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Error\Error" instead */
    class Twig_Error extends Error
    {
    }
}
