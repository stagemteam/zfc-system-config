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

use Popov\ZfcForm\FormElementManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\RequestMethodInterface;
use Stagem\ZfcSystem\Config\Form\ConfigForm;
use Stagem\ZfcSystem\Config\Model\Config;
use Stagem\ZfcSystem\Config\Service\SysConfigService;
use Zend\Expressive\Router\RouteResult;
use Zend\Form\FormInterface;
use Zend\View\Model\ViewModel;

class EditAction implements MiddlewareInterface, RequestMethodInterface
{
    /**
     * @var SysConfigService
     */
    protected $sysConfigService;

    /**
     * @var ConfigForm
     */
    protected $configForm;

    protected $formManager;

    protected $config;

    public function __construct(SysConfigService $sysConfigService, FormElementManager $formManager, ConfigForm $configForm, array $config)
    {
        $this->sysConfigService = $sysConfigService;
        $this->formManager = $formManager;
        $this->configForm = $configForm;
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $request->getAttribute(RouteResult::class);

        /** @var User $user */
        $more = explode('/', $route->getMatchedParams()['more']);
        $wildcard = [];
        $count = count($more);
        for ($i = 0; $i < $count; $i = $i + 2) {
            $wildcard[$more[$i]] = $more[$i + 1];
        }


        //$repository = $this->sysConfigService->getRepository();
        $sysConfig = $this->sysConfigService->getStructuredConfig($wildcard['section'] . '/%');

        //$form = $this->formManager->get(ConfigForm::class, $this->config['system']['section']['design']);
        /** @var ConfigForm $form */
        $form = $this->formManager->get(ConfigForm::class, ['scope' => 'default', 'section' => $wildcard['section']]);

        //$form->populateValues($sysConfig[$wildcard['section']]);
        $form->populateValues($sysConfig);

        if ($request->getMethod() == self::METHOD_POST) {
            $params = $request->getParsedBody();
            $form->setData($params);
            if ($form->isValid()) {
                $data = $form->getData(FormInterface::VALUES_AS_ARRAY);

                unset($data['submit']);
                $this->sysConfigService->save($data);
                //$om = $this->userService->getObjectManager();
                //$om->persist($user);
                //$om->flush();
            }
        }

        $viewModel = new ViewModel(['form' => $form]);

        return $handler->handle($request->withAttribute(ViewModel::class, $viewModel));
    }
}

