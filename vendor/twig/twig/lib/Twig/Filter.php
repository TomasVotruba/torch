<?php

namespace Torch202401;

use Torch202401\Twig\TwigFilter;
\class_exists('Torch202401\\Twig\\TwigFilter');
@\trigger_error('Using the "Twig_Filter" class is deprecated since Twig version 2.7, use "Twig\\TwigFilter" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TwigFilter" instead */
    class Twig_Filter extends TwigFilter
    {
    }
}
