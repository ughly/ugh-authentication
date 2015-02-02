<?php

namespace UghAuthentication\Authentication\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;

abstract class Adapter extends AbstractAdapter
{

    /** @var ValidatableAdapterInterface */
    private $successor;

    /**
     * 
     * @return Result
     */
    public function authenticate()
    {
        $result = $this->doAuthentication();

        if (!$result->isValid() && !is_null($this->successor)) {
            $this->successor->setIdentity($this->getIdentity());
            $this->successor->setCredential($this->getCredential());
            return $this->successor->authenticate();
        }

        return $result;
    }

    /**
     * 
     * @param ValidatableAdapterInterface $successor
     */
    public function setSuccessor(AdapterInterface $successor)
    {
        $this->successor = $successor;
    }

    /**
     * @return Result
     */
    abstract protected function doAuthentication();
}
