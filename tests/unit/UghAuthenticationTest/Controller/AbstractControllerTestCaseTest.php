<?php

namespace UghAuthenticationTest\Controller;

use Exception;
use PHPUnit_Framework_TestCase;
use Zend\Http\Response;

abstract class AbstractControllerTestCaseTest extends PHPUnit_Framework_TestCase
{

    public $identityExists = false;

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
