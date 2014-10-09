<?php

namespace UghAuthenticationTest\Factory\Controller;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Controller\LogoutControllerFactory;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class LogoutControllerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $factory = new LogoutControllerFactory();

        $authenticationServiceMock = $this->getMock('Zend\Authentication\AuthenticationServiceInterface');

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthentication\Authentication\AuthenticationService', $authenticationServiceMock);

        $controllerServiceManager = new ControllerManager();
        $controllerServiceManager->setServiceLocator($serviceManager);

        $logoutController = $factory->createService($controllerServiceManager);

        $this->assertInstanceOf('UghAuthentication\Controller\LogoutController', $logoutController);
    }
}
