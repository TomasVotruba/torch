<?php

namespace Torch202401;

use Torch202401\Twig\TokenParser\EmbedTokenParser;
\class_exists('Torch202401\\Twig\\TokenParser\\EmbedTokenParser');
@\trigger_error('Using the "Twig_TokenParser_Embed" class is deprecated since Twig version 2.7, use "Twig\\TokenParser\\EmbedTokenParser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\TokenParser\EmbedTokenParser" instead */
    class Twig_TokenParser_Embed extends EmbedTokenParser
    {
    }
}
