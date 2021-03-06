<?php

namespace UghAuthentication\Factory\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Login
 *
 * @package UghAuthentication\Authentication\Factory\InputFilter
 */
class LoginFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return InputFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $username = new Input();
        $username->setName('username');
        $username->setRequired(true);
        $username->setAllowEmpty(false);
        $username->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());

        $password = new Input();
        $password->setName('password');
        $password->setRequired(true);
        $password->setAllowEmpty(false);
        $password->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $password->getValidatorChain()
                ->attach($serviceLocator->get('UghAuthentication\Authentication\Validator\Authentication'));

        $inputFilter = new InputFilter();
        $inputFilter->add($username);
        $inputFilter->add($password);

        return $inputFilter;
    }
}
