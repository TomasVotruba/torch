<?php

namespace Torch202308;

use Torch202308\Twig\Markup;
\class_exists('Torch202308\\Twig\\Markup');
@\trigger_error('Using the "Twig_Markup" class is deprecated since Twig version 2.7, use "Twig\\Markup" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Markup" instead */
    class Twig_Markup extends Markup
    {
    }
}
