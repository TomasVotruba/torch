<?php

namespace Torch202308;

use Torch202308\Twig\Environment;
\class_exists('Torch202308\\Twig\\Environment');
@\trigger_error('Using the "Twig_Environment" class is deprecated since Twig version 2.7, use "Twig\\Environment" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Environment" instead */
    class Twig_Environment extends Environment
    {
    }
}
