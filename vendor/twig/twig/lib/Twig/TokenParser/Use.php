<?php

namespace Torch202401;

use Torch202401\Twig\TokenParser\UseTokenParser;
\class_exists('Torch202401\\Twig\\TokenParser\\UseTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Use" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\UseTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\UseTokenParser" instead */
    class Twig_TokenParser_Use extends UseTokenParser
    {
    }
}
