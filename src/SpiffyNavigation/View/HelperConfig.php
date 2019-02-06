<?php

namespace SpiffyNavigation\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceManager;

class HelperConfig implements ConfigInterface
{
    /**
     * @var array Pre-aliased view helpers
     */
    protected $helpers = array(
        'navigationBreadcrumbs' => 'SpiffyNavigation\View\Helper\NavigationBreadcrumbs',
        'navigationMenu'        => 'SpiffyNavigation\View\Helper\NavigationMenu',
        'navigationSitemap'     => 'SpiffyNavigation\View\Helper\NavigationSitemap',
    );

    /**
     * Configure the provided service manager instance with the configuration
     * in this class.
     *
     * Adds the invokables defined in this class to the SM managing helpers.
     *
     * @param  ContainerInterface $container
     * @return void
     */
    public function configureServiceManager(ContainerInterface $container)
    {
        foreach ($this->helpers as $name => $className) {
            $container->setFactory($name, function(ContainerInterface $sm) use ($className) {
                $class = new $className($sm->get('SpiffyNavigation\Service\Navigation'));

                return $class;
            });
        }
    }
}