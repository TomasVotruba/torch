<?php

namespace Torch202401;

use Torch202401\Twig\Cache\NullCache;
\class_exists('Torch202401\\Twig\\Cache\\NullCache');
@\trigger_error('Using the "Twig_Cache_Null" class is deprecated since Twig version 2.7, use "Twig\\Cache\\NullCache" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Cache\NullCache" instead */
    class Twig_Cache_Null extends NullCache
    {
    }
}
