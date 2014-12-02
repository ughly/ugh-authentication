<?php

namespace UghAuthentication\Authentication;

use UghAuthentication\Authentication\Event\AuthenticationEvent;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\StorageInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerAwareInterface;

class AuthenticationService implements AuthenticationServiceInterface, EventManagerAwareInterface
{

    use \Zend\EventManager\EventManagerAwareTrait;

    /** @var AdapterInterface */
    private $adapter;

    /** @var StorageInterface */
    private $storage;

    /**
     * 
     * @param StorageInterface $storage
     * @param AdapterInterface $adapter
     */
    public function __construct(StorageInterface $storage, AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->storage = $storage;
    }

    /**
     * 
     * @return Result
     */
    public function authenticate()
    {
        $result = $this->adapter->authenticate();

        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }

        if ($result->isValid()) {
            $this->storage->write($result->getIdentity());
            $this->triggerAuthenticationSuccessEvent($result);
        } else {
            $this->triggerAuthenticationFailureEvent($result);
        }

        return $result;
    }

    public function clearIdentity()
    {
        $this->storage->clear();
    }

    public function getIdentity()
    {
        return $this->storage->read();
    }

    /**
     * 
     * @return boolean
     */
    public function hasIdentity()
    {
        return !$this->storage->isEmpty();
    }

    private function triggerAuthenticationSuccessEvent(Result $result)
    {
        $event = new AuthenticationEvent(AuthenticationEvent::AUTHENTICATION_SUCCESS_EVENT, $result);
        $this->triggerAuthenticationEvent($event);
    }

    private function triggerAuthenticationFailureEvent(Result $result)
    {
        $event = new AuthenticationEvent(AuthenticationEvent::AUTHENTICATION_FAILURE_EVENT, $result);
        $this->triggerAuthenticationEvent($event);
    }

    private function triggerAuthenticationEvent(EventInterface $event)
    {
        $this->getEventManager()->trigger($event);
    }
}
