<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 1/6/2016
 * Time: 3:27 PM
 */
class show_label extends AdminPageFramework_Widget
{
    public function start()
    {

    }

    public function setUp()
    {
        $this->setArguments(['description' => 'Post data by show label']);
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
                'field_id' => 'post_type',
                'type' => 'select',
                'title' => 'Post type',
                'label' => LIP::get_post_type_list()
            ],
            [
                'field_id' => 'per_page',
                'type' => 'number',
                'title' => 'number of post',
                'default' => 5
            ],
            [
                'field_id' => 'label',
                'type' => 'select',
                'title' => 'Show label',
                'label' => LIP::showLabel_list()
            ],
            [
                'field_id' => 'style',
                'type' => 'select',
                'title' => 'Style',
                'label' => [
                    'style_1' => 'Small list',
                    'style_2' => 'Grid list',
                    'style_3' => 'Scroll'
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
        $data = CRQ::by_show_label($aFormData['label'], $aFormData['post_type'], $aFormData['per_page']);

        $sContent = call_user_func_array([$this, $aFormData['style']], [$data, $aFormData['post_type']]);

        return $sContent;
    }

    /**
     * @param $data WP_Query
     * @param $type string
     * @return string
     */
    private function style_1($data, $type)
    {
        $tmp = '';
        if ($data->have_posts()) {
            while ($data->have_posts()) {
                $data->the_post();
                $tmp .= LIP::load_template_part("/admin/widgets/styles/{$type}/media");
            }
            wp_reset_postdata();
        }

        return $tmp;
    }

    /**
     * @param $data WP_Query
     * @param $type string
     * @return string
     */
    private function style_2($data, $type)
    {
        $tmp = '<div class="row">';
        if ($data->have_posts()) {
            while ($data->have_posts()) {
                $data->the_post();
                $tmp .= LIP::load_template_part("/admin/widgets/styles/{$type}/grid");
            }
            wp_reset_postdata();
        }
        $tmp .= '</div>';

        return $tmp;
    }

    /**
     * @param $data WP_Query
     * @param $type string
     * @return string
     */
    private function style_3($data, $type)
    {
        $tmp = '<div class="row"><div class="content-slider-sidebar">';
        if ($data->have_posts()) {
            while ($data->have_posts()) {
                $data->the_post();
                $tmp .= LIP::load_template_part("/admin/widgets/styles/{$type}/slide");
            }
            wp_reset_postdata();
        }
        $tmp .= '</div></div>';

        return $tmp;
    }
}

new show_label('7gmt tour show label');