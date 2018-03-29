<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 4:42 PM
 */

/** @var AdminPageFramework $this */
$fix = 'option_';

$this->addSettingFields(
    [
        'field_id' => $fix . 'logo',
        'title' => __('Logo and favicon', 'gds'),
        'content' => [
            [
                'field_id' => 'header_logo',
                'type' => 'image',
                'title' => __('Header logo', 'gds')
            ],
            [
                'field_id' => 'footer_logo',
                'type' => 'image',
                'title' => __('Footer logo', 'gds')
            ],
            [
                'field_id' => 'favicon',
                'type' => 'image',
                'title' => __('Favicon', 'gds')
            ]
        ]
    ],
    [
        'field_id' => $fix . 'text',
        'title' => 'Text description',
        'content' => [
            [
                'field_id' => 'header',
                'type' => 'textarea',
                'title' => __('Header text', 'gds'),
                'rich' => [
                    'media_buttons' => false,
                    'tinymce' => false
                ],
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ]
            ],
            [
                'field_id' => 'header_bg',
                'type' => 'image',
                'label' => __('Background', 'gds')
            ],
            [
                'field_id' => 'box_contact_us',
                'type' => 'textarea',
                'title' => __('Box contact', 'gds'),
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ]
            ],
            [
                'field_id' => 'content_bg',
                'type' => 'image',
                'label' => __('Background', 'gds')
            ],
            [
                'field_id' => 'footer',
                'type' => 'textarea',
                'title' => __('Footer text', 'gds'),
                'rich' => [
                    'media_buttons' => false,
                    'tinymce' => false
                ],
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ]
            ],
            [
                'field_id' => 'footer_bg',
                'type' => 'image',
                'label' => __('Background', 'gds')
            ],
            [
                'field_id' => 'show_boder',
                'title' => __('Show border', 'gds'),
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No']
            ],
        ]
    ],
    [
        'field_id' => $fix . 'other',
        'title' => __('Other', 'gds'),
        'content' => [
            [
                'field_id' => 'copy_of',
                'type' => 'text',
                'title' => __('Copy of', 'gds'),
                'attributes' => [
                    'style' => 'width: 900px;'
                ]
            ],
            [
                'field_id' => 'payment',
                'type' => 'inline_mixed',
                'content' => [
                    [
                        'field_id' => 'image',
                        'type' => 'image',
                        'label_min_width' => '',
                        'title' => __('Payment image', 'gds'),
                        'attributes' => [
                            'fieldset' => [
                                'style' => 'padding-right: 11%;',
                            ],
                        ],
                        'show_preview' => false
                    ],
                    [
                        'field_id' => 'link',
                        'type' => 'text',
                        'label_min_width' => '',
                        'title' => __('Payment link', 'gds')
                    ]
                ],
                'repeatable' => true
            ],
            [
                'field_id' => 'payment_icon',
                'title' => __('Show payment icon', 'gds'),
                'label' => [true => 'Yes', false => 'No'],
                'type' => 'radio'
            ]
        ]
    ]
);