<?php

namespace UghAuthenticationTest\Factory\Controller;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Controller\LoginControllerFactory;
use UghAuthentication\Options\ModuleOptions;
use Zend\Form\FormElementManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

class LoginControllerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $factory = new LoginControllerFactory();

        $loginFormMock = $this->getMock('Zend\Form\FormInterface');

        $formElementManager = new FormElementManager();
        $formElementManager->setService('UghAuthentication\Form\Login', $loginFormMock);

        $moduleOptions = new ModuleOptions(array('login_redirect_route' => 'admin'));

        $serviceManager = new ServiceManager();
        $serviceManager->setService('FormElementManager', $formElementManager);
        $serviceManager->setService('UghAuthentication\Options\ModuleOptions', $moduleOptions);

        $controllerServiceManager = new ControllerManager();
        $controllerServiceManager->setServiceLocator($serviceManager);

        $loginController = $factory->createService($controllerServiceManager);

        $this->assertInstanceOf('UghAuthentication\Controller\LoginController', $loginController);
    }
}
