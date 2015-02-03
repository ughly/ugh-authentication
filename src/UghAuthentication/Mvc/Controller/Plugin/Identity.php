<?php

namespace UghAuthentication\Mvc\Controller\Plugin;

use UghAuthentication\Authentication\AuthenticationServiceInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Exception\RuntimeException;

class Identity extends AbstractPlugin
{

    /**
     * @var AuthenticationServiceInterface
     */
    protected $authenticationService;

    /**
     * @return AuthenticationServiceInterface
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function setAuthenticationService(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Retrieve the current identity, if any.
     *
     * If none is present, returns null.
     *
     * @return mixed|null
     * @throws RuntimeException
     */
    public function __invoke()
    {
        if (!$this->authenticationService instanceof AuthenticationServiceInterface) {
            throw new RuntimeException('No AuthenticationService instance provided');
        }
        if (!$this->authenticationService->hasIdentity()) {
            return null;
        }
        return $this->authenticationService->getIdentity();
    }
}
