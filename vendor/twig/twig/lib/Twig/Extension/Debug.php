<?php

namespace Torch202308;

use Torch202308\Twig\Extension\DebugExtension;
\class_exists('Torch202308\\Twig\\Extension\\DebugExtension');
@\trigger_error('Using the "Twig_Extension_Debug" class is deprecated since Twig version 2.7, use "Twig\\Extension\\DebugExtension" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Extension\DebugExtension" instead */
    class Twig_Extension_Debug extends DebugExtension
    {
    }
}
