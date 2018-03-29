<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:57 PM
 */

class tour extends AdminPageFramework_PostType
{

    public function setUp()
    {
        $this->setArguments(
            [
                'labels' => [
                    'name' => 'Tours',
                    'all_items' => 'All tours',
                ],
                'taxonomies' => ['tour_category', 'post_tag'],
                'supports' => ['title', 'editor', 'comments', 'thumbnail', 'excerpt'],
                'public' => true,
                'menu_icon' => THEME_URL . '/admin/asset/images/tour_16x16.png',
                'has_archive' => true,
                'show_admin_column' => true,
            ]
        );

        $this->addTaxonomy(
            'tour_category',
            [
                'labels' => [
                    'name' => __('Tour Categories', 'gds')
                ],
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_table_filter' => true,
                'show_in_sidebar_menus' => true,
                'rewrite' => [
                    'slug' => 'tours'
                ]
            ]
        );
    }
}

