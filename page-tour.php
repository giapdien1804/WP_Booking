<?php
/*
 * Template Name: Tour
 */
get_header(); ?>


    <div class="content">
        <div id="mainBanner"
             style="background-image: url(<?php echo GDS::get_option(['option_text', 'header_bg']) ?>);">
            <?php get_template_part('include/search', 'home'); ?>
        </div>
        <div class="the-breadcrumb margin-bottom-30 padding-top-25">
            <div class="container">
                <div class="pull-left">
                    <?php if (function_exists('custom_breadcrumb')) {
                        custom_breadcrumb();
                    } ?>
                </div>
                <div class="pull-right">
                    <div class="support float-right">
                        <small><span class="support"></span><a href="javascript:;" data-toggle="modal"
                                                               data-target="#modalEmail">Need help?</a>
                        </small> <?php echo GDS::get_option(['other_contact', 'hotline']) ?></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="container content-responsive-img margin-bottom-50">
            <?php
            if (have_posts()) {
                the_post(); ?>
                <div class="content-responsive-img">
                    <div>
                        <h1 class="title-category text-capitalize"><?php the_title(); ?></h1>
                        <hr class="hr-cate">
                    </div>
                    <?php the_content(); ?>
                </div>
                <?php wp_reset_postdata();
            }
            ?>
            <div class="tour-search-box margin-bottom-30">
                <span>Filter: </span>
                <?php
                $get_label = isset($_GET['label']) ? $_GET['label'] : '';
                $get_location = isset($_GET['tour_search_location']) ? $_GET['tour_search_location'] : '';
                $get_price = isset($_GET['tour_search_price_range']) ? $_GET['tour_search_price_range'] : tour_meta::price_range()->min . ',' . tour_meta::price_range()->max;
                $get_duration = isset($_GET['tour_search_howlong']) ? $_GET['tour_search_howlong'] : '';

                $label = LIP::showLabel_list();
                $page_tour = GDS::get_option(['post_tour', 'page']);

                if (get_query_var('paged')) {
                    $paged = get_query_var('paged');
                } elseif (get_query_var('page')) {
                    $paged = get_query_var('page');
                } else {
                    $paged = 1;
                }

                $search_link = "&tour_search_location={$get_location}&tour_search_price_range={$get_price}&tour_search_howlong={$get_duration}";
                foreach ($label as $item => $value) {
                    $ls = ($item == $get_label) ? 'select-link-search' : '';
                    $make_link = /*@gds_note loc label theo tung trang ket qua ($paged > 1) ? "/{$page_tour}/page/{$paged}?label={$item}{$search_link}" : */
                        "/{$page_tour}?label={$item}{$search_link}";
                    echo "<a class='{$ls}' href='{$make_link}'>{$value}</a>";
                }
                ?>
            </div>
            <?php
            global $wp_query;

            /*
             * @gds_note tao query search tour
             */
            //show label
            $qr_label = ($get_label != '') ? [
                [
                    'relation' => 'AND',
                    [
                        'key' => 'tour_show_label',
                        'compare' => '='
                    ],
                    [
                        'key' => 'tour_show_label',
                        'value' => serialize($get_label) . serialize('1'),
                        'compare' => 'LIKE'
                    ]
                ]

            ] : [];
            //location
            $qr_location = ($get_location != '') ? [
                [
                    'relation' => 'AND',
                    [
                        'key' => 'tour_location',
                        'compare' => '='
                    ],
                    [
                        'key' => 'tour_location',
                        'value' => $get_location,
                        'compare' => '='
                    ]
                ]

            ] : [];
            //duration
            $qr_duration = ($get_duration != '') ? [
                [
                    'key' => 'tour_duration',
                    'value' => $get_duration,
                    'compare' => '='
                ]

            ] : [];
            //price
            $qr_price = ($get_price != '') ? [
                [
                    'key' => 'tour_price_from',
                    'value' => explode(',', $get_price),
                    'type' => 'numeric',
                    'compare' => 'BETWEEN'
                ]

            ] : [];

            $find = array_merge($qr_label, $qr_location, $qr_duration, $qr_price);
            $args = [
                'post_type' => 'tour',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_key' => 'tour_price_from',
                'post_status' => 'publish',
                'paged' => $paged,
                'meta_query' => [
                    'relation' => 'AND',
                    $find
                ]
            ];

            $wp_query = new WP_Query($args);
            ?>
            <?php
            if (have_posts()):
                while (have_posts()) {
                    the_post();
                    get_template_part("taxonomy/tour");
                } ?>

                <div class="pagination-page">
                    <?php
                    get_template_part('include/paginate');
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else: ?>
                <div class="not-found-tailor" style="padding: 20px;">
                    <p class="margin-bottom-30"><strong>Nothing tour found.</strong></p>
                    <h2 class="title-category text-capitalize">Create your trip now</h2>
                    <?= do_shortcode('[tailor_made]') ?>
                </div>
            <?php endif; ?>
        </div>
        <?php echo GDS::get_option(['option_text', 'box_contact_us']) ?>
    </div>

<?php get_footer(); ?>