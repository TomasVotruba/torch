<?php

namespace Torch202401;

use Torch202401\Twig\Util\DeprecationCollector;
\class_exists('Torch202401\\Twig\\Util\\DeprecationCollector');
@\trigger_error('Using the "Twig_Util_DeprecationCollector" class is deprecated since Twig version 2.7, use "Twig\\Util\\DeprecationCollector" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Util\DeprecationCollector" instead */
    class Twig_Util_DeprecationCollector extends DeprecationCollector
    {
    }
}
