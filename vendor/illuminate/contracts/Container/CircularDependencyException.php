<?php

namespace Torch202401\Illuminate\Contracts\Container;

use Exception;
use Torch202401\Psr\Container\ContainerExceptionInterface;
class CircularDependencyException extends Exception implements ContainerExceptionInterface
{
    //
}
