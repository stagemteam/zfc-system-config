<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */
return [
    'tabs' => [
        'myconf' => [
            'label' => 'My Configuration',
            'sort_order' => '150',
            'translate' => 'label',
        ],
    ],
    'sections' => [
        'tab1' => [ // in most cases you should use module name in lowercase but it isn't required
            'label' => 'Tab #1',
            'tab' => 'myconf',
            'sort_order' => '10',
            #'show_in_default' => '1',
            #'show_in_website' => '1',
            #'show_in_store' => '1',
            #'translate' => 'label',
            #'module' => 'adminhtml',
            'groups' => [
                'general' => [
                    'label' => 'General',
                    'sort_order' => '50',
                    #'comment' => 'This is a <strong>global comment</strong> about my <em>configuration</em>.<br>You can specify <u>custom html</u> tags. <a href="/">Click here for example!</a>',
                    #'translate' => ['label', 'comment'],
                    'fields' => [
                        'text_field' => [
                            'label' => 'Text Field',
                            'frontend_type' => 'text',
                            'sort_order' => '10',
                            #'comment' => 'Text field with store view scope.',
                            ##'translate' => ['label', 'comment'],
                        ],
                        'textarea' => [
                            'label' => 'Textarea',
                            'frontend_type' => 'textarea',
                            'sort_order' => '20',
                            #'comment' => 'Textarea with store view scope.',
                            #'translate' => ['label', 'comment'],
                        ],
                        'dropdown' => [
                            #'label' => 'Dropdown',
                            #'comment' => 'Dropdown with global scope.',
                            #'frontend_type' => 'select',
                            #'source_model' => 'jr_customconfigexample/system_config_source_dropdown_values',
                            #'sort_order' => '30',
                            #'translate' => ['label', 'comment'],
                        ],
                        'multiple_dropdown' => [
                            #'label' => 'Multiselect',
                            #'comment' => 'Multiselect with global scope.',
                            #'frontend_type' => 'multiselect',
                            #'source_model' => 'jr_customconfigexample/system_config_source_dropdown_values',
                            #'sort_order' => '40',
                            #'translate' => ['label', 'comment'],
                        ],
                        'file' => [
                            #'label' => 'File',
                            #'comment' => 'File saved in <strong><span style="color: red;">var/uploads</span></strong> folder.',
                            #'frontend_type' => 'file',
                            #'backend_model' => 'adminhtml/system_config_backend_file',
                            #'upload_dir' => 'var/uploads',
                            #'sort_order' => '50',
                            #'translate' => ['label', 'comment'],
                        ],
                        'time' => [
                            #'label' => 'Time',
                            #'frontend_type' => 'time',
                            #'sort_order' => '52',
                            #'translate' => ['label', 'comment'],
                        ],
                        'active' => [
                            #'label' => 'Enable/Disable',
                            #'frontend_type' => 'select',
                            #'sort_order' => '54',
                            #'source_model' => 'adminhtml/system_config_source_enabledisable',
                            #'translate' => ['label', 'comment'],
                        ],
                        'heading_example' => [
                            #'label' => 'Heading example',
                            #'frontend_model' => 'adminhtml/system_config_form_field_heading',
                            #'sort_order' => '55',
                            #'translate' => ['label'],
                        ],
                        'boolean' => [
                            #'label' => 'Boolean',
                            #'comment' => 'Boolean with website scope and dependant fields when Yes is selected.',
                            #'frontend_type' => 'select',
                            #'source_model' => 'adminhtml/system_config_source_yesno',
                            #'sort_order' => '60',
                            #'translate' => ['label', 'comment'],
                        ],
                        'dependant_text_field' => [
                            #'label' => 'Dependant Text Field',
                            #'comment' => 'This field depends of boolean value above.',
                            #'frontend_type' => 'text',
                            #'sort_order' => '70',
                            #'translate' => ['label', 'comment'],
                            #'depends' => [
                            #    'boolean' => '1',
                            #],
                        ],
                    ],
                ],
            ],
        ],
    ],
];