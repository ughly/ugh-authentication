<?php

namespace UghAuthentication\Form;

use Zend\Form\Form;

/**
 * Class Login
 * @package UghAuthentication\Form\Login
 */
class Login extends Form
{

    /**
     *
     */
    public function init()
    {
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'id' => 'username',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'id' => 'password',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'security',
            'type' => 'Zend\Form\Element\Csrf',
            'attributes' => array(
                'id' => 'csrf'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Submit'
            ),
        ));
    }

}
