<?php

namespace Torch202401;

use Torch202401\Twig\Markup;
\class_exists('Torch202401\\Twig\\Markup');
@\trigger_error('Using the "Twig_Markup" class is deprecated since Twig version 2.7, use "Twig\\Markup" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Markup" instead */
    class Twig_Markup extends Markup
    {
    }
}
