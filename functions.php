<?php
/**
 * Created by giapdien.
 * User: giapdien
 * email: giapdien1804@gmail.com | traihogiap@hotmail.com
 * Date: 25/04/2016
 * Time: 10:58 CH
 */
/*
 * Register Theme Features
 */
ini_set('memory_limit', '-1');

define('THEME_URL', get_template_directory_uri());
define('THEME_PATH', get_template_directory());

/*
 * Theme function
 */
require_once 'admin/themeFunctions.php';

/*
 * Asset hook
 */
require_once 'admin/asset.php';

/*
 * Admin bootstrap
 */

require_once 'admin/bootstrap.php';

if (GDS::get_option(['other_security', 'update_wordpress']) == false) {

    function remove_core_updates()
    {
        global $wp_version;
        return (object)array('last_checked' => time(), 'version_checked' => $wp_version,);
    }

    add_filter('pre_site_transient_update_core', 'remove_core_updates');
    add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
    add_filter('pre_site_transient_update_themes', 'remove_core_updates');
}

