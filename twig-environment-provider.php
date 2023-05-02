<?php

// a file that returns twig environment of the project
// here its for testing purposes only
use Twig\Environment;
use Twig\Loader\ArrayLoader;

// this just for demo purposes :) better provide from the project itself
$environment = new Environment(
    new ArrayLoader([])
);

// add form extensions
// $environment->addExtension(new \Symfony\Bridge\Twig\Extension\FormExtension());

return $environment;
