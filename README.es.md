# alxarafe/resource-twig

> [!WARNING]
> **DEPRECADO Y OBSOLETO**
> 
> Este paquete ha sido deprecado y su funcionalidad se ha integrado de forma nativa en [**resource-controller**](https://github.com/alxarafe/resource-controller) a través de `DefaultRenderer` y plantillas HTML estáticas.
> Ya no necesitas este paquete. Por favor, elimínalo de tus dependencias.

![PHP Version](https://img.shields.io/badge/PHP-8.2+-blueviolet?style=flat-square)
![CI](https://github.com/alxarafe/resource-twig/actions/workflows/ci.yml/badge.svg)
![Tests](https://github.com/alxarafe/resource-twig/actions/workflows/tests.yml/badge.svg)
![Static Analysis](https://img.shields.io/badge/static%20analysis-PHPStan%20%2B%20Psalm-blue?style=flat-square)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/alxarafe/resource-twig/issues)

**Adaptador Twig para alxarafe/resource-controller.**

Proporciona una implementación de `RendererContract` usando Twig para un renderizado de plantillas flexible y desacoplado.

## Ecosistema

| Paquete | Propósito | Estado |
|---|---|---|
| **[resource-controller](https://github.com/alxarafe/resource-controller)** | Motor CRUD central + componentes UI | ✅ Estable |
| **[resource-eloquent](https://github.com/alxarafe/resource-eloquent)** | Adaptador ORM Eloquent | ✅ Estable |
| **[resource-blade](https://github.com/alxarafe/resource-blade)** | Adaptador de renderizado con Blade | ✅ Estable |
| **[resource-twig](https://github.com/alxarafe/resource-twig)** | Adaptador de renderizado con Twig | ✅ Estable |

## Instalación

```bash
composer require alxarafe/resource-twig
```

Esto también instalará `alxarafe/resource-controller` como dependencia.

## Uso

```php
use Alxarafe\ResourceTwig\TwigRenderer;

// Crear un renderer con las rutas de plantillas
$renderer = new TwigRenderer(
    templatePaths: [__DIR__ . '/templates'],
    cachePath: __DIR__ . '/cache/twig',    // false para desactivar la caché
    debug: false
);

// Renderizar una plantilla (añade .html.twig automáticamente si no tiene extensión)
echo $renderer->render('products/index', [
    'title' => 'Productos',
    'items' => $products,
]);

// Añadir rutas de plantillas adicionales en tiempo de ejecución
$renderer->addTemplatePath(__DIR__ . '/module-templates');
```

## Desarrollo

### Docker

```bash
docker compose up -d
docker exec alxarafe-resources composer install
```

### Ejecutar el pipeline CI en local

```bash
bash bin/ci_local.sh
```

### Ejecutar solo los tests

```bash
bash bin/run_tests.sh
```

## Licencia

GPL-3.0-or-later
