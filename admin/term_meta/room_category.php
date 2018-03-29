<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:57 PM
 */

class room_category_meta extends AdminPageFramework_TermMeta
{

    public function setUp()
    {

        $this->addSettingFields(
            [
                'field_id' => 'room_category_img',
                'type' => 'image',
                'title' => 'Category image',
                'attributes' => [
                    'preview' => [
                        'style' => 'max-width: 200px;',
                    ],
                ],
            ],
            [
                'field_id' => 'room_category_slide',
                'type' => 'image',
                'title' => 'Category slide',
                'attributes' => [
                    'preview' => [
                        'style' => 'max-width: 200px;',
                    ],
                ],
                'repeatable' => true
            ]
        );

    }
}

new room_category_meta(
    'room_category'   // taxonomy slug
);