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

namespace StagemTest\ZfcSystem\Form;


use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Zend\Form\Fieldset;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Stagem\ZfcSystem\Config\Form\ConfigForm;

class ConfigFormTest extends MockeryTestCase
{
    public function testFieldCreating()
    {
        $fieldsConfig = [
            'fields' => [
                'default_title' => [
                    'label' => 'Default Title',
                    'sort_order' => '10',
                    'comment' => 'Test comment',
                    'frontend_type' => 'text',
                ],
            ],
        ];
        $form = new ConfigForm('sys-config');
        $fieldset = new Fieldset();
        $form->buildElements($fieldset, $fieldsConfig['fields']);

        $field = $fieldset->get('default_title');

        $this->assertInstanceOf(Text::class, $field);
        $this->assertEquals('default_title', $field->getName());
        $this->assertEquals(['comment' => 'Test comment', 'label' => 'Default Title'], $field->getOptions());
    }

    public function testMultipleFieldsCreating()
    {
        $fieldsConfig = [
            'fields' => [
                'default_title' => [
                    'label' => 'Default Title',
                    'frontend_type' => 'text',
                ],
                'default_description' => [
                    'label' => 'Default Description',
                    'frontend_type' => 'textarea',
                ],
            ],
        ];
        $form = new ConfigForm('sys-config');
        $fieldset = new Fieldset();
        $form->buildElements($fieldset, $fieldsConfig['fields']);

        $field = $fieldset->get('default_description');
        $this->assertCount(2, $fieldset->getElements());
        $this->assertInstanceOf(Textarea::class, $field);
        $this->assertEquals('default_description', $field->getName());
    }

    public function testFormCreating()
    {
        $groupConfig = [
            'groups' => [
                'head' => [
                    'label' => 'HTML head',
                    'sort_order' => '10',
                    'comment' => 'Test Group Comment',
                    'fields' => [
                        'default_title' => [
                            'label' => 'Default Title',
                            'frontend_type' => 'text'
                        ]
                    ]
                ]
            ],
        ];

        $form = new ConfigForm('sys-config', $groupConfig);
        $form->init();
        $fieldset = $form->get('head');

        $this->assertEquals('head', $fieldset->getName());
        $this->assertEquals('HTML head', $fieldset->getLabel());
        $this->assertInstanceOf(Fieldset::class, $fieldset);
        $this->assertCount(1, $fieldset->getElements());
        $this->assertEquals(['label' => 'HTML head', 'comment' => 'Test Group Comment'], $fieldset->getOptions());

        $field = $fieldset->get('default_title');
        $this->assertInstanceOf(Text::class, $field);
        $this->assertEquals('default_title', $field->getName());
    }
}