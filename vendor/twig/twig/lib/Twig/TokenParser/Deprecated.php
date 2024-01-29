<?php

namespace Torch202401;

use Torch202401\Twig\TokenParser\DeprecatedTokenParser;
\class_exists('Torch202401\\Twig\\TokenParser\\DeprecatedTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Deprecated" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\DeprecatedTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\DeprecatedTokenParser" instead */
    class Twig_TokenParser_Deprecated extends DeprecatedTokenParser
    {
    }
}
