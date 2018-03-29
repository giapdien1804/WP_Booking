<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 4:15 PM
 */


function custom_theme_features()
{
    // Add theme support for Automatic Feed Links
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');

    // Add theme support for Custom Background
    $background_args = array(
        'default-color' => '',
        'default-image' => '',
        'default-repeat' => 'repeat',
    );
    add_theme_support('custom-background', $background_args);

    // Add theme support for Custom Header
    $header_args = array(
        'default-image' => '',
        'width' => 0,
        'height' => 0,
        'flex-width' => false,
        'flex-height' => false,
        'uploads' => true,
        'random-default' => false,
        'header-text' => true,
    );
    add_theme_support('custom-header', $header_args);

    // Add theme support for HTML5 Semantic Markup
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // Add theme support for document Title tag
    add_theme_support('title-tag');

    // Add theme support for Translation
    load_theme_textdomain('viigmt', get_template_directory() . '/language');
}

add_action('after_setup_theme', 'custom_theme_features');

/*
 * Register Menu
 */
function create_menu()
{
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'viigmt'),
        'footer-menu-left' => __('Footer menu left', 'viigmt'),
        'footer-menu-right' => __('Footer menu right', 'viigmt'),
        'header-menu-left' => __('Header menu left', 'viigmt'),
        'header-menu-right' => __('Header menu right', 'viigmt')
    ));
}

add_action('after_setup_theme', 'create_menu');

/*
 * Register Sidebar
 */
function theme_sidebar()
{
    $args = [
        'name' => __('Default Sidebar', '7gmt'),
        'id' => 'widget_default_sidebar',
        'description' => 'Default Sidebar',
        'class' => 'default-sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s not-found-tailor admin_page_framework_widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-sidebar-framework text-capitalize">',
        'after_title' => '</h3>'];
    register_sidebar($args);

    $args = [
        'name' => __('Category Sidebar', '7gmt'),
        'id' => 'widget_home_sidebar',
        'description' => 'Category Sidebar',
        'class' => 'home-sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-sidebar-framework text-capitalize">',
        'after_title' => '</h3>'];
    register_sidebar($args);

    $args = [
        'name' => __('Booking Sidebar', '7gmt'),
        'id' => 'widget_booking_sidebar',
        'description' => 'Booking Sidebar',
        'class' => 'booking-sidebar',
        'before_widget' => '<div class="post-related">',
        'after_widget' => '</div>',
        'before_title' => '<header ><h2 class="title-sidebar-framework text-capitalize">',
        'after_title' => '</h2>'];
    register_sidebar($args);

    $args = array(
        'id' => 'footer_sidebar_1',
        'class' => 'sidebar-footer-1',
        'name' => __('Footer sidebar 1', 'viigmt'),
        'description' => __('Widget for footer sidebar', 'viigmt'),
        'before_title' => '<h4 class="title-col-footer">',
        'after_title' => '</h4>',
        'before_widget' => '<div class="col-sm-12 col-md-4 col-lg-4"><div class="col-footer">',
        'after_widget' => '</div></div>',
    );
    register_sidebar($args);

    $args = array(
        'id' => 'footer_sidebar_2',
        'class' => 'sidebar-footer-2',
        'name' => __('Footer sidebar 2', 'viigmt'),
        'description' => __('Widget for footer sidebar', 'viigmt'),
        'before_title' => '<h4 class="title-col-footer">',
        'after_title' => '</h4>',
        'before_widget' => '<div class="col-sm-6 col-md-2 col-lg-2"><div class="col-footer">',
        'after_widget' => '</div></div>',
    );
    register_sidebar($args);

    $args = array(
        'id' => 'home_widget_1',
        'class' => 'home-widget-1',
        'name' => __('Footer sidebar 3', 'viigmt'),
        'description' => __('Footer sidebar 3', 'viigmt'),
        'before_title' => '<h4 class="title-col-footer">',
        'after_title' => '</h4>',
        'before_widget' => '<div class="col-sm-6 col-md-2 col-lg-2"><div class="col-footer">',
        'after_widget' => '</div></div>',
    );
    register_sidebar($args);

    $args = array(
        'id' => 'home_widget_2',
        'class' => 'home-widget-2',
        'name' => __('Footer sidebar 4', 'viigmt'),
        'description' => __('Footer sidebar 4', 'viigmt'),
        'before_title' => '<h4 class="title-col-footer">',
        'after_title' => '</h4>',
        'before_widget' => '<div class="col-sm-12 col-md-4 col-lg-4"><div class="col-footer">',
        'after_widget' => '</div></div>',
    );
    register_sidebar($args);

    $args = array(
        'id' => 'home_widget_3',
        'class' => 'home-widget-3',
        'name' => __('Home widget 1', 'viigmt'),
        'description' => __('Widget for home page', 'viigmt'),
        'before_title' => '<h2>',
        'after_title' => '</h2>',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
    );
    register_sidebar($args);

    $args = array(
        'id' => 'home_widget_4',
        'class' => 'home-widget-4',
        'name' => __('Home widget 2', 'viigmt'),
        'description' => __('Widget for home page', 'viigmt'),
        'before_title' => '<h2>',
        'after_title' => '</h2>',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
    );
    register_sidebar($args);

}

add_action('widgets_init', 'theme_sidebar');

function fix_pagination()
{
    if ((is_category() || is_tag() || is_page() || is_paged() || is_tax(LIP::get_taxonomy_list())) && !is_admin())
        set_query_var('post_type', array_keys(LIP::get_post_type_list(['page' => 'Page'])));
    return;
}

add_action('parse_query', 'fix_pagination');


function custom_breadcrumb()
{
    global $post;
    if (!is_home()) {
        echo '<ol class="breadcrumb text-capitalize" itemscope itemtype="http://schema.org/BreadcrumbList">';
        echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemscope itemtype="http://schema.org/Thing"
      itemprop="item" href="' . get_option('home') . '"><span itemprop="name"><i class="fa fa-home"></i></span></a><meta itemprop="position" content="1" /></li>';
        if (is_singular(array_keys(LIP::get_post_type_list()))) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            $term_list = wp_get_post_terms($post->ID, ['tour_category', 'location_category', 'category', 'service_category'], array("fields" => "all"));
            if ($term_list == null) echo 'Location';
            foreach ($term_list as $term) {

                // The $term is an object, so we don't need to specify the $taxonomy.
                $term_link = get_term_link($term);

                // If there was an error, continue to the next term.
                if (is_wp_error($term_link)) {
                    continue;
                }

                // We successfully got a link. Print it out.
                echo '<a itemscope itemtype="http://schema.org/Thing"
      itemprop="item" class="cate_bread" href="' . esc_url($term_link) . '"><span>' . $term->name . '</span></a>';

            }
            echo '<meta itemprop="position" content="2" /></li>';
            if (is_singular(array_keys(LIP::get_post_type_list()))) {
                echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                the_title();
                echo '<meta itemprop="position" content="3" /></li>';
            }
        } elseif (is_category() || is_tax(LIP::get_taxonomy_list())) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            single_cat_title();
            echo '<meta itemprop="position" content="2" /></li>';

        } elseif (is_page() && (!is_front_page())) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            the_title();
            echo '<meta itemprop="position" content="2" /></li>';
        } elseif (is_tag()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            single_tag_title();
            echo '<meta itemprop="position" content="2" /></li>';
        } elseif (is_day()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            the_time('F jS, Y');
            echo '<meta itemprop="position" content="2" /></li>';
        } elseif (is_month()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            the_time('F, Y');
            echo '<meta itemprop="position" content="2" /></li>';
        } elseif (is_year()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            the_time('Y');
            echo '<meta itemprop="position" content="2" /></li>';
        } elseif (is_author()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            echo '<meta itemprop="position" content="2" /></li>';
        } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
            echo '<meta itemprop="position" content="2" /></li>';
        } elseif (is_search()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">Search Results';
            echo '<meta itemprop="position" content="2" /></li>';
        }
        echo '</ol>';
    }
}

/*
 * Remove tag in comment
 */
/**
 *
 */
function customise_allowed_html_tag()
{
    global $allowed_tags;
    $unwanted = array('a', 'div', 'script', 'style');
    foreach ($unwanted as $tag) unset ($allowed_tags[$tag]);
}

add_action('init', 'customise_allowed_html_tag');

/**
 * @param $postID
 */
function wpb_set_post_views($postID)
{
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

/**
 * @param $post_id
 */
function wpb_track_post_views($post_id)
{
    if (!is_singular(array_keys(LIP::get_post_type_list()))) return;
    if (empty ($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}

add_action('wp_head', 'wpb_track_post_views');

add_action('init', 'myStartSession', 1);

/**
 *
 */
function myStartSession()
{
    if (!session_id()) {
        session_start();
    }
}

/**
 *
 */
function save_post_view()
{
    if (isset($_GET['booking'])) {
        global $wpdb;
        $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '" . $_GET['booking'] . "'");

        if (!isset($_SESSION['client_view'])) {
            $_SESSION['client_view'][0] = $post_id;
        }
    }

    if (!is_singular(array_keys(LIP::get_post_type_list()))) return;
    global $post;

    if (!isset($_SESSION['client_view'])) {
        $_SESSION['client_view'][0] = $post->ID;
    } else {
        $num = count($_SESSION['client_view']);
        $db = $_SESSION['client_view'];
        foreach ($db as $v) {
            if ($v != $post->ID)
                $_SESSION['client_view'][$num + 1] = $post->ID;
        }
    }
}

add_action('wp_head', 'save_post_view');

