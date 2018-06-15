# ZF System Config
Creating of this module is inspired by Magento System Configuration.
Magento has great config structure for extend configuration and this in most cases don't require any programming skills.

Now this module has bare minimum for creating config in own project.
At this moment many features aren't implemented yet. Feel free for contributing.

## Self-explain config structure
By default ZF uses array config structure. This module works in a similar way.
We recommend to create custom `system.config.php` under your module structure and place this file near `config/module.config.php`.

The commented lines have not yet been implemented.
```php
// src/Your/Module/config/module.config.php
return [
    'system' => require 'system.config.php',
];
```

```php
// src/Your/Module/config/system.config.php
return [
    'tabs' => [
        'myconf' => [
            'label' => 'My Configuration',
            'sort_order' => '150',
            'translate' => 'label',
        ],
    ],
    'sections' => [
        'tab1' => [
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
```

## Usage
You can use `sysConfig` view helper for access config
```php
<?= $this->sysConfig('tab1/general/text_field') ?>
<?= $this->sysConfig('design/head/default_title') ?>
```