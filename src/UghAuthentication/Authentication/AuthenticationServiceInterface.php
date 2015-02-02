<?php

namespace UghAuthentication\Authentication;

use Zend\Authentication\AuthenticationServiceInterface as ZendAuthenticationServiceInterface;

interface AuthenticationServiceInterface extends ZendAuthenticationServiceInterface
{

    public function setIdentity($identity);

    public function setCredential($credential);
}
