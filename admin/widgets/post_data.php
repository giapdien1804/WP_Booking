<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 27/5/2016
 * Time: 10:07 AM
 */
class post_data extends AdminPageFramework_Widget
{
    public function start()
    {

    }

    public function setUp()
    {
        $this->setArguments(['description' => 'Post data widget']);
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
            ]
        );
        foreach (LIP::get_post_type_list() as $item => $value) {

            $this->addSettingFields(
                [
                    'field_id' => $item . '_category',
                    'type' => 'select',
                    'title' => $value . ' Category',
                    'label' => LIP::taxonomy_list($item, null, ['' => 'Select category']),
                    'default' => ''
                ]
            );
        }
        $this->addSettingFields(
            [
                'field_id' => 'per_page',
                'type' => 'number',
                'title' => 'number of post',
                'default' => 5
            ],
            [
                'field_id' => 'by_id',
                'type' => 'text',
                'title' => 'By ID'
            ],
            [
                'field_id' => 'style',
                'type' => 'select',
                'title' => 'Style',
                'label' => [
                    'style_1' => 'Small list',
                    'style_2' => 'Grid list',
                    'style_3' => 'Scolumn',
                    'style_4' => 'Column'
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
        $id = null;
        if (trim($aFormData['by_id']) != '')
            $id = explode(',', $aFormData['by_id']);

        $post_type = $aFormData['post_type'];
        $tax_name = $aFormData[$post_type . '_category'];

        $taxonomy = ($aFormData['post_type'] == 'post') ? 'category' : $aFormData['post_type'] . '_category';
        $extra = is_array($id) ? ['post__in' => $id] : [];
        $data = CRQ::by_post_type($post_type, $aFormData['per_page'], $extra);
        if ($tax_name != null)
            $data = CRQ::by_taxonomy_term($post_type, $taxonomy, $tax_name, $aFormData['per_page'], $extra);

        $sContent = call_user_func_array([$this, $aFormData['style']], [$data, $post_type]);

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
     * @param $type
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
     * @param $type
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

    private function style_4($data, $type)
    {

        $tmp = '<div class="row">';
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

new post_data('7gmt Post data');