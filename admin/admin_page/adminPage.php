<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 3:54 PM
 */
class GdsOption extends AdminPageFramework
{

    public function setUp()
    {
        $this->setRootMenuPage('GDS');
        $this->addSubMenuItems(
            [
                'title' => 'Option',
                'page_slug' => 'gds_option'
            ],
            [
                'title' => 'Style',
                'page_slug' => 'gds_style'
            ],
            [
                'title' => 'Post type',
                'page_slug' => 'gds_post'
            ],
            [
                'title' => 'Booking',
                'page_slug' => 'gds_booking'
            ],
            [
                'title' => 'Home page',
                'page_slug' => 'gds_home'
            ],
            [
                'title' => 'Other',
                'page_slug' => 'gds_other'
            ],
            [
                'title' => 'Manager',
                'page_slug' => 'gds_manager'
            ]
        );
    }

    public function load()
    {
        $this->setPageHeadingTabsVisibility(true);
    }

    public function content($sHTML)
    {
        return get_submit_button() . $sHTML . "<p>Theme option create by team 7gmt.com</p>" . get_submit_button();
    }

    public function load_gds_style()
    {
        include dirname(__FILE__) . '/style.php';
    }

    public function load_gds_option()
    {
        include dirname(__FILE__) . '/option.php';
    }

    public function load_gds_post()
    {
        include dirname(__FILE__) . '/post.php';
    }

    public function load_gds_booking()
    {
        include dirname(__FILE__) . '/booking.php';
    }

    public function load_gds_home()
    {
        include dirname(__FILE__) . '/home.php';
    }

    public function load_gds_other()
    {
        include dirname(__FILE__) . '/other.php';
    }

    public function load_gds_manager()
    {
        include dirname(__FILE__) . '/manager.php';
    }

}