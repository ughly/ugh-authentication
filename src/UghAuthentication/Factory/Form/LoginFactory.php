<?php

namespace UghAuthentication\Factory\Form;

use UghAuthentication\Form\Login as LoginForm;
use Zend\Form\FormInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Login
 *
 * @package UghAuthentication\Factory\Form
 */
class LoginFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LoginForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $inputFilter = $serviceLocator->getServiceLocator()->get('UghAuthentication\InputFilter\Login');

        $form = new LoginForm();
        $form->setInputFilter($inputFilter);
        $form->setValidationGroup(FormInterface::VALIDATE_ALL);

        return $form;
    }
}
