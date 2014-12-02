<?php

namespace UghAuthentication\Authentication\Event;

use Zend\EventManager\Event;

class AuthenticationEvent extends Event
{

    const AUTHENTICATION_SUCCESS_EVENT = "authentication.success";
    const AUTHENTICATION_FAILURE_EVENT = "authentication.failure";

}
