<?php

namespace UghAuthentication\Factory\Authentication;

use UghAuthentication\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationStorageAdapter = $serviceLocator->get('UghAuthentication\Authentication\Storage');
        $authenticationAdapter = $serviceLocator->get('UghAuthentication\Authentication\Adapter');
        return new AuthenticationService($authenticationStorageAdapter, $authenticationAdapter);
    }
}
