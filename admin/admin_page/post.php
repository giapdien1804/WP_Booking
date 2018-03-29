<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:55 PM
 */

/** @var AdminPageFramework $this */

$fix = 'post_';
$postTypeList = LIP::get_post_type_list();
unset($postTypeList['post']);

$this->addSettingFields(
    [
        'field_id' => $fix . 'enable',
        'type' => 'checkbox',
        'title' => __('Enable post type', 'gds'),
        'label' => $postTypeList
    ],
    [
        'field_id' => $fix . 'show_label',
        'type' => 'text',
        'title' => __('Show label list', 'gds'),
        'attributes' => [
            'style' => 'width:500px'
        ],
        'default' => 'feature=>Feature,best_sale=>Best sale,best_price=>Best price,top_10=>Top 10,top_20=>Top 20,top_30=>Top 30'
    ],
    [
        'field_id' => $fix . 'get_list_page',
        'type' => 'text',
        'title' => __('Get list page', 'gds'),
        'attributes' => [
            'style' => 'width:500px'
        ],
    ],
    [
        'field_id' => $fix . 'tour_price_max',
        'type' => 'text',
        'title' => __('Price max', 'gds'),
        'default' => tour_meta::price_range()->max,
        'attributes' => [
            'disabled' => 'disabled'
        ],
    ],
    [
        'field_id' => $fix . 'get_price_search',
        'type' => 'text',
        'title' => __('Show price search', 'gds'),
        'attributes' => [
            'style' => 'width:500px'
        ],
        'default' => '0-100=>0 - 100 USD,100-250=>100 - 250 USD,250-500=>250 - 500 USD,500-1000=> 500 - 1000 USD'
    ]
);

foreach ($postTypeList as $typeName => $label) {
    $this->addSettingSection(
        [
            'section_id' => $fix . $typeName,
            'title' => __($label, 'gds'),
            'description' => __(ucfirst($label) . ' setting'),
            'collapsible' => [
                'is_collapsed' => false,
            ],
        ]
    );
}

$page_option = [
    'field_id' => 'page',
    'type' => 'select',
    'title' => 'Page',
    'label' => LIP::get_page_list()
];

$this->addSettingFields(
    $fix . 'location',
    [
        'field_id' => 'gmap_api_key',
        'type' => 'text',
        'title' => __('Google map API key', 'gds'),
        'default' => 'AIzaSyCzcWKEuil9jsPKBLddkAdVtaZIK7I9nB8'
    ],
    $page_option
);

$default_tour = ['star' => 3, 'per_book' => 3, 'pick_up' => 10, 'min_qty' => 2, 'max_qty' => 20];
$content_df = [];

foreach ($default_tour as $name => $value) {
    $content_df[] = [
        'field_id' => $name,
        'type' => 'text',
        'label_min_width' => '',
        'label' => __(ucfirst(str_replace('_', ' ', $name)), 'gds'),
        'attributes' => [
            'style' => 'width:40px;',
            'fieldset' => array(
                'style' => 'margin-right: 7%;',
            ),
        ],
        'default' => $value
    ];
}

$this->addSettingFields(
    $fix . 'tour',
    [
        'field_id' => 'duration_list',
        'type' => 'text',
        'title' => __('Duration list', 'gds'),
        'attributes' => [
            'style' => 'width:500px'
        ],
        'default' => '2-hours,3-hours,Half-day,1-day,<<2~20.-days>>'
    ],
    [
        'field_id' => 'default_value',
        'type' => 'inline_mixed',
        'title' => 'Default value',
        'content' => $content_df
    ],
    $page_option

);

$this->addSettingFields(
    $fix . 'service',
    [
        'field_id' => 'duration_list',
        'type' => 'text',
        'title' => __('Duration list', 'gds'),
        'attributes' => [
            'style' => 'width:500px'
        ],
        'default' => 'Round trip'
    ],
    [
        'field_id' => 'default_value',
        'type' => 'inline_mixed',
        'title' => 'Default value',
        'content' => $content_df
    ],
    $page_option
);