<?php

namespace UghAuthenticationTest\Factory\Controller;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Controller\LoginControllerFactory;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class LoginControllerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $factory = new LoginControllerFactory();

        $loginFormMock = $this->getMock('Zend\Form\FormInterface');

        $formElementManager = new \Zend\Form\FormElementManager();
        $formElementManager->setService('UghAuthentication\Form\Login', $loginFormMock);

        $serviceManager = new ServiceManager();
        $serviceManager->setService('FormElementManager', $formElementManager);

        $controllerServiceManager = new ControllerManager();
        $controllerServiceManager->setServiceLocator($serviceManager);

        $loginController = $factory->createService($controllerServiceManager);

        $this->assertInstanceOf('UghAuthentication\Controller\LoginController', $loginController);
    }
}
