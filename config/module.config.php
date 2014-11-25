<?php

return array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'UghAuthentication\Controller\Login',
                        'action' => 'index'
                    )
                )
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'UghAuthentication\Controller\Logout',
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            'UghAuthentication\Controller\Login' => 'UghAuthentication\Factory\Controller\LoginControllerFactory',
            'UghAuthentication\Controller\Logout' => 'UghAuthentication\Factory\Controller\LogoutControllerFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'UghAuthentication\Authentication\AuthenticationService' => 'UghAuthentication\Factory\Authentication\AuthenticationService',
            'UghAuthentication\Form\Login' => 'UghAuthentication\Factory\Form\LoginFactory',
            'UghAuthentication\InputFilter\Login' => 'UghAuthentication\Factory\InputFilter\LoginFactory'
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ugh-authentication' => __DIR__ . '/../view'
        )
    )
);
