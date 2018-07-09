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
     * @var SysConfig
     */
    protected $sysConfig;

    /**
     * @var ConfigForm
     */
    protected $configForm;

    protected $formManager;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(
        Config $config,
        SysConfig $sysConfig,
        FormElementManager $formManager,
        ConfigForm $configForm
    )
    {
        $this->config = $config;
        $this->sysConfig = $sysConfig;
        $this->formManager = $formManager;
        $this->configForm = $configForm;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // /admin/config/edit/0/section/design

        $route = $request->getAttribute(RouteMatch::class);

        /** @var User $user */
        //$more = explode('/', $route->getMatchedParams()['more']);
        /*$more = $route->getMatchedParams()['more'];
        $wildcard = [];
        $count = count($more);
        for ($i = 0; $i < $count; $i = $i + 2) {
            $wildcard[$more[$i]] = $more[$i + 1];
        }*/

        // If "section" key work is not preset than should be taken first default
        #if (!isset($route->getMatchedParams()['section'])) {
        #    throw new InvalidArgumentException('Key word "section" must be preset in route.');
        #}

        //$repository = $this->sysConfigService->getRepository();
        //$sysConfig = $this->sysConfig->getStructuredConfig($this->pool()->current(), $route->getParam('section'));
        $sysConfigService = $this->sysConfig->getSysConfigService();
        $sysConfig = $this->sysConfig->fetchConfig($route->getParam('section'));


        //$form = $this->formManager->get(ConfigForm::class, $this->config['system']['section']['design']);
        /** @var ConfigForm $form */
        //$form = $this->formManager->get(ConfigForm::class, ['pool' => 'default', 'section' => $wildcard['section']]);
        $form = $this->formManager->get(ConfigForm::class, [
            //'pool' => '0',
            // @todo Якщо виникне необхідність замість poolId використовувати code, тоді тут реалізувати перевірку,
            // @todo якщо число int, тоді нічого не змінювати, якщо стрічка, тоді діставати Pool і вже з нього id.
            'pool' => $route->getParam($this->config->get('pool/general/url_parameter'), PoolService::POOL_ADMIN),
            'section' => $route->getParam('section', SysConfigService::SECTION_DEFAULT)
        ]);

        //$form->populateValues($sysConfig[$wildcard['section']]);
        $form->populateValues($sysConfig);

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

