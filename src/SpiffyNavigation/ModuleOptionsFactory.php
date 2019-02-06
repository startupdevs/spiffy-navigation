<?php

namespace SpiffyNavigation;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ModuleOptionsFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @throws \RuntimeException
     * @return ModuleOptions
     */
    public function __invoke(ContainerInterface $serviceLocator,
        $requestedName, array $options = null)
    {
        $config = $serviceLocator->get('Configuration');

        if (!isset($config['spiffy_navigation'])) {
            throw new \RuntimeException('Missing `spiffy_navigation` configuration key');
        }

        $config = $config['spiffy_navigation'];
        return new ModuleOptions($config);
    }
}