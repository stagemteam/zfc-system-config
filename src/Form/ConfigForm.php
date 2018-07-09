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
 * @package Stagem_ZfcSystem
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config\Form;

use Stagem\ZfcPool\Service\PoolService;
use Stagem\ZfcSystem\Config\Service\SysConfigService;
use Stagem\ZfcSystem\Config\SysConfig;
use Zend\Form\Exception\InvalidArgumentException;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\TranslatorAwareTrait;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;


class ConfigForm extends Form implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    protected $sysConfig;

    /*public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);
    }*/

    public function setSysConfig($config)
    {
        $this->sysConfig = $config;

        return $this;
    }

    public function getConfigGroups()
    {
        if (!isset($this->sysConfig['sections'][$this->getOptions()['section']]['groups'])) {
            throw new InvalidArgumentException(sprintf(
                'System configuration for "%s" not found. Check if you create relative config in your module',
                $this->getOptions()['section']
            ));
        }
        $groups = $this->sysConfig['sections'][$this->getOptions()['section']]['groups'];

        return $groups;
    }

    public function getPool()
    {
        return $this->getOptions()['pool'];
    }

    public function init()
    {
        //$this->setName('config');
        //$this->setAttributes(['id' => $this->getName() . '-form', 'class' => 'ajax form-inline']);

        /*
         'section' => [
            'design' => [
                'tab' => 'general',
                'label' => 'Design',
                'sort_order' => '20',
                'groups' => [
                    'head' => [
                        'label' => 'HTML head',
                        'sort_order' => '10',
                        'comment' => 'Settings which will be applied by default for <head> tag',
                        'fields' => [
                            'default_title' => [
                                'label' => 'Default Title',
                                'sort_order' => '10',
                                'comment' => 'Default value for <title> tag',
                                'frontend_type' => 'text'
                            ]
                        ]
                    ]
                ],
            ]
        ]
         */

        $fieldset = $this->add([
            'name' => $this->getOptions()['section'],
            'type' => Fieldset::class,
            'options' => [
                'use_as_base_fieldset' => true,
                'label' => ucfirst($this->getOptions()['section']),
            ],
        ])->get($this->getOptions()['section']);

        $configGroups = $this->getConfigGroups();
        foreach ($configGroups as $name => $group) {
            $sub = $fieldset->add([
                'name' => $name,
                'type' => Fieldset::class,
                //'label' => $group['label']
                #'options' => [
                #    'use_as_base_fieldset' => true,
                #],
            ], ['priority' => $group['sort_order'] ?? null])->get($name);
            $this->prepareConfig($sub, $group);
            $this->buildElements($sub, $group['fields']);
        }

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Save',
                'class' => 'btn btn-primary',
                //'data-group-id' => 'keys',
            ],
        ]);
    }

    public function buildElements($fieldset, $fields)
    {
        /**
        'fields' => [
        'default_title' => [
            'label' => 'Default Title',
            'sort_order' => '10',
            'comment' => 'Default value for <title> tag',
            'frontend_type' => 'text'
        ]
        ]
         */
        foreach ($fields as $name => $field) {
            $sub = $fieldset->add([
                'name' => $name,
                'type' => Fieldset::class,
                //'label' => $group['label']
                'options' => [
                    #'use_as_base_fieldset' => true,
                    #'label' => ucfirst($name)
                    'inline' => true,
                ],
            ], ['priority' => $field['sort_order'] ?? null])->get($name);

            $sub->add([
                'name' => 'id',
                'type' => 'hidden'
            ]);
            $sub->add([
                'name' => 'poolId',
                'type' => 'hidden',
                'attributes' => [
                    // Set default pool value. If there is other value it will be override on populateValues()
                    'value' => $this->getPool()
                ]
            ]);

            $element = $sub->add([
                'name' => 'value',
                'type' => $field['frontend_type'],
                'options' => [
                    //'label' => 'Use Default',
                ],
            ])->get('value');

            if (PoolService::POOL_ADMIN !== $this->getPool()) {
                $sub->add([
                    'name' => 'inherit',
                    'type' => 'checkbox',
                    'options' => [
                        'label' => 'Use Default',
                    ],
                    //'attributes' => [
                        //'class' => 'form-control'
                        //'checked' => true
                    //],
                ]);
            }

            $field['column'] = 6;

            $this->prepareConfig($element, $field);
        }
    }

    protected function prepareConfig($element, $config)
    {
        //unset($config['label']);
        unset($config['frontend_type']);
        unset($config['groups']);
        unset($config['fields']);
        unset($config['sort_order']);
        $element->setOptions($config);
    }

    /*public function populateValues($data)
    {
        parent::populateValues($data);
    }*/
}