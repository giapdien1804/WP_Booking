<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 4:03 PM
 */

include(dirname(__FILE__) . '/lip/admin-page-framework.php');

class Bootstrap
{

    function __construct()
    {
        $this->_loadClassName();
        $this->loadPostType();
        $this->loadMetaBox();
        $this->loadTermMeta();

        $this->loadWidgets();
    }

    private function loadClass()
    {
        $gdsClass = [
            'GdsOption' => dirname(__FILE__) . '/admin_page/adminPage.php',
            'updateTheme' => dirname(__FILE__) . '/admin_page/update.php',
            'TablePriceFieldType' => dirname(__FILE__) . '/field/TablePriceFieldType.php'
        ];

        return $gdsClass;
    }

    private function _loadClassName()
    {
        foreach ($this->loadClass() as $name => $path) {
            include_once $path;
            if (class_exists($name))
                new $name;
        }

        $class_list = [
            dirname(__FILE__) . '/LIP.php',
            dirname(__FILE__) . '/GDS.php',
            dirname(__FILE__) . '/CRQ.php',
            dirname(__FILE__) . '/CSS.php',
            dirname(__FILE__) . '/payment.php',
            dirname(__FILE__) . '/site_contact.php',
            dirname(__FILE__) . '/tailor_made.php',
        ];

        foreach ($class_list as $filePath) {
            if (file_exists($filePath)) {
                include_once $filePath;
            }
        }
    }

    private function loadPostType()
    {
        foreach (LIP::get_post_type_list() as $type => $name) {
            $filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'post_type' . DIRECTORY_SEPARATOR . $type . '.php';
            if (file_exists($filePath)) {
                include_once $filePath;
                if (class_exists($type))
                    if (GDS::get_option(['post_enable', $type]) == true)
                        new $type($type);
            }
        }
    }

    private function loadMetaBox()
    {
        foreach (LIP::get_post_type_list() as $type => $name) {
            $filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'meta_box' . DIRECTORY_SEPARATOR . $type . '.php';
            $get_meta = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'get_meta' . DIRECTORY_SEPARATOR . $type . '.php';
            if (file_exists($filePath)) {
                include_once $filePath;
            }

            if (file_exists($get_meta)) {
                include_once $get_meta;
            }
        }
    }

    private function loadTermMeta()
    {
        foreach (LIP::get_post_type_list() as $type => $name) {
            $filePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'term_meta' . DIRECTORY_SEPARATOR . $type . '_category.php';
            if (file_exists($filePath)) {
                include_once $filePath;
            }
        }
    }

    private function loadWidgets()
    {
        $classFile = [
            dirname(__FILE__) . '/widgets/media_ads.php',
            dirname(__FILE__) . '/widgets/deals_popular_recent.php',
            dirname(__FILE__) . '/widgets/post_data.php',
            dirname(__FILE__) . '/widgets/show_label.php',
            dirname(__FILE__) . '/widgets/contact.php',
        ];

        foreach ($classFile as $filePath) {
            if (file_exists($filePath))
                include_once $filePath;
        }
    }
}

new Bootstrap();