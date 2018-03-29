<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:57 PM
 */

class service extends AdminPageFramework_PostType
{

    public function setUp()
    {
        $this->setArguments(
            [
                'labels' => [
                    'name' => 'Services',
                    'all_items' => 'All services',
                ],
                'taxonomies' => ['service_category', 'post_tag'],
                'supports' => ['title', 'editor', 'comments', 'thumbnail', 'excerpt'],
                'public' => true,
                'menu_icon' => THEME_URL . '/admin/asset/images/service_16x16.png'
            ]
        );

        $this->addTaxonomy(
            'service_category',
            [
                'labels' => [
                    'name' => __('Service Categories', 'gds')
                ],
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_table_filter' => true,
                'show_in_sidebar_menus' => true,
            ]
        );
    }
}