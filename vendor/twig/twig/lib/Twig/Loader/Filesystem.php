<?php

namespace Torch202308;

use Torch202308\Twig\Loader\FilesystemLoader;
\class_exists('Torch202308\\Twig\\Loader\\FilesystemLoader');
@\trigger_error('Using the "Twig_Loader_Filesystem" class is deprecated since Twig version 2.7, use "Twig\\Loader\\FilesystemLoader" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Loader\FilesystemLoader" instead */
    class Twig_Loader_Filesystem extends FilesystemLoader
    {
    }
}