<?php

namespace Torch202308;

use Torch202308\Twig\TokenParser\DeprecatedTokenParser;
\class_exists('Torch202308\\Twig\\TokenParser\\DeprecatedTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Deprecated" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\DeprecatedTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\DeprecatedTokenParser" instead */
    class Twig_TokenParser_Deprecated extends DeprecatedTokenParser
    {
    }
}