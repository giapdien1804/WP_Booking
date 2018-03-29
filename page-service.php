<?php
/*
 * Template Name: Service
 */
get_header(); ?>
    <div class="content margin-bottom-50">
        <div id="mainBanner" class="class-main-banner"
             style="background-image: url(<?php echo GDS::get_option(['option_text', 'header_bg']) ?>);"></div>
        <div class="container page-content">
            <div class="the-breadcrumb margin-bottom-30 breadcrumb-cate padding-top-25">
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
            <div class="row">
                <div class="content-con" data-sticky_parent="">
                    <div class="col-md-12">
                        <div class="tour-search-box-label">
                            <?php
                            $get_label = isset($_GET['label']) ? $_GET['label'] : '';
                            $get_keyword = isset($_GET['service_search_keyword']) ? $_GET['service_search_keyword'] : '';

                            $label = LIP::showLabel_list();
                            $page_service = GDS::get_option(['post_service', 'page']);

                            if (get_query_var('paged')) {
                                $paged = get_query_var('paged');
                            } elseif (get_query_var('page')) {
                                $paged = get_query_var('page');
                            } else {
                                $paged = 1;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-8 page-line">
                        <?php
                        global $wp_query;

                        /*
                         * @gds_note tao query search service
                         */
                        $args = [
                            'post_type' => 'service',
                            's' => $get_keyword,
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            'meta_key' => 'service_price_from',
                            'post_status' => 'publish',
                            'paged' => $paged,
                            'meta_query' => [
                                'relation' => 'AND',
                                [
                                    'key' => 'service_show_label',
                                    'compare' => '='
                                ],
                                [
                                    'key' => 'service_show_label',
                                    'value' => serialize($get_label) . serialize('1'),
                                    'compare' => 'LIKE'
                                ]
                            ]
                        ];

                        $wp_query = new WP_Query($args);
                        ?>
                        <div class="row">
                            <?php
                            if (have_posts()):
                                while (have_posts()) {
                                    the_post();
                                    get_template_part("taxonomy/service");
                                } ?>

                                <div class="col-sm-12 col-sm-12">
                                    <?php
                                    get_template_part('include/paginate');
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <p class="margin-bottom-30"><strong>Nothing tour found.</strong></p>
                                    <h2 class="title-category text-capitalize">Create your trip now</h2>
                                    <?= do_shortcode('[tailor_made]') ?>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="sidebar" data-sticky_column="" class="col-sm-5 col-md-4 col-lg-4"
                         style="position: inherit">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php get_sidebar() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>