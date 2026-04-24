# alxarafe/resource-twig

> [!WARNING]
> **DEPRECATED AND OBSOLETE**
> 
> This package has been deprecated and its functionality has been natively integrated into [**resource-controller**](https://github.com/alxarafe/resource-controller) via the `DefaultRenderer` and static HTML templates. 
> You no longer need this package. Please remove it from your dependencies.

![PHP Version](https://img.shields.io/badge/PHP-8.2+-blueviolet?style=flat-square)
![CI](https://github.com/alxarafe/resource-twig/actions/workflows/ci.yml/badge.svg)
![Tests](https://github.com/alxarafe/resource-twig/actions/workflows/tests.yml/badge.svg)
![Static Analysis](https://img.shields.io/badge/static%20analysis-PHPStan%20%2B%20Psalm-blue?style=flat-square)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/alxarafe/resource-twig/issues)

**Twig adapter for alxarafe/resource-controller.**

Provides a `RendererContract` implementation using Twig for flexible and decoupled template rendering.

## Ecosystem

| Package | Purpose | Status |
|---|---|---|
| **[resource-controller](https://github.com/alxarafe/resource-controller)** | Core CRUD engine + UI components | ✅ Stable |
| **[resource-eloquent](https://github.com/alxarafe/resource-eloquent)** | Eloquent ORM adapter | ✅ Stable |
| **[resource-blade](https://github.com/alxarafe/resource-blade)** | Blade template renderer adapter | ✅ Stable |
| **[resource-twig](https://github.com/alxarafe/resource-twig)** | Twig template renderer adapter | ✅ Stable |

## Installation

```bash
composer require alxarafe/resource-twig
```

This will also install `alxarafe/resource-controller` as a dependency.

## Usage

```php
use Alxarafe\ResourceTwig\TwigRenderer;

// Create a renderer with template paths
$renderer = new TwigRenderer(
    templatePaths: [__DIR__ . '/templates'],
    cachePath: __DIR__ . '/cache/twig',    // false to disable caching
    debug: false
);

// Render a template (auto-appends .html.twig if no extension)
echo $renderer->render('products/index', [
    'title' => 'Products',
    'items' => $products,
]);

// Add additional template paths at runtime
$renderer->addTemplatePath(__DIR__ . '/module-templates');
```

### Template example

```twig
{# templates/products/index.html.twig #}
<h1>{{ title }}</h1>
<ul>
{% for item in items %}
    <li>{{ item.name }} — {{ item.price }}</li>
{% endfor %}
</ul>
```

## Development

### Docker

```bash
docker compose up -d
docker exec alxarafe-resources composer install
```

### Running the CI pipeline locally

```bash
bash bin/ci_local.sh
```

### Running tests only

```bash
bash bin/run_tests.sh
```

## License

GPL-3.0-or-later
