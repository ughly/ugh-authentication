<?php

namespace UghAuthenticationTest\Controller;

use PHPUnit_Framework_TestCase;
use ReflectionProperty;
use UghAuthentication\Controller\Login;
use Zend\Http\Response;

class LoginTest extends PHPUnit_Framework_TestCase
{

    public function testGetLogin()
    {
        $loginFormMock = $this->getMock('Zend\Form\FormInterface');

        $requestMock = $this->getMock('Zend\Http\Request');
        $requestMock->expects($this->once())->method('isPost')->will($this->returnValue(false));

        $controller = new Login($loginFormMock);

        $this->setReflectionObjectProperty($controller, 'request', $requestMock);

        $result = $controller->indexAction();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertInstanceOf('Zend\Form\FormInterface', $result->getVariable('loginForm'));
    }

    public function testPostInvalidLogin()
    {
        $loginFormMock = $this->getMock('Zend\Form\FormInterface');
        $loginFormMock->expects($this->once())->method('isValid')->will($this->returnValue(false));

        $requestMock = $this->getMock('Zend\Http\Request');
        $requestMock->expects($this->once())->method('isPost')->will($this->returnValue(true));

        $controller = new Login($loginFormMock);

        $this->setReflectionObjectProperty($controller, 'request', $requestMock);

        $controller->indexAction();
    }

    public function testPostValidLogin()
    {
        $loginFormMock = $this->getMock('Zend\Form\FormInterface');
        $loginFormMock->expects($this->once())->method('isValid')->will($this->returnValue(true));

        $requestMock = $this->getMock('Zend\Http\Request');
        $requestMock->expects($this->once())->method('isPost')->will($this->returnValue(true));

        $redirectMock = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect');
        $redirectMock->expects($this->once())->method('toRoute')->will($this->returnValue(new Response()));

        $pluginManagerMock = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));
        $pluginManagerMock->expects($this->once())->method('get')->will($this->returnValue($redirectMock));

        $controller = new Login($loginFormMock);
        $controller->setLoginRedirectRoute('my-crazy-login-redirect-route');
        $controller->setPluginManager($pluginManagerMock);

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
}
