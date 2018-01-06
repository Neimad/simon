<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        return \sprintf('%s/var/cache/%s',
            $this->getProjectDir(),
            $this->environment);
    }

    public function getLogDir(): string
    {
        return \sprintf('%s/var/log', $this->getProjectDir());
    }

    public function registerBundles(): \Generator
    {
        $bundles = require $this->getConfigurationPath('bundles.php');

        foreach ($bundles as $className => $environments) {
            if (isset($environments['all']) || isset($environments[$this->environment])) {
                yield new $className();
            }
        }
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);

        // Load packages configuration
        $loader->load($this->getConfigurationPath('packages/*.yaml'), 'glob');

        if (\is_dir($this->getConfigurationPath('packages', $this->environment))) {
            $loader->load($this->getConfigurationPath('packages', $this->environment, '/**/*.yaml'), 'glob');
        }

        // Load application services
        $loader->load($this->getConfigurationPath('services.yaml'));

        if (\file_exists($this->getConfigurationPath('services_' . $this->environment . '.yaml'))) {
            $loader->load($this->getConfigurationPath('services_' . $this->environment . '.yaml'));
        }
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        // Load packages routes
        if (\is_dir($this->getConfigurationPath('routes'))) {
            $routes->import($this->getConfigurationPath('routes/*.yaml'), '/', 'glob');
        }
        if (\is_dir($this->getConfigurationPath('routes', $this->environment))) {
            $routes->import($this->getConfigurationPath('routes', $this->environment, '*.yaml'), '/', 'glob');
        }

        // Load application routes
        $routes->import($this->getConfigurationPath('routes.yaml'));
    }

    private function getConfigurationPath(string ...$components): string
    {
        return \sprintf('%s/config/%s',
            $this->getProjectDir(),
            \implode("/", $components));
    }
}
