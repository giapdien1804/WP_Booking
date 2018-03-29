<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 26/5/2016
 * Time: 2:28 PM
 */ ?>
<?php

class media_ads extends AdminPageFramework_Widget
{

    public function start()
    {

    }

    public function setUp()
    {

        $this->setArguments(
            array(
                'description' => 'Media ads widget',
            )
        );

    }

    /**
     * Sets up the form.
     *
     * Alternatively you may use load_{instantiated class name} method.
     * @param $oAdminWidget
     */
    public function load($oAdminWidget)
    {

        $this->addSettingFields(
            [
                'field_id' => 'title',
                'type' => 'text',
                'title' => 'Title'
            ],
            [
                'field_id' => 'description',
                'type' => 'textarea',
                'title' => 'Description'
            ],
            [
                'field_id' => 'media',
                'type' => 'image',
                'title' => 'media',
            ],
            [
                'field_id' => 'url',
                'type' => 'text',
                'title' => 'Link'
            ],
            [
                'field_id' => 'option',
                'type' => 'checkbox',
                'title' => 'Option',
                'label' => [
                    '_blank' => 'target: _blank',
                    'nofollow' => 'rel: nofollow',
                    'img-responsive' => 'size: img-responsive'
                ]
            ]
        );


    }

    /**
     * Validates the submitted form data.
     *
     * Alternatively you may use validation_{instantiated class name} method.
     * @param $aSubmit
     * @param $aStored
     * @param $oAdminWidget
     * @return
     */
    public function validate($aSubmit, $aStored, $oAdminWidget)
    {

        // Uncomment the following line to check the submitted value.
        // AdminPageFramework_Debug::log( $aSubmit );

        return $aSubmit;

    }

    /**
     * Print out the contents in the front-end.
     *
     * Alternatively you may use the content_{instantiated class name} method.
     * @param $sContent
     * @param $aArguments
     * @param $aFormData
     * @return string
     */
    public function content($sContent, $aArguments, $aFormData)
    {
        $data = (object)$aFormData;
        $option = [
            'class' => '',
            'target' => '',
            'rel' => ''
        ];
        if ($data->option['_blank'] == 1) $option['target'] = '_blank';
        if ($data->option['nofollow'] == 1) $option['rel'] = 'nofollow';
        if ($data->option['img-responsive'] == 1) $option['class'] = 'img-responsive';
        $sContent = '
            <figure>
                <a href="' . $data->url . '" target="' . $option['target'] . '" rel="' . $option['rel'] . '" title="' . $data->title . '" class="footer-tailor">
                    <img src="' . $data->media . '" alt="' . $data->title . '" class="' . $option['class'] . '">
                </a>
                <figcaption>' . $data->description . '</figcaption>
            </figure>';


        return $sContent;
    }

}

new media_ads('7gmt media ads');
