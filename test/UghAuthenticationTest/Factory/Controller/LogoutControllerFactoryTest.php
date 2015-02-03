<?php

namespace UghAuthenticationTest\Factory\Controller;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Controller\LogoutControllerFactory;
use UghAuthentication\Options\ModuleOptions;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class LogoutControllerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $factory = new LogoutControllerFactory();

        $authenticationServiceMock = $this->getMock('Zend\Authentication\AuthenticationServiceInterface');

        $moduleOptions = new ModuleOptions(array('login_route' => 'home'));

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthentication\Authentication\AuthenticationService', $authenticationServiceMock);
        $serviceManager->setService('UghAuthentication\Options\ModuleOptions', $moduleOptions);

        $controllerServiceManager = new ControllerManager();
        $controllerServiceManager->setServiceLocator($serviceManager);

        $logoutController = $factory->createService($controllerServiceManager);

        $this->assertInstanceOf('UghAuthentication\Controller\LogoutController', $logoutController);
    }
}
