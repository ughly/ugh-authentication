<?php

namespace UghAuthenticationTest\Factory\Options;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Options\ModuleOptionsFactory;
use Zend\ServiceManager\ServiceManager;

class ModuleOptionsFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', array(
            'ugh_authentication' => array()
        ));

        $factory = new ModuleOptionsFactory();
        $moduleOptions = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthentication\Options\ModuleOptions', $moduleOptions);
    }
}
