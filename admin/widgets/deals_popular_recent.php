<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 1/6/2016
 * Time: 4:32 PM
 */
class deals_popular_recent extends AdminPageFramework_Widget
{
    public function start()
    {

    }

    public function setUp()
    {
        $this->setArguments(['description' => 'Post data deals, popular, recent view']);
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
                'field_id' => 'type',
                'type' => 'select',
                'title' => 'Data type',
                'label' => [
                    'deals_view' => 'Deals',
                    'popular_view' => 'Popular',
                    'recent_view' => 'Recent view',
                    'tour_might_like' => 'Tour Might Like'
                ]
            ],
            [
                'field_id' => 'style',
                'type' => 'select',
                'title' => 'Style',
                'label' => [
                    'style_1' => 'Small list',
                    'style_2' => 'Grid list',
                    'style_3' => 'Scroll',
                    'style_4' => 'Column',
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
        $data = call_user_func_array(__NAMESPACE__ . '\CRQ::' . $aFormData['type'], [$aFormData['post_type'], $aFormData['per_page']]);

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
        if ($data != null)
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
        if ($data != null)
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
        if ($data != null)
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


    private function style_4($data, $type)
    {
        $tmp = '<div class="row">';
        if ($data != null)
            if ($data->have_posts()) {
                while ($data->have_posts()) {
                    $data->the_post();
                    $tmp .= LIP::load_template_part("/admin/widgets/styles/{$type}/column");
                }
                wp_reset_postdata();
            }
        $tmp .= '</div>';

        return $tmp;
    }
}

new deals_popular_recent('7gmt deals, popular, recent view');