<?php

namespace UghAuthentication\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

abstract class Adapter implements AdapterInterface
{

    /** @var AdapterInterface */
    private $successor;

    /**
     * 
     * @return Result
     */
    public function authenticate()
    {
        $result = $this->doAuthentication();

        if (!$result->isValid()) {
            return $this->successor->authenticate();
        }

        return $result;
    }

    /**
     * 
     * @param AdapterInterface $successor
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
