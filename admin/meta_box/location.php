<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 25/5/2016
 * Time: 11:47 AM
 */

class location_meta extends AdminPageFramework_MetaBox
{
    /**
     * @var string
     */
    public $px = 'location_';

    /**
     *
     */
    public function setUp()
    {
        $this->addSettingFields(
            [
                'field_id' => $this->px . 'highlight',
                'type' => 'textarea',
                'title' => 'Highlight',
                'rich' => true,
                'attributes' => [
                    'field' => [
                        'style' => 'width: 100%;'
                    ],
                ],
            ],
            [
                'field_id' => $this->px . 'image',
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

    /**
     * @param $aInput
     * @param $aOldInput
     * @return mixed
     */
    public function validate($aInput, $aOldInput)
    {

        $_bIsValid = true;
        $_aErrors = array();


        if (!$_bIsValid) {

            $this->setFieldErrors($_aErrors);
            $this->setSettingNotice('There was an error in your input in form fields');

            return $aOldInput;

        }

        return $aInput;

    }
}

new location_meta(
    null,
    'Location data',
    ['location'],
    'normal',
    'default'
);


