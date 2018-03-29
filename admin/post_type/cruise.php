<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 4:00 PM
 */

class cruise extends AdminPageFramework_PostType
{

    public function setUp()
    {
        $this->setArguments(
            [
                'labels' => [
                    'name' => 'Cruises',
                    'all_items' => 'All cruises',
                ],
                'taxonomies' => ['cruise_category', 'post_tag'],
                'supports' => ['title', 'editor', 'comments', 'thumbnail', 'excerpt'],
                'public' => true,
                'menu_icon' => THEME_URL . '/admin/asset/images/cruise_16x16.png'
            ]
        );

        $this->addTaxonomy(
            'cruise_category',
            [
                'labels' => [
                    'name' => __('Cruise Categories', 'gds')
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