<?php

namespace UghAuthenticationTest\Controller;

use Exception;
use PHPUnit_Framework_TestCase;
use UghAuthentication\Controller\Logout;
use Zend\Http\Response;

class LogoutTest extends PHPUnit_Framework_TestCase
{

    public $identityExists = false;

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

    public function getPluginMockCallback()
    {
        $args = func_get_args();

        $pluginName = $args[0];

        if ($pluginName == 'redirect') {
            $pluginMock = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect');
            $pluginMock->expects($this->once())->method('toRoute')->will($this->returnValue(new Response()));
        } elseif ($pluginName == 'identity') {
            $pluginMock = $this->getMock('Zend\Mvc\Controller\Plugin\Identity');
            $pluginMock->expects($this->once())->method('__invoke')->will($this->returnValue($this->getIdentityPluginMockResponse()));
        } else {
            throw new Exception('No plugin mock was provided');
        }

        return $pluginMock;
    }

    public function getIdentityPluginMockResponse()
    {
        if ($this->identityExists) {
            return array();
        }

        return null;
    }
}
