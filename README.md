# Torch

...when you need to cover your Twig with smoke.

[![Downloads](https://img.shields.io/packagist/dt/tomasvotruba/torch.svg?style=flat-square)](https://packagist.org/packages/tomasvotruba/torch/stats)

<br>

## Install

```bash
composer require tomasvotruba/torch --dev
```

<br>

## Usage

1. Create `torch.php` in your project root:

```php
use Twig\Environment;

require_once __DIR__ . '/vendor/autoload.php';

// create instance of Environment with everything needed for smoke render
$environment = new Environment(...);

return $environment;
```

In this file, you can override existing twig functions:

```php
// override twig functions you need
StaticParameterProvider::set('overrideFunctions', [
    // provide static value for dynamic function
    'baseTemplate' => function () {
        return DummyTheme::LAYOUT_NAME;
    },
]);
```

<br>

2. Run torch your twig files directories:

```php
vendor/bin/torch run templates
```

<br>

## Behind Scenes

* https://tomasvotruba.com/blog/twig-smoke-rendering-why-do-we-even-need-it/
* https://tomasvotruba.com/blog/twig-smoke-rendering-journey-of-fails/
* https://tomasvotruba.com/blog/twig-smoke-rendering-fortune-favors-the-bold


Happy coding!
