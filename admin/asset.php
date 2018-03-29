<?php
/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 4:04 PM
 */

function custom_styles()
{

    wp_register_style('star-rating', THEME_URL . '/public/css/star-rating.min.css', false, '1.0', 'screen');
    wp_enqueue_style('star-rating');

    wp_register_style('theme-krajee-svg', THEME_URL . '/public/css/theme-krajee-svg.min.css', false, '1.0', 'screen');
    wp_enqueue_style('theme-krajee-svg');

    wp_register_style('font-awesome', THEME_URL . '/public/css/font-awesome.min.css', false, '1.0', 'screen');
    wp_enqueue_style('font-awesome');

    wp_register_style('bootstrap', THEME_URL . '/public/css/bootstrap.min.css', false, '1.0', 'screen');
    wp_enqueue_style('bootstrap');

    wp_register_style('bootstrap-datapicker', THEME_URL . '/admin/asset/css/bootstrap-datepicker.min.css', false, '1.0', 'screen');
    wp_enqueue_style('bootstrap-datapicker');

    wp_register_style('gds', THEME_URL . '/admin/asset/css/gds.css', false, '1.0', 'screen');
    wp_enqueue_style('gds');

    wp_register_style('lightslider', THEME_URL . '/public/css/lightslider.css', false, '1.0', 'screen');
    wp_enqueue_style('lightslider');

}

add_action('wp_enqueue_scripts', 'custom_styles');

function custom_script()
{
    wp_register_script('my_jquery', THEME_URL . '/public/js/jquery.min.js', array(), false, true);
    wp_enqueue_script('my_jquery', false, null, false, true);

    wp_register_script('bootstrap', THEME_URL . '/public/js/bootstrap.min.js', array(), false, true);
    wp_enqueue_script('bootstrap', false, null, false, true);

    wp_register_script('bootstrap-datapicker', THEME_URL . '/admin/asset/js/bootstrap-datepicker.min.js', array(), false, true);
    wp_enqueue_script('bootstrap-datapicker', false, null, false, true);

    wp_register_script('star-rating', THEME_URL . '/public/js/star-rating.min.js', array(), false, true);
    wp_enqueue_script('star-rating', false, null, false, true);

    wp_register_script('lightslider', THEME_URL . '/public/js/lightslider.js', array(), false, true);
    wp_enqueue_script('lightslider', false, null, false, true);

    wp_register_script('sticky-kit', THEME_URL . '/public/js/jquery.sticky-kit.min.js', array(), false, true);
    wp_enqueue_script('sticky-kit', false, null, false, true);

    wp_register_script('custom-js', THEME_URL . '/public/js/custom.js', array(), false, true);
    wp_enqueue_script('custom-js', false, null, false, true);

}

add_action('wp_enqueue_scripts', 'custom_script');


add_action('wp_footer', 'load_js_star', 100);
function load_js_star()
{
    echo '<script>',
    "$('.rating-loading').rating({
        displayOnly: true,
        min:0,
        step: 0.5,
        max:5,
        theme: 'krajee-fa',
        filledStar: '<i class=\"fa fa-star\"></i>',
        emptyStar: '<i class=\"fa fa-star-o\"></i>'
    });",
    '</script>';
}

function google_captcha_script()
{
    echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
}

function ajaxurl()
{
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php }

function validator()
{
    wp_register_script('validator', THEME_URL . '/admin/asset/js/validator.js', array(), false, true);
    wp_enqueue_script('validator', false, null, false, true);
}


function payment()
{
    wp_register_script('payment', THEME_URL . '/admin/asset/js/payment.js', array(), false, true);
    wp_enqueue_script('payment', false, null, false, true);
}