<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_System
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config\View\Helper;

use Popov\ZfcCore\Helper\Config;
use Popov\ZfcCore\Helper\UrlHelper;
use Popov\ZfcCurrent\CurrentHelper;
use Stagem\ZfcPool\Service\PoolService;
use Stagem\ZfcSystem\Config\Service\SysConfigService;
use Zend\View\Helper\AbstractHelper;
use Stagem\ZfcSystem\Config\SysConfig;

class SysConfigHelper extends AbstractHelper
{
    /**
     * @var SysConfig
     */
    protected $sysConfig;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * @var CurrentHelper
     */
    protected $currentHelper;

    protected $isActive = [];

    public function __construct(Config $config, SysConfig $sysConfig, CurrentHelper $currentHelper, UrlHelper $urlHelper)
    {
        $this->config = $config;
        $this->sysConfig = $sysConfig;
        $this->currentHelper = $currentHelper;
        $this->urlHelper = $urlHelper;
    }

    public function get($path)
    {
        return $this->sysConfig->get($path);
    }

    public function render()
    {
        //$systemConfig = $this->sysConfig->getSysConfigService()->getSystemConfig();
        $routeParams = $this->currentHelper->currentRouteParams();
        $sectionParam = $routeParams['section'] ?? SysConfigService::SECTION_DEFAULT;
        $systemConfig = $this->config->get('system');

        $tabs = [];
        foreach ($systemConfig['sections'] as $sectionKey => $sectionConfig) {
            $this->isActive[$sectionConfig['tab']] = ($sectionParam === $sectionKey);
            $html = $this->renderItem($sectionKey, $sectionConfig, false);
            $tabs[$sectionConfig['tab']][] = $html;
        }

        $html = '';
        foreach ($systemConfig['tabs'] as $tabKey => $tabConfig) {
            $isActive = $this->isActive[$tabKey];
            $html .= '<li>';
            $html .= sprintf('<a href="#" class="%s">%s</a>', $isActive ? 'active-a' : '', $tabConfig['label']);
            $html .= '<span class="figure arrow-up"></span>';
            $html .= sprintf('<ul class="level-%s %s">%s</ul>'
                , $level = 2
                , $this->isActive ? 'active-ul' : ''
                , implode("\n", $tabs[$tabKey])
            );
            $html .= '</li>';
        }
        $html = '<ul class="level-1">' . $html . '</ul>';

        return $html;
    }

    public function renderItem($code, $config, $hasChildren = false)
    {
        $routeParams = $this->currentHelper->currentRouteParams();
        $poolUrlParam = $this->config->get('pool/general/url_parameter');
        $poolIdentifier = $routeParams[$poolUrlParam] ?? PoolService::POOL_ADMIN;
        $urlParams = [
            'controller' => 'sys-config',
            'action' => 'edit',
            'section' => $code,
            $poolUrlParam => $poolIdentifier,
        ];
        $url = $hasChildren ? '#' : $this->urlHelper->generate('admin/default/wildcard', $urlParams);
        $html = sprintf('<li><a href="%s">%s</a></li>', $url, $config['label']);

        return $html;
    }

    public function __invoke()
    {
        $args = func_get_args();
        if (!$args) {
            return $this;
        }
        $path = $args[0];

        return $this->get($path);
    }
}