<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 6/7/2016
 * Time: 9:52 AM
 */

/** @var AdminPageFramework $this */

$fix = 'style_';

$content = [
    [
        'field_id' => 'text',
        'type' => 'color',
        'label_min_width' => '',
        'title' => __('Text', 'gds')
    ],
    [
        'field_id' => 'background',
        'type' => 'color',
        'label_min_width' => '',
        'title' => __('Background', 'gds')
    ],
    [
        'field_id' => 'font',
        'type' => 'select',
        'label_min_width' => '',
        'title' => __('Font', 'gds'),
        'label' => [
            'Serif Fonts' => [
                '"Times New Roman", Times, serif' => '"Times New Roman", Times, serif',
                'Georgia, serif' => 'Georgia, serif',
                '"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif'
            ],
            'Sans-Serif Fonts' => [
                'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
                '"Arial Black", Gadget, sans-serif' => '"Arial Black", Gadget, sans-serif',
                '"Comic Sans MS", cursive, sans-serif' => '"Comic Sans MS", cursive, sans-serif',
                'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
                '"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
                'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
                '"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif'
            ],
            'Monospace Fonts' => [
                '"Courier New", Courier, monospace' => '"Courier New", Courier, monospace',
                '"Lucida Console", Monaco, monospace' => '"Lucida Console", Monaco, monospace'
            ]
        ]
    ],
    [
        'field_id' => 'size',
        'type' => 'number',
        'label_min_width' => '',
        'title' => __('Size', 'gds'),
        /* 'attributes' => array(
             'style' => 'width: 40px',
         ),*/
        'default' => 16
    ],
    [
        'field_id' => 'image',
        'type' => 'image',
        'title' => __('Image', 'gds'),
        'attributes' => [
            'fieldset' => [
                'style' => 'padding-right: 11%;',
            ],
        ],
        'show_preview' => false
    ],
    [
        'field_id' => 'repeat',
        'type' => 'select',
        'title' => 'Repeat',
        'label' => LIP::repeat_list()
    ],
];

$styleList = ['header', 'content', 'heading', 'sidebar_content', 'sidebar_heading', 'footer', 'footer', 'top_menu', 'main_menu', 'footer_menu'];

foreach ($styleList as $name) {
    $this->addSettingField(
        [
            'field_id' => $fix . $name,
            'title' => __(ucfirst(str_replace('_', ' ', $name)), 'gds'),
            'type' => 'inline_mixed',
            'content' => $content
        ]
    );
}

$tagList = ['row_title' => 'div', 'heading' => 'h2', 'sidebar_heading' => 'h2', 'single_page_title' => 'h1', 'category_page_title' => 'h1', 'home_item_title' => 'h2', 'category_item_title' => 'h2', 'sidebar_item_title' => 'h3'];
$this->addSettingSection(
    [
        'section_id' => $fix . 'html_tag',
        'title' => __('HTML tag', 'gds'),
        'collapsible' => array(
            'is_collapsed' => false,
        ),
    ]
);

foreach ($tagList as $name => $value) {
    $this->addSettingFields(
        $fix . 'html_tag',
        [
            'field_id' => $name,
            'type' => 'select',
            'title' => __(ucfirst(str_replace('_', ' ', $name)), 'gds'),
            'label' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'p' => 'P', 'div' => 'DIV'],
            'default' => $value
        ],
        [
            'field_id' => $name . '_class',
            'type' => 'text',
            'title' => __(ucfirst(str_replace('_', ' ', $name)) . ' class', 'gds'),
            'default' => ''
        ]
    );
}


