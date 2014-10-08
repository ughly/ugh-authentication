<?php

namespace UghAuthenticationTest\Controller;

use UghAuthentication\Controller\Logout;

class LogoutTest extends AbstractControllerTestCaseTest
{

    public function testGetLogoutRedirectsToLoginRoute()
    {
        $authenticationServiceMock = $this->getMock('Zend\Authentication\AuthenticationServiceInterface');

        $controller = new Logout($authenticationServiceMock);
        $controller->setLoginRoute('my-crazy-login-route');

        $pluginManagerMock = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManagerMock->expects($this->any())->method('get')->will($this->returnCallback(array($this, 'getPluginMockCallback')));

        $controller->setPluginManager($pluginManagerMock);

        $result = $controller->indexAction();

        $this->assertInstanceOf('Zend\Http\Response', $result);
    }

    public function testGetLogoutClearsExistingIdentityAndRedirectsToLoginRoute()
    {
        $this->identityExists = true;

        $authenticationServiceMock = $this->getMock('Zend\Authentication\AuthenticationServiceInterface');
        $authenticationServiceMock->expects($this->once())->method('clearIdentity');

        $controller = new Logout($authenticationServiceMock);

        $pluginManagerMock = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManagerMock->expects($this->any())->method('get')->will($this->returnCallback(array($this, 'getPluginMockCallback')));

        $controller->setPluginManager($pluginManagerMock);

        $result = $controller->indexAction();

        $this->assertInstanceOf('Zend\Http\Response', $result);
    }
}
