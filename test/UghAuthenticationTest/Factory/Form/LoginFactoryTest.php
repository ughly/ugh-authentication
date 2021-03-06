<?php

namespace UghAuthenticationTest\Factory\Form;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Form\LoginFactory;
use Zend\Form\FormElementManager;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceManager;

class LoginFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthentication\InputFilter\Login', new InputFilter());

        $formServiceManager = new FormElementManager();
        $formServiceManager->setServiceLocator($serviceManager);
        $factory = new LoginFactory();
        $inputFilter = $factory->createService($formServiceManager);

        $this->assertInstanceOf('UghAuthentication\Form\Login', $inputFilter);
    }
}
