<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Stagem
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

namespace Stagem\ZfcSystem\Config\Action\Admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
#use Psr\Http\Server\MiddlewareInterface;
#use Psr\Http\Server\RequestHandlerInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Fig\Http\Message\RequestMethodInterface;

use Popov\ZfcCore\Helper\Config;
use Popov\ZfcForm\FormElementManager;
use Stagem\ZfcPool\PoolHelper;
use Stagem\ZfcPool\Service\PoolService;
use Stagem\ZfcSystem\Config\Form\ConfigForm;
use Stagem\ZfcSystem\Config\Service\SysConfigService;
//use Zend\Expressive\Router\RouteResult;
use Stagem\ZfcSystem\Config\SysConfig;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Router\RouteMatch;
use Zend\Form\FormInterface;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\View\Model\ViewModel;

/**
 * Edit action depends on pool parameter is passed in Url.
 * It doesn't considerate Pool saved to session.
 *
 * @method PoolHelper pool()
 */
class EditAction implements MiddlewareInterface, RequestMethodInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var SysConfig
     */
    protected $sysConfig;

    /**
     * @var PoolHelper
     */
    protected $poolHelper;

    /**
     * @var ConfigForm
     */
    protected $configForm;

    /**
     * @var FormElementManager
     */
    protected $formManager;

    public function __construct(
        //Config $config,
        SysConfig $sysConfig,
        ConfigForm $configForm,
        PoolHelper $poolHelper,
        FormElementManager $formManager
    )
    {
        //$this->config = $config;
        $this->sysConfig = $sysConfig;
        $this->configForm = $configForm;
        $this->poolHelper = $poolHelper;
        $this->formManager = $formManager;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // /admin/config/edit/0/section/design

        /** @var RouteMatch $route */
        $route = $request->getAttribute(RouteMatch::class);

        //$route->getParam($this->config->get('pool/general/url_parameter'), PoolService::POOL_ADMIN);
        $pool = $this->poolHelper->findFromRoute();
        $this->poolHelper->setCurrent($pool);


        //$repository = $this->sysConfigService->getRepository();
        //$sysConfig = $this->sysConfig->getStructuredConfig($this->pool()->current(), $route->getParam('section'));
        $section = $route->getParam('section', SysConfigService::SECTION_DEFAULT);
        $sysConfigService = $this->sysConfig->getSysConfigService();
        $sysConfig = $this->sysConfig->fetchConfig($section, $pool);




        //$form = $this->formManager->get(ConfigForm::class, $this->config['system']['section']['design']);
        /** @var ConfigForm $form */
        //$form = $this->formManager->get(ConfigForm::class, ['pool' => 'default', 'section' => $wildcard['section']]);
        $form = $this->formManager->get(ConfigForm::class, [
            //'pool' => '0',
            // @todo Якщо виникне необхідність замість poolId використовувати code, тоді тут реалізувати перевірку,
            // @todo якщо число int, тоді нічого не змінювати, якщо стрічка, тоді діставати Pool і вже з нього id.
            //'pool' => $route->getParam($this->config->get('pool/general/url_parameter'), PoolService::POOL_ADMIN),
            'pool' => $pool->getId(),
            'section' => $section
        ]);

        //$form->populateValues($sysConfig[$wildcard['section']]);
        $form->populateValues([$section => $sysConfig]);

        if ($request->getMethod() == self::METHOD_POST) {
            $params = $request->getParsedBody();
            $form->setData($params);
            if ($form->isValid()) {
                $data = $form->getData(FormInterface::VALUES_AS_ARRAY);

                unset($data['submit']);
                $sysConfigService->save($data);
                //$om = $this->userService->getObjectManager();
                //$om->persist($user);
                //$om->flush();
                return new RedirectResponse($request->getUri()->getPath());
            }
        }

        $viewModel = new ViewModel(['form' => $form]);

        return $handler->handle($request->withAttribute(ViewModel::class, $viewModel));
    }
}

