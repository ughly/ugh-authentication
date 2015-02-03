<?php

namespace UghAuthenticationTest\Authentication\Validator;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Authentication\Validator\Authentication;
use Zend\Authentication\Result;

class AuthenticationTest extends PHPUnit_Framework_TestCase
{

    public function testOptions()
    {
        $authenticationServiceMock = $this->getMock('UghAuthentication\Authentication\AuthenticationServiceInterface');

        $authenticationValidator = new Authentication(array(
            'service' => $authenticationServiceMock,
            'identity' => 'username',
            'credential' => 'password',
        ));
        $this->assertSame($authenticationValidator->getService(), $authenticationServiceMock);
        $this->assertSame($authenticationValidator->getIdentity(), 'username');
        $this->assertSame($authenticationValidator->getCredential(), 'password');
    }

    public function testSetters()
    {
        $authenticationServiceMock = $this->getMock('UghAuthentication\Authentication\AuthenticationServiceInterface');

        $authenticationValidator = new Authentication();

        $authenticationValidator->setService($authenticationServiceMock);
        $authenticationValidator->setIdentity('username');
        $authenticationValidator->setCredential('credential');
        $this->assertSame($authenticationValidator->getService(), $authenticationServiceMock);
        $this->assertSame($authenticationValidator->getIdentity(), 'username');
        $this->assertSame($authenticationValidator->getCredential(), 'credential');
    }

    public function testNoIdentityThrowsRuntimeException()
    {
        $authenticationValidator = new Authentication();
        $authenticationValidator->setCredential('credential');

        $this->setExpectedException('RuntimeException', 'Identity must be set prior to validation');
        $authenticationValidator->isValid('password');
    }

    public function testNoServiceThrowsRuntimeException()
    {
        $authenticationValidator = new Authentication();
        $authenticationValidator->setIdentity('username');
        $authenticationValidator->setCredential('credential');

        $this->setExpectedException('RuntimeException', 'AuthenticationService must be set prior to validation');
        $authenticationValidator->isValid('password');
    }

    public function testEqualsMessageTemplates()
    {
        $authenticationServiceMock = $this->getMock('UghAuthentication\Authentication\AuthenticationServiceInterface');

        $authenticationValidator = new Authentication();

        $authenticationValidator->setService($authenticationServiceMock);
        $authenticationValidator->setIdentity('username');
        $authenticationValidator->setCredential('credential');

        $this->assertAttributeEquals($authenticationValidator->getOption('messageTemplates'), 'messageTemplates', $authenticationValidator);
    }

    public function testWithoutContext()
    {
        $authenticationResult = new Result(Result::SUCCESS, 'username');

        $authenticationServiceMock = $this->getMock('UghAuthentication\Authentication\AuthenticationServiceInterface');
        $authenticationServiceMock->expects($this->once())->method('authenticate')->will($this->returnValue($authenticationResult));

        $authenticationValidator = new Authentication();

        $authenticationValidator->setService($authenticationServiceMock);
        $authenticationValidator->setIdentity('username');
        $authenticationValidator->setCredential('credential');

        $this->assertEquals('username', $authenticationValidator->getIdentity());
        $this->assertEquals('credential', $authenticationValidator->getCredential());
        $this->assertTrue($authenticationValidator->isValid());
    }

    public function testWithContext()
    {
        $authenticationResult = new Result(Result::SUCCESS, 'username');

        $authenticationServiceMock = $this->getMock('UghAuthentication\Authentication\AuthenticationServiceInterface');
        $authenticationServiceMock->expects($this->once())->method('authenticate')->will($this->returnValue($authenticationResult));

        $authenticationValidator = new Authentication();

        $authenticationValidator->setService($authenticationServiceMock);
        $authenticationValidator->setIdentity('username');

        $result = $authenticationValidator->isValid('password', array(
            'username' => 'myusername',
            'password' => 'mypassword',
        ));

        $this->assertTrue($result);
    }

    /**
     * 
     * @dataProvider authenticationValidationMessages
     */
    public function testErrorMessages($errorCode, $errorKey, $errorMessage)
    {
        $authenticationResult = new Result($errorCode, 'testuser');

        $authenticationServiceMock = $this->getMock('UghAuthentication\Authentication\AuthenticationServiceInterface');
        $authenticationServiceMock->expects($this->once())->method('authenticate')->will($this->returnValue($authenticationResult));

        $authenticationValidator = new Authentication();

        $authenticationValidator->setService($authenticationServiceMock);
        $authenticationValidator->setIdentity('username');

        $result = $authenticationValidator->isValid();

        $this->assertFalse($result);
        $authenticationValidationMessages = $authenticationValidator->getMessages();
        $this->assertSame($errorMessage, $authenticationValidationMessages[$errorKey]);
    }

    public function authenticationValidationMessages()
    {
        return array(
            array(
                'code' => 0,
                'key' => 'general',
                'message' => 'Authentication failed'
            ),
            array(
                'code' => -1,
                'key' => 'identityNotFound',
                'message' => 'Invalid identity'
            ),
            array(
                'code' => -2,
                'key' => 'identityAmbiguous',
                'message' => 'Identity is ambiguous'
            ),
            array(
                'code' => -3,
                'key' => 'credentialInvalid',
                'message' => 'Invalid password'
            ),
            array(
                'code' => -4,
                'key' => 'uncategorized',
                'message' => 'Authentication failed'
            )
        );
    }
}
