<?php

namespace UghAuthenticationTest\Factory\Authentication;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\Authentication\AuthenticationServiceFactory;
use Zend\ServiceManager\ServiceManager;

class AuthenticationServiceFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $factory = new AuthenticationServiceFactory();

        $authenticationStorageAdapterMock = $this->getMock('Zend\Authentication\Storage\StorageInterface');
        $authenticationAdapterMock = $this->getMock('Zend\Authentication\Adapter\AdapterInterface');

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthentication\Authentication\Storage', $authenticationStorageAdapterMock);
        $serviceManager->setService('UghAuthentication\Authentication\Adapter', $authenticationAdapterMock);

        $authenticationService = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthentication\Authentication\AuthenticationService', $authenticationService);
    }
}
