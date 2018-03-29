<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:55 PM
 */

/** @var AdminPageFramework $this */
$fix = 'booking_';

$this->addSettingFields(
    [
        'field_id' => $fix . 'price',
        'type' => 'inline_mixed',
        'title' => __('Price', 'gds'),
        'content' => [
            [
                'field_id' => 'unit',
                'type' => 'text',
                'label_min_width' => '',
                'title' => __('Unit', 'gds'),
                'attributes' => [
                    'fieldset' => [
                        'style' => 'margin-right:50px'
                    ]
                ],
                'default' => '$'
            ],
            [
                'field_id' => 'position',
                'type' => 'radio',
                'label_min_width' => '',
                'title' => __('Position', 'gds'),
                'label' => ['left' => 'Left', 'right' => 'right'],
                'default' => 'left',
                'attributes' => [
                    'fieldset' => [
                        'style' => 'margin-right:50px'
                    ]
                ],
                'after_label' => '<br />',
            ],
            [
                'field_id' => 'space',
                'type' => 'text',
                'label_min_width' => '',
                'title' => __('Space', 'gds')
            ],
            [
                'field_id' => 'code_book',
                'type' => 'text',
                'label_min_width' => '',
                'title' => __('Code book', 'gds')
            ],
        ]
    ],
    [
        'field_id' => $fix . 'page',
        'type' => 'inline_mixed',
        'title' => __('Page', 'gds'),
        'content' => [
            [
                'field_id' => 'booking',
                'type' => 'select',
                'label_min_width' => '',
                'title' => __('Booking', 'gds'),
                'label' => LIP::get_page_list()
            ],
            [
                'field_id' => 'return',
                'type' => 'select',
                'label_min_width' => '',
                'title' => __('Return paypal', 'gds'),
                'label' => LIP::get_page_list()
            ],
            [
                'field_id' => 'onepay',
                'type' => 'select',
                'label_min_width' => '',
                'title' => __('Return onepay', 'gds'),
                'label' => LIP::get_page_list()
            ],
            [
                'field_id' => 'credit',
                'type' => 'select',
                'label_min_width' => '',
                'title' => __('Return credit card', 'gds'),
                'label' => LIP::get_page_list()
            ],
            [
                'field_id' => 'save_database',
                'type' => 'select',
                'label_min_width' => '',
                'title' => __('Return payment', 'gds'),
                'label' => LIP::get_page_list()
            ],
            [
                'field_id' => 'contact',
                'type' => 'select',
                'label_min_width' => '',
                'title' => __('Contact', 'gds'),
                'label' => LIP::get_page_list()
            ],
            [
                'field_id' => 'tailor_made',
                'type' => 'select',
                'label_min_width' => '',
                'title' => __('Tailor made', 'gds'),
                'label' => LIP::get_page_list()
            ],
            [
                'field_id' => 'hidden_payment',
                'title' => __('Hidden payment', 'gds'),
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No']
            ],
        ]
    ],
    [
        'field_id' => 'term_and_condition',
        'type' => 'textarea',
        'title' => __('Term and condition', 'gds'),
        'rich' => true,
        'attributes' => [
            'field' => [
                'style' => 'width: 1000px;'
            ],
        ],
    ],
    [
        'field_id' => $fix . 'email',
        'title' => __('Email', 'gds'),
        'content' => [
            [
                'field_id' => 'global',
                'type' => 'text',
                'label' => __('Global', 'gds'),
                'attributes' => [
                    'style' => 'width:300px;'
                ],
                'default' => 'info@' . str_replace('www.', '', $_SERVER['SERVER_NAME'])
            ],
            [
                'field_id' => 'cc',
                'type' => 'text',
                'label' => __('CC', 'gds'),
                'attributes' => [
                    'style' => 'width:300px;'
                ],
                'default' => 'sales@' . str_replace('www.', '', $_SERVER['SERVER_NAME'])
            ],
            [
                'field_id' => 'bcc',
                'type' => 'text',
                'label' => __('BCC', 'gds'),
                'attributes' => [
                    'style' => 'width:300px;'
                ],
                'default' => 'haonguyen@7gmt.com'
            ],
        ]
    ],
    [
        'field_id' => $fix . 'paypal',
        'title' => __('Paypal', 'gds'),
        'content' => [
            [
                'field_id' => 'show_paypal',
                'title' => __('Show payment', 'gds'),
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No']
            ],
            [
                'field_id' => 'email',
                'type' => 'text',
                'label' => __('Email', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'surcharge',
                'type' => 'text',
                'label' => __('Surcharge', 'gds'),
            ]
        ]
    ],
    [
        'field_id' => $fix . 'onepay',
        'title' => __('Onepay', 'gds'),
        'content' => [
            [
                'field_id' => 'show_onepay',
                'title' => __('Show payment', 'gds'),
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No']
            ],
            [
                'field_id' => 'email',
                'type' => 'text',
                'label' => __('Email', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'surcharge',
                'type' => 'text',
                'label' => __('Surcharge', 'gds'),
            ],
            [
                'field_id' => 'merchant',
                'type' => 'text',
                'label' => __('Merchant', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'accessCode',
                'type' => 'text',
                'label' => __('Access Code', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'secureSecret',
                'type' => 'text',
                'label' => __('Secure secret', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ]
        ]
    ],
    [
        'field_id' => $fix . 'credit_card',
        'title' => __('Credit Card', 'gds'),
        'content' => [
            [
                'field_id' => 'show_credit_card',
                'title' => __('Show payment', 'gds'),
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No']
            ],
            [
                'field_id' => 'access_key',
                'type' => 'text',
                'label' => __('Access key', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'profile_id',
                'type' => 'text',
                'label' => __('Profile id', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'secret_key',
                'type' => 'text',
                'label' => __('Secret Key', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'url_credit',
                'type' => 'text',
                'label' => __('Url credit', 'gds'),
                'attributes' => [
                    'style' => 'width: 450px;'
                ]
            ],
            [
                'field_id' => 'surcharge',
                'type' => 'text',
                'label' => __('Surcharge', 'gds'),
            ],
        ]
    ]
);
