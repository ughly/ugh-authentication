<?php

namespace UghAuthentication\Factory\Controller;

use UghAuthentication\Controller\LogoutController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogoutControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceManager = $serviceLocator->getServiceLocator();

        $authenticationService = $serviceManager->get('UghAuthentication\Authentication\AuthenticationService');

        $moduleOptions = $serviceLocator->getServiceLocator()->get('UghAuthentication\Options\ModuleOptions');

        $controller = new LogoutController($authenticationService);
        $controller->setLoginRoute($moduleOptions->getLoginRoute());

        return $controller;
    }
}
