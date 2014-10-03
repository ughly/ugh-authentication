<?php

namespace UghAuthentication\Authentication;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\StorageInterface;

class AuthenticationService implements AuthenticationServiceInterface
{

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
}
