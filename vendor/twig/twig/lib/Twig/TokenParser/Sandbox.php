<?php

namespace Torch202401;

use Torch202401\Twig\TokenParser\SandboxTokenParser;
\class_exists('Torch202401\\Twig\\TokenParser\\SandboxTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Sandbox" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\SandboxTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\SandboxTokenParser" instead */
    class Twig_TokenParser_Sandbox extends SandboxTokenParser
    {
    }
}
