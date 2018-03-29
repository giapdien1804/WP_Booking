<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?php wp_head(); ?>
    <link href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" rel="stylesheet"/>
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <link rel="shortcut icon" href="<?php echo GDS::get_option(['option_logo', 'favicon']) ?>"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <?php if (GDS::get_option(['other_social', 'show_line_chat']) == true) echo GDS::get_option(['other_social', 'line_chat']) ?>


</head>
<body <?php body_class(); ?>>
<header>
    <nav class="navHeader" data-spy=".affix" data-offset-top="0" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php if (GDS::get_option(['option_logo', 'header_logo']) != ''): ?>
                    <a class="navbar-brand" href="<?php echo esc_html(home_url('/')); ?>"><img class="img-responsive"
                                                                                               src="<?php echo GDS::get_option(['option_logo', 'header_logo']) ?>"
                                                                                               alt="<?= get_bloginfo('title'); ?>"
                                                                                               title="<?= get_bloginfo('title'); ?>"></a>
                <?php else:
                    printf("<a href=\"%s\">%s</a>", home_url(), get_bloginfo('site_name'));
                endif;
                ?>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?php
                $args = [
                    'menu' => 'primary',
                    'menu_id' => 'primary',
                    'menu_class' => 'nav-primary',
                    'container' => 'ul',
                    'theme_location' => 'primary'
                ];
                if (has_nav_menu('primary')) {
                    wp_nav_menu($args);
                }
                ?>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
</header>