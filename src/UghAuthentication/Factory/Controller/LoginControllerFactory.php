<?php

namespace UghAuthentication\Factory\Controller;

use UghAuthentication\Controller\LoginController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $formElementManager = $serviceLocator->getServiceLocator()->get('FormElementManager');
        $loginForm = $formElementManager->get('UghAuthentication\Form\Login');

        $moduleOptions = $serviceLocator->getServiceLocator()->get('UghAuthentication\Options\ModuleOptions');

        $controller = new LoginController($loginForm);
        $controller->setLoginRedirectRoute($moduleOptions->getLoginRedirectRoute());

        return $controller;
    }
}
