<?php

namespace Torch202401;

use Torch202401\Twig\Parser;
\class_exists('Torch202401\\Twig\\Parser');
@\trigger_error('Using the "Twig_Parser" class is deprecated since Twig version 2.7, use "Twig\\Parser" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Parser" instead */
    class Twig_Parser extends Parser
    {
    }
}
