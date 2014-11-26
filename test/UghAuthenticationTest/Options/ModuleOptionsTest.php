<?php

namespace UghAuthentication\Options;

use PHPUnit_Framework_TestCase;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{

    public function testCanLoadOptions()
    {
        $moduleOptions = new ModuleOptions(array(
            'login_route' => 'login',
            'login_redirect_route' => 'admin'
        ));

        $this->assertEquals('login', $moduleOptions->getLoginRoute());
        $this->assertEquals('admin', $moduleOptions->getLoginRedirectRoute());
    }
}
