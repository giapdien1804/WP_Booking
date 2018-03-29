<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:56 PM
 */

/** @var AdminPageFramework $this */

$fix = 'other_';

$this->addSettingSections(
    [
        'section_id' => $fix . 'social',
        'title' => __('Social', 'gds'),
        'collapsible' => [
            'is_collapsed' => false,
        ],
    ],
    [
        'section_id' => $fix . 'contact',
        'title' => __('Contact', 'gds'),
        'collapsible' => [
            'is_collapsed' => false,
        ],
    ],
    [
        'section_id' => $fix . 'security',
        'title' => __('Security', 'gds'),
        'collapsible' => [
            'is_collapsed' => false,
        ],
    ]
);

$this->addSettingFields(
    $fix . 'social',
    [
        'field_id' => 'line_chat',
        'title' => __('Insert code tag head', 'gds'),
        'type' => 'textarea',
        'attributes' => [
            'style' => 'width: 800px;'
        ]
    ],
    [
        'field_id' => 'code_footer',
        'title' => __('Insert code tag footer', 'gds'),
        'type' => 'textarea',
        'attributes' => [
            'style' => 'width: 800px;'
        ]
    ],
    [
        'field_id' => 'show_line_chat',
        'title' => __('Show code tag head', 'gds'),
        'type' => 'radio',
        'label' => [true => 'Yes', false => 'No']
    ],
    [
        'field_id' => 'facebook',
        'type' => 'text',
        'title' => __('Facebook', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'google',
        'type' => 'text',
        'title' => __('Google', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'twitter',
        'type' => 'text',
        'title' => __('Twitter', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'pinterest',
        'type' => 'text',
        'title' => __('Pinterest', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'tripadvisor',
        'type' => 'textarea',
        'title' => __('Tripadvisor', 'gds'),
        'attributes' => [
            'style' => 'width: 800px;'
        ]

    ]
);

$this->addSettingFields(
    $fix . 'contact',
    [
        'field_id' => 'address',
        'type' => 'text',
        'title' => __('Address', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'phone',
        'type' => 'text',
        'title' => __('Phone', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'email',
        'type' => 'text',
        'title' => __('Email', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'web',
        'type' => 'text',
        'title' => __('Website', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'hotline',
        'type' => 'text',
        'title' => __('Hotline', 'gds'),
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ]
);

$this->addSettingFields(
    $fix . 'security',
    [
        'field_id' => 'google_site',
        'type' => 'text',
        'title' => 'Google captcha site key',
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'google_secret',
        'type' => 'text',
        'title' => 'Google captcha secret key',
        'attributes' => [
            'style' => 'width: 500px;'
        ]
    ],
    [
        'field_id' => 'update_wordpress',
        'title' => __('Update wordpress', 'gds'),
        'type' => 'radio',
        'label' => [true => 'Yes', false => 'No']
    ]
);