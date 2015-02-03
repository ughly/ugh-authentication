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
    'controller_plugins' => array(
        'factories' => array(
            'identity' => 'UghAuthentication\Factory\Mvc\Controller\Plugin\IdentityFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'UghAuthentication\Authentication\AuthenticationService' => 'UghAuthentication\Factory\Authentication\AuthenticationServiceFactory',
            'UghAuthentication\InputFilter\Login' => 'UghAuthentication\Factory\InputFilter\LoginFactory',
            'UghAuthentication\Validator\Authentication' => 'UghAuthentication\Factory\Validator\AuthenticationFactory'
        ),
        'invokables' => array(
            'UghAuthentication\Authentication\Storage' => 'Zend\Authentication\Storage\Session'
        )
    ),
    'form_elements' => array(
        'factories' => array(
            'UghAuthentication\Form\Login' => 'UghAuthentication\Factory\Form\LoginFactory'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'ugh-authentication/login/index' => __DIR__ . '/../view/ugh-authentication/login/index.phtml'
        ),
        'template_path_stack' => array(
            'ugh-authentication' => __DIR__ . '/../view'
        )
    )
);
