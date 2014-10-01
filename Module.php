<?php

namespace UghAuthentication;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        /* @var \Zend\Mvc\Application $application */
        $application = $e->getTarget();
        $serviceManager = $application->getServiceManager();
        $eventManager = $application->getEventManager();

    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
