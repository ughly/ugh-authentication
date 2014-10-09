<?php

namespace UghAuthentication\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    private $loginRoute;
    private $loginRedirectRoute;

    public function getLoginRoute()
    {
        return $this->loginRoute;
    }

    public function getLoginRedirectRoute()
    {
        return $this->loginRedirectRoute;
    }

    public function setLoginRoute($loginRoute)
    {
        $this->loginRoute = $loginRoute;
    }

    public function setLoginRedirectRoute($loginRedirectRoute)
    {
        $this->loginRedirectRoute = $loginRedirectRoute;
    }
}
