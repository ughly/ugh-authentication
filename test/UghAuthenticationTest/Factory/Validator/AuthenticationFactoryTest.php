<?php

namespace UghAuthenticationTest\Factory\Validator;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Validator\AuthenticationFactory;
use Zend\ServiceManager\ServiceManager;

class AuthenticationFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $authenicationServiceMock = $this->getMock('UghAuthentication\Authentication\AuthenticationServiceInterface');

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthentication\Authentication\AuthenticationService', $authenicationServiceMock);

        $authenticationValidatorFactory = new AuthenticationFactory();

        $authenticationValidator = $authenticationValidatorFactory->createService($serviceManager);

        $this->assertInstanceOf('Zend\Validator\AbstractValidator', $authenticationValidator);
    }
}
