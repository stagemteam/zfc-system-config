<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Stagem Team
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_ZfcSystem
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config;

use Popov\ZfcCurrent\CurrentHelper;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        $config = require __DIR__ . '/../config/module.config.php';
        $config['service_manager'] = $config['dependencies'];
        unset($config['dependencies']);

        return $config;
    }

    /*public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $container = $e->getApplication()->getServiceManager();

        $routePluginManager = $container->get('RoutePluginManager');

        // Allow to replace services
        $routePluginManager->setAllowOverride(true);

        // @see https://olegkrivtsov.github.io/using-zend-framework-3-book/html/en/Website_Operation/Service_Manager.html
        // We use this hardcode such as we cannot set mapping on config file level.
        // This method override any configuration (@see Zend\Router\Http\TreeRouteStack::init())
        $routePluginManager->setAlias('wildcard', Wildcard::class);
        $routePluginManager->setAlias('Wildcard', Wildcard::class);
        $routePluginManager->setAlias('wildCard', Wildcard::class);
        $routePluginManager->setAlias('WildCard', Wildcard::class);

        $routePluginManager->setAllowOverride(false);
    }*/

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $sharedEvents = $eventManager->getSharedManager();

        //$moduleRouteListener = new ModuleRouteListener();
        //$moduleRouteListener->attach($eventManager);

        // Register the event listener method
        $sharedEvents->attach(AbstractController::class, MvcEvent::EVENT_DISPATCH, [$this, 'handleRender'], 500);
        // @todo Attach to $eventManager on MvcEvent::EVENT_RENDER
        //$eventManager->attach(/*AbstractController::class, */MvcEvent::EVENT_RENDER, [$this, 'handleRender']);

        #$eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'handleDispatch']);
        #$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleError']);
    }

    public function handleRender(MvcEvent $e)
    {
        $container = $e->getApplication()->getServiceManager();

        /** @var CurrentHelper $currentHelper */
        //$currentHelper = $container->get(CurrentHelper::class);
        $currentHelper = $container->get(CurrentHelper::class);
/*
        'view_manager' => [
            'display_not_found_reason' => true,
            'display_exceptions' => true,
            'doctype' => 'HTML5',
            'not_found_template' => 'error/404',
            'exception_template' => 'error/index',
            'template_map' => [
                'layout::admin' => __DIR__ . '/../view/layout/admin.phtml',*/

        if ('sys-config' === $currentHelper->currentController()) {
            #$config = $container->get('config');
            #$config['view_manager']['template_map']['widget::menu'] = __DIR__ . '/../view/admin/widget/left-menu.phtml';
            #$container->setAllowOverride(true);
            #$container->setService('config', $config);
            #$container->setAllowOverride(false);

            $mapResolver = $container->get('ViewTemplateMapResolver');
            $mapResolver->add('admin::widget/menu', __DIR__ . '/../view/admin/widget/left-menu.phtml');
        }

    }
}