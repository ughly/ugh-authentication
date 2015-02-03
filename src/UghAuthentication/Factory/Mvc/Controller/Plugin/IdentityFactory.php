<?php

namespace UghAuthentication\Factory\Mvc\Controller\Plugin;

use UghAuthentication\Mvc\Controller\Plugin\Identity;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IdentityFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        $helper = new Identity();
        if ($services->has('UghAuthentication\Authentication\AuthenticationService')) {
            $helper->setAuthenticationService($services->get('UghAuthentication\Authentication\AuthenticationService'));
        }
        return $helper;
    }
}
