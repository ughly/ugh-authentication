<?php
namespace UghAuthenticationTest\Factory\InputFilter;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Factory\InputFilter\LoginFactory;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManager;

class LoginFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testInputFilterFactory()
    {

        $authenticationAdapterMock = $this->getMock('Zend\Authentication\Adapter\ValidatableAdapterInterface');

        $adapterMock = $this->getMock('Zend\Authentication\Adapter\AdapterInterface');
        $storageMock = $this->getMock('Zend\Authentication\Storage\StorageInterface');

        $authenticationService = new AuthenticationService($storageMock, $adapterMock);

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthentication\Authentication\Adapter', $authenticationAdapterMock);
        $serviceManager->setService('UghAuthentication\Authentication\AuthenticationService', $authenticationService);

        $inputFilterFactory = new LoginFactory();
        $inputFilter = $inputFilterFactory->createService($serviceManager);
        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
    }

}
