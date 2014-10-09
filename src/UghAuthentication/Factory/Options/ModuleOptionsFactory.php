<?php

namespace UghAuthentication\Factory\Options;

use UghAuthentication\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $ughAuthenticationConfig = $config['ugh_authentication'];

        $moduleOptions = new ModuleOptions($ughAuthenticationConfig);

        return $moduleOptions;
    }
}
