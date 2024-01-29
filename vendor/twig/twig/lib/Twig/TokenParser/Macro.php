<?php

namespace Torch202401;

use Torch202401\Twig\TokenParser\MacroTokenParser;
\class_exists('Torch202401\\Twig\\TokenParser\\MacroTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Macro" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\MacroTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\MacroTokenParser" instead */
    class Twig_TokenParser_Macro extends MacroTokenParser
    {
    }
}
