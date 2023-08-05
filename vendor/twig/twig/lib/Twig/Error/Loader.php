<?php

namespace Torch202308;

use Torch202308\Twig\Error\LoaderError;
\class_exists('Torch202308\\Twig\\Error\\LoaderError');
@\trigger_error('Using the "Twig_Error_Loader" class is deprecated since Twig version 2.7, use "Twig\\Error\\LoaderError" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Error\LoaderError" instead */
    class Twig_Error_Loader extends LoaderError
    {
    }
}
