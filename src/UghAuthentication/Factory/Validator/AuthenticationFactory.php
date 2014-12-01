<?php

namespace UghAuthentication\Factory\Validator;

use UghAuthentication\Validator\Authentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->get('UghAuthentication\Authentication\AuthenticationService');

        $authenticationValidator = new Authentication();
        $authenticationValidator->setIdentity('username');
        $authenticationValidator->setCredential('password');
        $authenticationValidator->setService($authenticationService);

        return $authenticationValidator;
    }
}
