<?php

namespace UghAuthenticationTest\Controller;

use PHPUnit_Framework_TestCase;
use ReflectionProperty;
use UghAuthentication\Controller\Login;
use Zend\Http\Response;

class LoginTest extends PHPUnit_Framework_TestCase
{

    public $identityExists = false;

    public function testGetLogin()
    {
        $loginFormMock = $this->getMock('Zend\Form\FormInterface');

        $controller = new Login($loginFormMock);

        $pluginManagerMock = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManagerMock->expects($this->any())->method('get')->will($this->returnCallback(array($this, 'getPluginMockCallback')));

        $controller->setPluginManager($pluginManagerMock);

        $requestMock = $this->getMock('Zend\Http\Request');
        $requestMock->expects($this->once())->method('isPost')->will($this->returnValue(false));

        $this->setReflectionObjectProperty($controller, 'request', $requestMock);

        $result = $controller->indexAction();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertInstanceOf('Zend\Form\FormInterface', $result->getVariable('loginForm'));
    }

    public function testGetLoginRedirectsExistingIdentity()
    {
        $this->identityExists = true;

        $loginFormMock = $this->getMock('Zend\Form\FormInterface');

        $controller = new Login($loginFormMock);
        $controller->setLoginRedirectRoute('my-crazy-login-redirect-route');

        $pluginManagerMock = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManagerMock->expects($this->any())->method('get')->will($this->returnCallback(array($this, 'getPluginMockCallback')));

        $controller->setPluginManager($pluginManagerMock);

        $requestMock = $this->getMock('Zend\Http\Request');
        $requestMock->expects($this->never())->method('isPost')->will($this->returnValue(false));

        $this->setReflectionObjectProperty($controller, 'request', $requestMock);

        $result = $controller->indexAction();

        $this->assertInstanceOf('Zend\Http\Response', $result);
    }

    public function testPostInvalidLogin()
    {
        $loginFormMock = $this->getMock('Zend\Form\FormInterface');
        $loginFormMock->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $requestMock = $this->getMock('Zend\Http\Request');
        $requestMock->expects($this->once())->method('isPost')->will($this->returnValue(true));

        $controller = new Login($loginFormMock);

        $pluginManagerMock = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManagerMock->expects($this->any())->method('get')->will($this->returnCallback(array($this, 'getPluginMockCallback')));

        $controller->setPluginManager($pluginManagerMock);

        $this->setReflectionObjectProperty($controller, 'request', $requestMock);

        $controller->indexAction();
    }

    public function testPostValidLogin()
    {
        $loginFormMock = $this->getMock('Zend\Form\FormInterface');
        $loginFormMock->expects($this->once())->method('isValid')->will($this->returnValue(true));

        $controller = new Login($loginFormMock);
        $controller->setLoginRedirectRoute('my-crazy-login-redirect-route');

        $pluginManagerMock = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManagerMock->expects($this->any())->method('get')->will($this->returnCallback(array($this, 'getPluginMockCallback')));

        $controller->setPluginManager($pluginManagerMock);

        $requestMock = $this->getMock('Zend\Http\Request');
        $requestMock->expects($this->once())->method('isPost')->will($this->returnValue(true));

        $this->setReflectionObjectProperty($controller, 'request', $requestMock);

        $result = $controller->indexAction();

        $this->assertInstanceOf('Zend\Http\Response', $result);
    }

    private function setReflectionObjectProperty($object, $property, $value)
    {
        $reflectionProperty = new ReflectionProperty($object, $property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
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
            throw new \Exception('No plugin mock was provided');
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
