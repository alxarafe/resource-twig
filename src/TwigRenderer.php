<?php

declare(strict_types=1);

namespace Alxarafe\ResourceTwig;

use Alxarafe\ResourceController\Contracts\RendererContract;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * TwigRenderer — RendererContract implementation using the Twig template engine.
 *
 * Supports multiple template paths and optional caching.
 */
class TwigRenderer implements RendererContract
{
    private Environment $twig;
    private FilesystemLoader $loader;

    /**
     * @param string|string[] $templatePaths Directories where Twig templates are located.
     * @param string|false    $cachePath     Directory for compiled templates, or false to disable caching.
     * @param bool            $debug         Enable Twig debug mode.
     */
    public function __construct(string|array $templatePaths, string|false $cachePath = false, bool $debug = false)
    {
        $paths = is_array($templatePaths) ? $templatePaths : [$templatePaths];
        $this->loader = new FilesystemLoader($paths);

        $options = ['debug' => $debug];
        if ($cachePath !== false) {
            $options['cache'] = $cachePath;
        }

        $this->twig = new Environment($this->loader, $options);
    }

    #[\Override]
    public function render(string $template, array $data = []): string
    {
        // Append .twig extension if not present
        if (!str_ends_with($template, '.twig') && !str_ends_with($template, '.html')) {
            $template .= '.html.twig';
        }

        return $this->twig->render($template, $data);
    }

    #[\Override]
    public function addTemplatePath(string $path): void
    {
        $this->loader->addPath($path);
    }

    /**
     * Get the underlying Twig Environment for advanced usage.
     */
    public function getEnvironment(): Environment
    {
        return $this->twig;
    }
}
