<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 9/7/2016
 * Time: 9:50 AM
 */
class updateTheme extends AdminPageFramework
{
    public function setUp()
    {
        $this->setRootMenuPage('Update theme');
        $this->addSubMenuItems(
            [
                'title' => 'Database',
                'page_slug' => 'gds_update_database'
            ]
        );
    }

    public function load()
    {
        $this->addSettingFields(
            [
                'field_id' => 'upv2tov3',
                'title' => "Update database v2 to v3",
                'type' => 'radio',
                'label' => [true => 'Yes', false => 'No'],
                'description' => '<strong style="color: red">Backup database after update database v2 to v3</strong>'
            ],
            [
                'field_id' => 'pass',
                'title' => "Password",
                'type' => 'password',
                'description' => '<strong style="color: red">Password contact it@7gmt.com</strong>'
            ]
        );

        //reset option
        update_option('updateTheme', '');
    }

    public function validate($aInput, $aOldInput)
    {

        $_bIsValid = true;
        $_aErrors = array();

        if ($aInput['pass'] == '') {
            $_aErrors['pass'] = 'Please input the password';
            $_bIsValid = false;
        }

        if ($aInput['pass'] != LIP::decrypttion('zhh3doCsCC2hv5vFO3j7JyBeBq/pnvJHcDTFJ8+FhPM=')) {
            $_aErrors['pass'] = 'Password isn\'t correct';
            $_bIsValid = false;
        }

        if (!$_bIsValid) {

            $this->setFieldErrors($_aErrors);
            $this->setSettingNotice('There was an error in your input in  form fields');

            return $aOldInput;

        }

        return $aInput;

    }

    public function do_gds_update_database()
    {
        submit_button('Run update database');
    }

    public function submit_after_updateTheme()
    {
        global $wpdb;
        $updateTheme = get_option('updateTheme');
        if ($updateTheme['upv2tov3'] == true && $updateTheme['pass'] = LIP::decrypttion('zhh3doCsCC2hv5vFO3j7JyBeBq/pnvJHcDTFJ8+FhPM=')) {

            //<editor-fold desc="Uprate travel to tour">
            $sql = [];
            //rename post type travel to tour
            $sql[0] = /** @lang text */
                "UPDATE {$wpdb->prefix}posts SET post_type = 'tour' WHERE post_type='travel'";
            //rename taxonomy travel_category to tour_category
            $sql[1] = /** @lang text */
                "update {$wpdb->prefix}term_taxonomy SET taxonomy='tour_category' WHERE taxonomy='travel_category'";
            //rename meta key travel_* to tour_*
            $sql[2] = /** @lang text */
                "UPDATE {$wpdb->prefix}postmeta SET meta_key = REPLACE(meta_key, 'travel_', 'tour_') WHERE meta_key like 'travel_%'";

            foreach ($sql as $cmd) {
                $wpdb->query($cmd);
            }
            //rename meta value  travel_*_qty to *_qty
            $args = [
                'post_type' => 'tour',
                'posts_per_page' => -1
            ];
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $opt = get_post_meta(get_the_ID(), 'tour_options');
                    $new = [];
                    $_update = false;
                    foreach ($opt[0] as $item => $value) {
                        $new[] = [
                            'option_title' => $value['option_title'],
                            'option_note' => $value['option_note'],
                            'min_qty' => isset($value['travel_min_qty']) ? $value['travel_min_qty'] : $value['min_qty'],
                            'max_qty' => isset($value['travel_max_qty']) ? $value['travel_max_qty'] : $value['max_qty'],
                            'option_table' => $value['option_table']
                        ];

                        if (isset($value['travel_min_qty']) || isset($value['travel_max_qty']))
                            $_update = true;
                    }

                    if ($_update == true)
                        update_post_meta(get_the_ID(), 'tour_options', $new);

                    //Move meta tour_default['group_size'] to tour_group_size
                    $tour_default = get_post_meta(get_the_ID(), 'tour_default', true);
                    if (isset($tour_default['group_size'])) {
                        $new_tour_default = [
                            'code' => $tour_default['code'],
                            'departure' => $tour_default['departure']
                        ];
                        update_post_meta(get_the_ID(), 'tour_default', $new_tour_default);
                        add_post_meta(get_the_ID(), 'tour_group_size', $tour_default['group_size']);
                    }

                }
                unset($the_query);
            }
            wp_reset_postdata();
            //</editor-fold>

            //<editor-fold desc="Update services to service">
            $sql = [];
            //rename post type services to service
            $sql[0] = /** @lang text */
                "UPDATE {$wpdb->prefix}posts SET post_type = 'service' WHERE post_type='services'";
            //rename post type travel to tour

            //rename meta key services_* to service_*
            $sql[2] = /** @lang text */
                "UPDATE {$wpdb->prefix}postmeta SET meta_key = REPLACE(meta_key, 'services_', 'service_') WHERE meta_key like 'services_%'";

            foreach ($sql as $cmd) {
                $wpdb->query($cmd);
            }

            //rename service_options value
            $args = [
                'post_type' => 'service',
                'posts_per_page' => -1
            ];
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $opt = get_post_meta(get_the_ID(), 'service_options');
                    $new = [];
                    $_update = false;
                    foreach ($opt[0] as $item => $value) {
                        $new[] = [
                            'option_title' => $value['option_title'],
                            'option_note' => $value['option_note'],
                            'pre_book' => isset($value['services_pre_book']) ? $value['services_pre_book'] : $value['pre_book'],
                            'duration' => isset($value['services_duration']) ? $value['services_duration'] : $value['duration'],
                            'min_qty' => isset($value['services_min_qty']) ? $value['services_min_qty'] : $value['min_qty'],
                            'max_qty' => isset($value['services_max_qty']) ? $value['services_max_qty'] : $value['max_qty'],
                            'option_table' => $value['option_table']
                        ];

                        if (isset($value['services_pre_book']) || isset($value['services_duration']) || isset($value['services_min_qty']) || isset($value['services_max_qty']))
                            $_update = true;
                    }

                    if ($_update == true)
                        update_post_meta(get_the_ID(), 'service_options', $new);

                    //Move meta service_default['group_size'] to service_group_size
                    $service_default = get_post_meta(get_the_ID(), 'service_default', true);
                    if (isset($service_default['group_size'])) {
                        $new_service_default = [
                            'code' => $service_default['code'],
                            'departure' => $service_default['departure']
                        ];
                        update_post_meta(get_the_ID(), 'service_default', $new_service_default);
                        add_post_meta(get_the_ID(), 'service_group_size', $service_default['group_size']);
                    }

                }
                unset($the_query);
            }
            wp_reset_postdata();

            //</editor-fold>


        }
    }
}