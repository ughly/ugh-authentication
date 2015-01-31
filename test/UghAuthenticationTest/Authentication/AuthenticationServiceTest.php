<?php

namespace UghAuthenticationTest\Authentication;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Authentication\AuthenticationService;
use UghAuthentication\Authentication\Event\AuthenticationEvent;
use Zend\EventManager\EventManager;

class AuthenticationServiceTest extends PHPUnit_Framework_TestCase
{

    public function testValidAuthentication()
    {
        $identity = array('username' => 'test');

        $authenticationResultMock = $this->getMockBuilder('Zend\Authentication\Result', array('getIdentity', 'isValid'))->disableOriginalConstructor()->getMock();
        $authenticationResultMock->expects($this->once())->method('getIdentity')->will($this->returnValue($identity));
        $authenticationResultMock->expects($this->once())->method('isValid')->will($this->returnValue(true));

        $authenticationAdapterMock = $this->getMockBuilder('Zend\Authentication\Adapter\AdapterInterface', array('authenticate'))->disableOriginalConstructor()->getMock();
        $authenticationAdapterMock->expects($this->once())->method('authenticate')->will($this->returnValue($authenticationResultMock));

        $storageMock = $this->getMockBuilder('Zend\Authentication\Storage\StorageInterface', array('isEmpty', 'read', 'write', 'clear'))->disableOriginalConstructor()->getMock();
        $storageMock->expects($this->once())->method('isEmpty')->will($this->returnValue(true));
        $storageMock->expects($this->once())->method('write');
        $storageMock->expects($this->once())->method('read')->will($this->returnValue($identity));

        $authSuccessfulEventTriggered = false;

        $eventManager = new EventManager();
        $eventManager->attach(AuthenticationEvent::AUTHENTICATION_SUCCESS_EVENT, function () use (&$authSuccessfulEventTriggered) {
            $authSuccessfulEventTriggered = true;
        });

        $authenticationService = new AuthenticationService($storageMock, $authenticationAdapterMock);
        $authenticationService->setEventManager($eventManager);

        $authenticationService->authenticate();

        $this->assertSame($identity, $authenticationService->getIdentity());

        $this->assertTrue($authSuccessfulEventTriggered);
    }

    public function testInvalidAuthentication()
    {

        $authenticationResultMock = $this->getMockBuilder('Zend\Authentication\Result', array('getIdentity', 'isValid'))->disableOriginalConstructor()->getMock();
        $authenticationResultMock->expects($this->never())->method('getIdentity');
        $authenticationResultMock->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $authenticationAdapterMock = $this->getMockBuilder('Zend\Authentication\Adapter\AdapterInterface', array('authenticate'))->disableOriginalConstructor()->getMock();
        $authenticationAdapterMock->expects($this->once())->method('authenticate')->will($this->returnValue($authenticationResultMock));

        $storageMock = $this->getMockBuilder('Zend\Authentication\Storage\StorageInterface', array('isEmpty', 'read', 'write', 'clear'))->disableOriginalConstructor()->getMock();
        $storageMock->expects($this->once())->method('isEmpty')->will($this->returnValue(true));
        $storageMock->expects($this->never())->method('write');
        $storageMock->expects($this->never())->method('read');

        $authFailEventTriggered = false;

        $eventManager = new EventManager();
        $eventManager->attach(AuthenticationEvent::AUTHENTICATION_FAILURE_EVENT, function () use (&$authFailEventTriggered) {
            $authFailEventTriggered = true;
        });

        $authenticationService = new AuthenticationService($storageMock, $authenticationAdapterMock);
        $authenticationService->setEventManager($eventManager);

        $authenticationService->authenticate();

        $this->assertTrue($authFailEventTriggered);
    }

    public function testAuthenticationClearsExistingIdentity()
    {
        $identity = array('username' => 'test');

        $authenticationResultMock = $this->getMockBuilder('Zend\Authentication\Result', array('getIdentity', 'isValid'))->disableOriginalConstructor()->getMock();
        $authenticationResultMock->expects($this->once())->method('getIdentity')->will($this->returnValue($identity));
        $authenticationResultMock->expects($this->once())->method('isValid')->will($this->returnValue(true));

        $authenticationAdapterMock = $this->getMockBuilder('Zend\Authentication\Adapter\AdapterInterface', array('authenticate'))->disableOriginalConstructor()->getMock();
        $authenticationAdapterMock->expects($this->once())->method('authenticate')->will($this->returnValue($authenticationResultMock));

        $storageMock = $this->getMockBuilder('Zend\Authentication\Storage\StorageInterface', array('isEmpty', 'write', 'clear'))->disableOriginalConstructor()->getMock();
        $storageMock->expects($this->once())->method('isEmpty')->will($this->returnValue(false));
        $storageMock->expects($this->once())->method('write');
        $storageMock->expects($this->once())->method('clear');

        $authenticationService = new AuthenticationService($storageMock, $authenticationAdapterMock);
        $authenticationService->authenticate();
    }
}
