<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:57 PM
 */

class room extends AdminPageFramework_PostType
{

    public function setUp()
    {
        $this->setArguments(
            [
                'labels' => [
                    'name' => 'Rooms',
                    'all_items' => 'All rooms',
                ],
                'taxonomies' => ['room_category', 'post_tag'],
                'supports' => ['title', 'editor', 'comments', 'thumbnail', 'excerpt'],
                'public' => true,
                'menu_icon' => THEME_URL . '/admin/asset/images/room_16x16.png'
            ]
        );

        $this->addTaxonomy(
            'room_category',
            [
                'labels' => [
                    'name' => __('Room Categories', 'gds')
                ],
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_table_filter' => true,
                'show_in_sidebar_menus' => true,
                'rewrite' => [
                    'slug' => 'rooms'
                ]
            ]
        );
    }
}