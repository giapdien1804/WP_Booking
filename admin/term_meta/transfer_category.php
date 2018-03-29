<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:57 PM
 */

class transfer_category_meta extends AdminPageFramework_TermMeta
{

    public function setUp()
    {

        $this->addSettingFields(
            [
                'field_id' => 'transfer_category_img',
                'type' => 'image',
                'title' => 'Category image',
                'attributes' => [
                    'preview' => [
                        'style' => 'max-width: 200px;',
                    ],
                ],
            ],
            [
                'field_id' => 'transfer_category_slide',
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

new transfer_category_meta(
    'transfer_category'   // taxonomy slug
);