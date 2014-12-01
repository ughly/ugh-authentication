<?php

namespace UghAuthenticationTest\Authentication\Form;

use PHPUnit_Framework_TestCase;
use UghAuthentication\Form\Login;

class LoginTest extends PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $loginForm = new Login();

        $loginForm->init();

        $elements = $loginForm->getElements();

        $this->assertArrayHasKey('username', $elements);
        $this->assertArrayHasKey('password', $elements);
        $this->assertArrayHasKey('security', $elements);
        $this->assertArrayHasKey('submit', $elements);
    }
}
