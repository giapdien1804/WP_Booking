<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:56 PM
 */

class hotel_data extends AdminPageFramework_MetaBox
{
    public $px = 'hotel_';

    public function setUp()
    {
        $this->addSettingSections(
            [
                'section_id' => $this->px . 'default',
                'section_tab_slug' => 'tabbed_sections',
                'title' => 'Default',
            ],
            [
                'section_id' => $this->px . 'media',
                'section_tab_slug' => 'tabbed_sections',
                'title' => 'Media',
            ]

        );

        $this->addSettingSections(
            [
                'section_id' => $this->px . 'service_detail',
                'title' => 'Equipment Detail',
                'collapsible' => [
                    'is_collapsed' => true,
                    'container' => 'section',
                ],
                'repeatable' => true,
                'sortable' => true,
            ]
        );

        $this->addSettingSections(
            [
                'section_id' => $this->px . 'equipment_detail',
                'title' => 'Service Detail',
                'collapsible' => [
                    'is_collapsed' => true,
                    'container' => 'section',
                ],
                'repeatable' => true,
                'sortable' => true,
            ]
        );


        $this->addSettingFields(
            $this->px . 'default',
            [
                'field_id' => 'acreage',
                'type' => 'text',
                'title' => 'Acreage',
                'default' => ''
            ],
            [
                'field_id' => 'bed_type',
                'type' => 'text',
                'title' => 'Bed type',
                'default' => ''
            ],
            [
                'field_id' => 'price',
                'type' => 'text',
                'title' => 'Price',
                'default' => '0'
            ],
            [
                'field_id' => 'min_number',
                'type' => 'text',
                'title' => 'Min number',
                'default' => ''
            ],
            [
                'field_id' => 'max_number',
                'type' => 'text',
                'title' => 'Max number',
                'default' => ''
            ],
            [
                'field_id' => 'star',
                'type' => 'select',
                'title' => 'Star',
                'label' => LIP::star_list(),
                'default' => GDS::get_option(['post_tour', 'default_value', 'star'])
            ]
        );


        $this->addSettingFields(
            $this->px . 'service_detail',
            [
                'field_id' => 'title',
                'type' => 'section_title',
                'title' => 'Service Detail',
            ],
            [
                'field_id' => 'content',
                'type' => 'textarea',
                'title' => 'Content',
                'rich' => true,
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ],
            ]
        );

        $this->addSettingFields(
            $this->px . 'equipment_detail',
            [
                'field_id' => 'title',
                'type' => 'section_title',
                'title' => 'Equipment Detail',
            ],
            [
                'field_id' => 'content',
                'type' => 'textarea',
                'title' => 'Content',
                'rich' => true,
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ],
            ]
        );

        $this->addSettingFields(
            $this->px . 'media',
            [
                'field_id' => 'image',
                'type' => 'image',
                'title' => 'Images',
                'attributes' => [
                    'preview' => [
                        'style' => 'max-width: 100px;',
                    ],
                ],
                'repeatable' => true,
                'sortable' => true,
            ]
        );
    }
}

new hotel_data(
    null,
    'Hotel data',
    ['hotel'],
    'normal',
    'default'
);