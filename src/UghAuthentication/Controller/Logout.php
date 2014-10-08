<?php

namespace UghAuthentication\Controller;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

class Logout extends AbstractActionController
{

    /** @var AuthenticationServiceInterface */
    private $authenticationService;

    /** @var string */
    private $loginRoute = 'login-route';

    /**
     * 
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * 
     * @return Response
     */
    public function indexAction()
    {
        if (!is_null($this->identity())) {
            $this->authenticationService->clearIdentity();
        }

        return $this->redirect()->toRoute($this->loginRoute);
    }

    public function setLoginRoute($loginRoute)
    {
        $this->loginRoute = $loginRoute;
    }
}
