<?php

namespace Torch202308\Illuminate\Contracts\Container;

use Exception;
use Torch202308\Psr\Container\ContainerExceptionInterface;
class CircularDependencyException extends Exception implements ContainerExceptionInterface
{
    //
}
