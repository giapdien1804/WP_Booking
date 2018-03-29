<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:55 PM
 */

/** @var AdminPageFramework $this */

$fix = 'home_';

$this->addSettingSections(
    [
        'section_id' => $fix . 'extra',
        'title' => __('Extra', 'gds'),
        'collapsible' => [
            'is_collapsed' => true,
        ]
    ],
    [
        'section_id' => $fix . 'slide',
        'title' => __('Slide', 'gds'),
        'collapsible' => [
            'is_collapsed' => true,
        ]
    ],
    [
        'section_id' => $fix . 'row',
        'title' => __('Row', 'gds'),
        'section_tab_slug' => 'repeatable_tabbed_sections',
        'description' => __('Add row block data: click "+"', 'gds'),
        'repeatable' => true,
        'sortable' => true,
    ]
);

$dataContent[] = [
    'field_id' => 'by_id',
    'title' => __('By ID', 'gds'),
    'type' => 'text',
];
foreach (LIP::get_post_type_list() as $type => $name) {
    if ($type == 'post')
        $fieldID = 'category';
    else
        $fieldID = $type . '_category';

    $dataContent[] = [
        'field_id' => $fieldID,
        'title' => __(ucfirst(str_replace('_', ' ', $fieldID)), 'gds'),
        'type' => 'select',
        'label' => LIP::get_term_list($type, $fieldID, true)
    ];
}

$this->addSettingFields(
    $fix . 'row',
    [
        'field_id' => 'row_title',
        'type' => 'section_title',
        'default' => __('Type of row name', 'gds')
    ],
    //<editor-fold desc="Show option">
    [
        'field_id' => 'show_option',
        'type' => 'inline_mixed',
        'title' => __('Show', 'gds'),
        'content' => [
            [
                'field_id' => 'row_title',
                'type' => 'radio',
                'title' => __('Show row title', 'gds'),
                'label' => [true => 'Yes', false => 'No'],
                'default' => false,
            ],
            [
                'field_id' => 'sticky_posts',
                'type' => 'radio',
                'title' => __('Sticky post', 'gds'),
                'label' => [true => 'Yes', false => 'No'],
                'default' => false,
            ],
        ]
    ],
    //</editor-fold>
    //<editor-fold desc="Row extra">
    [
        'field_id' => 'row_extra',
        'type' => 'inline_mixed',
        'title' => __('Row extra', 'gds'),
        'content' => [
            [
                'field_id' => 'row_before',
                'type' => 'textarea',
                'title' => __('Before', 'gds'),
                'attributes' => array(
                    'rows' => 2,
                    'cols' => 30,
                ),
            ],
            [
                'field_id' => 'row_after',
                'type' => 'textarea',
                'title' => __('After', 'gds'),
                'attributes' => array(
                    'rows' => 2,
                    'cols' => 30,
                ),
            ],
            [
                'field_id' => 'class',
                'title' => __('Css class', 'gds'),
                'type' => 'text'
            ],
            [
                'field_id' => 'container',
                'title' => __('Add container', 'gds'),
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No'],
                'default' => true
            ],
            [
                'field_id' => 'row',
                'title' => __('Add row', 'gds'),
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No'],
                'default' => true
            ]
        ]
    ],
    //</editor-fold>
    //<editor-fold desc="Column">
    [
        'field_id' => 'column',
        'title' => __('Column', 'gds'),
        'content' => [
            [
                'field_id' => 'col_extra',
                'type' => 'inline_mixed',
                'title' => __('Column extra', 'gds'),
                'content' => [
                    [
                        'field_id' => 'col_before',
                        'type' => 'textarea',
                        'title' => __('Before', 'gds'),
                        'attributes' => array(
                            'rows' => 2,
                            'cols' => 30,
                        ),
                    ],
                    [
                        'field_id' => 'col_after',
                        'type' => 'textarea',
                        'title' => __('After', 'gds'),
                        'attributes' => array(
                            'rows' => 2,
                            'cols' => 30,
                        ),
                    ],
                    [
                        'field_id' => 'class',
                        'title' => __('Css class', 'gds'),
                        'type' => 'text'
                    ]
                ]
            ],
            [
                'field_id' => 'option',
                'type' => 'inline_mixed',
                'content' => [
                    [
                        'field_id' => 'title',
                        'title' => __('Title', 'gds'),
                        'type' => 'text',
                        'default' => __('Block title', 'gds')
                    ],
                    [
                        'field_id' => 'show_title',
                        'type' => 'radio',
                        'title' => __('Show title', 'gds'),
                        'label' => [true => 'Yes', false => 'No'],
                        'label_min_width' => '',
                        'default' => true
                    ],
                    [
                        'field_id' => 'desc',
                        'type' => 'text',
                        'title' => __('Description', 'gds'),
                    ],
                    [
                        'field_id' => 'width',
                        'title' => __('width', 'gds'),
                        'type' => 'select',
                        'label' => LIP::arrayNumber(1, 1, 12),
                        'default' => 12,
                        'label_min_width' => ''
                    ],
                    [
                        'field_id' => 'type',
                        'title' => __('Type', 'gds'),
                        'type' => 'select',
                        'label' => ['xs' => 'xs', 'sm' => 'sm', 'md' => 'md', 'lg' => 'lg'],
                        'default' => 'md',
                        'label_min_width' => ''
                    ],
                    [
                        'field_id' => 'post_type',
                        'title' => __('Data', 'gds'),
                        'type' => 'select',
                        'label' => LIP::get_post_type_list(['html' => 'Html', 'widget' => 'Widget']),
                        'label_min_width' => ''
                    ],
                    [
                        'field_id' => 'layout',
                        'title' => __('Layout', 'gds'),
                        'type' => 'select',
                        'label' => LIP::layout_list(),
                        'label_min_width' => ''
                    ],
                    [
                        'field_id' => 'number',
                        'title' => __('Number of item', 'gds'),
                        'type' => 'text',
                        'attributes' => [
                            'style' => 'width:80px;'
                        ],
                        'default' => 5,
                        'label_min_width' => ''
                    ],
                ]
            ],
            [
                'field_id' => 'data',
                'type' => 'inline_mixed',
                'content' => $dataContent
            ],
            [
                'field_id' => 'html_widget',
                'type' => 'inline_mixed',
                'content' => [
                    [
                        'field_id' => 'html',
                        'title' => __('Html data', 'gds'),
                        'type' => 'textarea',
                    ],
                    [
                        'field_id' => 'widget',
                        'title' => __('Select widget', 'gds'),
                        'type' => 'select',
                        'label' => [
                            'home_widget_1' => 'Home page 1',
                            'home_widget_2' => 'Home page 2',
                            'home_widget_3' => 'Home page 3',
                            'home_widget_4' => 'Home page 4',
                        ],
                        'default' => 'home_widget'
                    ]
                ]
            ],

        ],
        'repeatable' => true,
        'sortable' => true,
    ],
//</editor-fold>
    [
        'field_id' => 'background',
        'title' => __('Background', 'gds'),
        'type' => 'inline_mixed',
        'content' => [
            [
                'field_id' => 'color',
                'type' => 'color',
                'title' => __('Color')
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
            [
                'field_id' => 'size',
                'type' => 'select',
                'title' => 'Size',
                'label' => LIP::bgsize_list()
            ]
        ]
    ]
);

$this->addSettingFields(
    $fix . 'extra',
    [
        'field_id' => 'home_sidebar',
        'type' => 'radio',
        'title' => __('Home sidebar', 'gds'),
        'label' => [true => 'Yes', false => 'No']
    ],
    [
        'field_id' => 'default_sidebar',
        'type' => 'radio',
        'title' => __('Default sidebar', 'gds'),
        'label' => [true => 'Yes', false => 'No']
    ],
    [
        'field_id' => 'show_slide',
        'type' => 'radio',
        'title' => __('Show slide', 'gds'),
        'label' => [true => 'Yes', false => 'No']
    ]
);

$this->addSettingFields(
    $fix . 'slide',
    [
        'field_id' => 'data_from',
        'type' => 'radio',
        'title' => __('Data from', 'gds'),
        'label' => ['post_tax' => 'Post taxonomy', 'post_item' => 'Post item', 'images' => 'Images']
    ],
    [
        'field_id' => 'post_type',
        'title' => __('Post type', 'gds'),
        'type' => 'select',
        'label' => LIP::get_post_type_list()
    ],
    [
        'field_id' => 'number',
        'title' => __('Number item', 'gds'),
        'type' => 'text'
    ],
    [
        'field_id' => 'data',
        'type' => 'inline_mixed',
        'title' => __('Post data', 'gds'),
        'content' => $dataContent
    ],
    [
        'field_id' => 'images',
        'type' => 'image',
        'title' => __('Images', 'gds'),
        'repeatable' => true,
        'attributes' => [
            'preview' => [
                'style' => 'max-width:100px;'
            ]
        ]
    ]
);
