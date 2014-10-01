<?php

return array(
    'ugh_authorization' => array(
    ),
    'controllers' => array(
        'invokables' => array(
            'UghAuthentication' => '\UghAuthentication\Controller\AuthenticationController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
        )
    ),
    'view_manager' => array(
        'template_map' => array(
        )
    ),
    'router' => array(
        'routes' => array(
            'ughauthentication' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'ughauthentication',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'ughauthentication',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'ughauthentication',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
