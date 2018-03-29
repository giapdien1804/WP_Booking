<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:56 PM
 */
class service_price_default extends AdminPageFramework_MetaBox
{

    public $px = 'service_';

    public function setUp()
    {
        $this->addSettingFields(
            [
                'field_id' => $this->px . 'price_from',
                'type' => 'text',
                'title' => 'Price from',
                'default' => 0
            ],
            [
                'field_id' => $this->px . 'price_old',
                'type' => 'text',
                'title' => 'Price old',
                'default' => ''
            ],
            [
                'field_id' => $this->px . 'group_size',
                'type' => 'text',
                'title' => 'Group size'
            ]
        );
    }

    public function validate($aInput, $aOldInput)
    {

        $_bIsValid = true;
        $_aErrors = array();

        // You can check the passed values with the log() method of the oDebug object.
        // $this->oDebug->log( $aInput );

        if (!is_numeric($aInput[$this->px . 'price_from']) || $aInput[$this->px . 'price_from'] == '') {
            $_aErrors[$this->px . 'price_from'] = 'Not null or Only numeric';
            $_bIsValid = false;
        }

        if ($aInput[$this->px . 'price_old'] != '') {
            if (!is_numeric($aInput[$this->px . 'price_old'])) {
                $_aErrors[$this->px . 'price_old'] = 'Only numeric';
                $_bIsValid = false;
            }
        }


        if (!$_bIsValid) {

            $this->setFieldErrors($_aErrors);
            $this->setSettingNotice('There was an error in your input in  form fields');

            return $aOldInput;
        }

        return $aInput;

    }
}

new service_price_default(
    null,
    'Price default',
    ['service'],
    'side',
    'default'
);


class service_data extends AdminPageFramework_MetaBox
{

    public $px = 'service_';

    public function setUp()
    {
        $this->addSettingSections(
            [
                'section_id' => $this->px . 'default',
                'section_tab_slug' => 'tabbed_sections',
                'title' => 'Default',
            ],
            [
                'section_id' => $this->px . 'highlight',
                'section_tab_slug' => 'tabbed_sections',
                'title' => 'Highlight',
            ],
            [
                'section_id' => $this->px . 'included',
                'section_tab_slug' => 'tabbed_sections',
                'title' => 'Included',
            ],
            [
                'section_id' => $this->px . 'itinerary',
                'section_tab_slug' => 'tabbed_sections',
                'title' => 'Itinerary',
            ]
        );

        $this->addSettingFields(
            $this->px . 'default',
            [
                'field_id' => 'code',
                'type' => 'text',
                'title' => 'Code',
                'default' => ''
            ],
            [
                'field_id' => 'departure',
                'type' => 'text',
                'title' => 'Departure',
                'default' => ''
            ]
        );

        $this->addSettingFields(
            $this->px . 'highlight',
            [
                'field_id' => 'highlight',
                'type' => 'textarea',
                'title' => 'Highlight',
                'rich' => true,
                'attributes' => array(
                    'field' => array(
                        'style' => 'width: 100%;'
                    ),
                ),
            ]
        );

        $this->addSettingFields(
            $this->px . 'included',
            [
                'field_id' => 'included',
                'type' => 'textarea',
                'title' => 'What\'s Included',
                'rich' => true,
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ],
            ],
            [
                'field_id' => 'not_included',
                'type' => 'textarea',
                'title' => 'What\'s not Included',
                'rich' => true,
                'attributes' => array(
                    'field' => array(
                        'style' => 'width: 100%;'
                    ),
                ),
            ]
        );

        $this->addSettingFields(
            $this->px . 'itinerary',
            [
                'field_id' => 'itinerary',
                'type' => 'textarea',
                'title' => 'Itinerary',
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ],
            ]
        );

    }


    public function validate($aInput, $aOldInput)
    {

        $_bIsValid = true;
        $_aErrors = array();

        /* if (!is_numeric($aInput[$this->px . 'default']['group_size']) || $aInput[$this->px . 'default']['group_size'] == '') {
             $_aErrors[$this->px . 'default']['group_size'] = 'Only numeric or Not null';
             $_bIsValid = false;
         } */

        if ($aInput[$this->px . 'default']['code'] == '') {
            $_aErrors[$this->px . 'default']['code'] = 'Not null';
            $_bIsValid = false;
        }


        if (!$_bIsValid) {

            $this->setFieldErrors($_aErrors);
            $this->setSettingNotice('There was an error in your input in  form fields');

            return $aOldInput;

        }

        return $aInput;

    }
}

new service_data(
    null,
    'service data',
    ['service'],
    'normal',
    'default'
);

class service_price extends AdminPageFramework_MetaBox
{

    public $px = 'service_';

    public function setUp()
    {

        $this->addSettingSections(
            [
                'section_id' => $this->px . 'options',
                'section_tab_slug' => 'repeatable_tabbes_sections',
                'title' => 'Service options',
                'description' => '&#8212; Click "+" (add section) to add new tour option &#8212;',
                'repeatable' => true,
                'sortable' => true,
            ]
        );


        $this->addSettingFields(
            $this->px . 'options',   // section id
            [
                'field_id' => 'option_title',
                'type' => 'section_title',
                'label' => 'Name:',
            ],
            [
                'field_id' => 'option_note',
                'type' => 'text',
                'title' => 'Option note',
                'attributes' => [
                    'style' => 'width:400px'
                ]
            ],
            [
                'field_id' => 'pre_book',
                'type' => 'text',
                'title' => 'Pre book',
                'default' => GDS::get_option(['post_service', 'default_value', 'per_book'])
            ],

            [
                'field_id' => 'duration',
                'type' => 'select',
                'title' => 'Duration',
                'label' => LIP::duration_list('service')
            ],
            [
                'field_id' => 'min_qty',
                'type' => 'number',
                'title' => 'Minimum quantity',
                'default' => GDS::get_option(['post_service', 'default_value', 'min_qty'])
            ],
            [
                'field_id' => 'max_qty',
                'type' => 'number',
                'title' => 'Maximum quantity',
                'default' => GDS::get_option(['post_service', 'default_value', 'max_qty'])
            ],
            [
                'field_id' => 'option_table',
                'title' => 'Table price',
                'type' => 'table_price',
                'extra' => [
                    'list_price_name' => ['title' => 'List price name', 'css' => ''],
                    'valid_from' => ['title' => 'Valid from', 'css' => 'gds_date_pick'],
                    'valid_to' => ['title' => 'Valid to', 'css' => 'gds_date_pick'],
                    'promotion' => ['title' => 'Promotion', 'css' => ''],
                    'by_group' => ['title' => 'Price by group', 'css' => '']
                ],
                'number_col' => 10,
                'repeatable' => true,
                'sortable' => true,
            ]
        );
    }

    public function validate($aInput, $aOldInput)
    {
        $_bIsValid = true;
        $_aErrors = array();

        if (!$_bIsValid) {
            $this->setFieldErrors($_aErrors);
            $this->setSettingNotice('There was an error in your input in  form fields');
            return $aOldInput;
        }

        return $aInput;

    }
}

new service_price(
    null,
    'service options',
    ['service'],
    'normal',
    'default'
);

