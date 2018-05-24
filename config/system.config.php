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
    /*<tabs>
        <myconf translate="label">
            <label>My Configuration</label>
            <sort_order>150</sort_order>
        </myconf>
    </tabs>
    <sections>
        <tab1 translate="label" module="adminhtml">
            <label>Tab #1</label>
            <tab>myconf</tab>
            <sort_order>10</sort_order>
            <show_in_default>1</show_in_default>
            <show_in_website>1</show_in_website>
            <show_in_store>1</show_in_store>
            <groups>
                <general translate="label comment">
                    <label>General</label>
                    <sort_order>50</sort_order>
                    <show_in_default>1</show_in_default>
                    <show_in_website>1</show_in_website>
                    <show_in_store>1</show_in_store>
                    <comment><![CDATA[This is a <strong>global comment</strong> about my <em>configuration</em>.<br />You can specify <u>custom html</u> tags. <a href="http://www.bubblecode.net/en" target="_blank">Click here for example!</a>]]></comment>
                    <fields>
                        <text_field translate="label comment">
                            <label>Text Field</label>
                            <comment>Text field with store view scope.</comment>
                            <frontend_type>text</frontend_type>
                            <sort_order>10</sort_order>
                            <show_in_default>1</show_in_default>
                            <show_in_website>1</show_in_website>
                            <show_in_store>1</show_in_store>
                        </text_field>*/
    'tabs' => [
        'general' => [
            'label' => 'General',
            'sort_order' => '10',
        ],
    ],
    'section' => [
        'design' => [
            'tab' => 'general',
            'label' => 'Design',
            'sort_order' => '20',
            'groups' => [
                'general' => [
                    'label' => 'General Information',
                    'sort_order' => '100',
                    //'comment' => 'Settings which will be applied by default for <head> tag',
                    'fields' => [
                        'system_name' => [
                            'label' => 'System Name',
                            'sort_order' => '100',
                            //'comment' => 'System name',
                            'frontend_type' => 'text',
                        ],
                        /*'default_description' => [
                            'label' => 'Default Description',
                            'sort_order' => '90',
                            'comment' => 'Default value for <meta> tag',
                            'frontend_type' => 'text',
                        ],*/
                    ],
                ],
                'head' => [
                    'label' => 'HTML head',
                    'sort_order' => '90',
                    'comment' => 'Settings which will be applied by default for <head> tag',
                    'fields' => [
                        'default_title' => [
                            'label' => 'Default Title',
                            'sort_order' => '100',
                            'comment' => 'Default value for <title> tag',
                            'frontend_type' => 'text',
                        ],
                        'default_description' => [
                            'label' => 'Default Description',
                            'sort_order' => '90',
                            'comment' => 'Default value for <meta> tag',
                            'frontend_type' => 'text',
                        ],
                    ],
                ],
            ],
        ],
    ],
];