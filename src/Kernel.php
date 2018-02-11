<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'simon';
    }

    /**
     * @inheritDoc
     */
    public function getCacheDir(): string
    {
        $var = $this->getVarDir();
        $env = $this->getEnvironment();

        return "{$var}/cache/{$env}";
    }

    /**
     * @inheritDoc
     */
    public function getLogDir(): string
    {
        $var = $this->getVarDir();

        return "{$var}/log";
    }

    /**
     * @inheritDoc
     */
    public function registerBundles(): \Generator
    {
        $config = $this->getConfigDir();
        $env = $this->getEnvironment();
        $bundles = require "{$config}/bundles.php";

        foreach ($bundles as $className => $environments) {
            if (isset($environments['all']) || isset($environments[$env])) {
                yield new $className();
            }
        }
    }

    /**
     * @inheritDoc
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);

        $config = $this->getConfigDir();
        $env = $this->getEnvironment();

        // Load packages configuration
        $loader->load("{$config}/packages/*.yaml", 'glob');
        $loader->load("{$config}/packages/{$env}/*.yaml", 'glob');

        // Load application services
        $loader->load("{$config}/services.yaml");

        if (\file_exists("{$config}/services_{$env}.yaml")) {
            $loader->load("{$config}/services_{$env}.yaml");
        }
    }

    /**
     * @inheritDoc
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $config = $this->getConfigDir();
        $env = $this->getEnvironment();

        // Load packages routes
        $routes->import("{$config}/routes/*.yaml", '/', 'glob');

        if (\is_dir("{$config}/routes/{$env}")) {
            $routes->import("{$config}/routes/{$env}/*.yaml", '/', 'glob');
        }

        // Load application routes
        $routes->import("{$config}/routes.yaml");
    }

    /**
     * Gives the directory containing the variable files.
     */
    private function getVarDir(): string
    {
        $project = $this->getProjectDir();

        return "{$project}/var";
    }

    /**
     * Gives the configuration directory.
     */
    private function getConfigDir(): string
    {
        $project = $this->getProjectDir();

        return "{$project}/config";
    }
}
