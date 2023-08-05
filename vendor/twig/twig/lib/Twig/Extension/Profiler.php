<?php

namespace Torch202308;

use Torch202308\Twig\Extension\ProfilerExtension;
\class_exists('Torch202308\\Twig\\Extension\\ProfilerExtension');
@\trigger_error('Using the "Twig_Extension_Profiler" class is deprecated since Twig version 2.7, use "Twig\\Extension\\ProfilerExtension" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Extension\ProfilerExtension" instead */
    class Twig_Extension_Profiler extends ProfilerExtension
    {
    }
}
