<?php

namespace UghAuthenticationTest\Authentication\Adapter;

use PHPUnit_Framework_TestCase;
use Zend\Authentication\Result;

class AdapterTest extends PHPUnit_Framework_TestCase
{

    public function testAdapterSuccessor()
    {
        $invalidResult = new Result(0, 'test');

        $invalidAdapterMock = $this->getMockBuilder('UghAuthentication\Authentication\Adapter\Adapter', array('doAuthentication'))->disableOriginalConstructor()->getMockForAbstractClass();
        $invalidAdapterMock->expects($this->once())->method('doAuthentication')->will($this->returnValue($invalidResult));

        $validResult = new Result(1, 'test');
        $validAdapterMock = $this->getMockBuilder('UghAuthentication\Authentication\Adapter\Adapter', array('authenticate'))->disableOriginalConstructor()->getMockForAbstractClass();
        $validAdapterMock->expects($this->once())->method('doAuthentication')->will($this->returnValue($validResult));

        $invalidAdapterMock->setSuccessor($validAdapterMock);

        $invalidAdapterMock->authenticate();
    }

    public function testAdapterSuccessorDoesntGetCalledOnValidResult()
    {
        $validResult = new Result(1, 'test');

        $firstValidAdapterMock = $this->getMockBuilder('UghAuthentication\Authentication\Adapter\Adapter', array('doAuthentication'))->disableOriginalConstructor()->getMockForAbstractClass();
        $firstValidAdapterMock->expects($this->once())->method('doAuthentication')->will($this->returnValue($validResult));


        $secondValidAdapterMock = $this->getMockBuilder('UghAuthentication\Authentication\Adapter\Adapter', array('authenticate'))->disableOriginalConstructor()->getMockForAbstractClass();
        $secondValidAdapterMock->expects($this->never())->method('doAuthentication');

        $firstValidAdapterMock->setSuccessor($secondValidAdapterMock);

        $firstValidAdapterMock->authenticate();
    }
}
