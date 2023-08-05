<?php

namespace Torch202308;

use Torch202308\Twig\TokenParser\UseTokenParser;
\class_exists('Torch202308\\Twig\\TokenParser\\UseTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Use" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\UseTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\UseTokenParser" instead */
    class Twig_TokenParser_Use extends UseTokenParser
    {
    }
}
