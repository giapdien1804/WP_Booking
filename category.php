<?php get_header(); ?>
    <div class="content margin-bottom-50">
        <div id="mainBanner" class="class-main-banner"
             style="background-image: url(<?php echo GDS::get_option(['option_text', 'header_bg']) ?>);"></div>
        <div class="container page-content">
            <div class="the-breadcrumb margin-bottom-30 breadcrumb-cate">
                <?php if (function_exists('custom_breadcrumb')) {
                    custom_breadcrumb();
                } ?>
            </div>
            <div class="row">
                <div class="content-con" data-sticky_parent="">
                    <div id="sidebar" data-sticky_column="" class="col-sm-5 col-md-4 col-lg-4"
                         style="position: inherit">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="sidebar">
                                    <?php if (is_active_sidebar('widget_home_sidebar')) {
                                        dynamic_sidebar('widget_home_sidebar');
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-8" data-sticky_column="">
                        <div>
                            <h1 class="title-category text-capitalize margin-top-0">
                                <?php single_cat_title(); ?>
                            </h1>
                        </div>
                        <hr class="hr-cate">
                        <?php if (category_description()) {
                            echo "<div class='margin-bottom-30'>" . category_description() . "</div>";
                        } ?>
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <?php get_template_part('include/category', 'post'); ?>
                        <?php endwhile;
                            wp_reset_postdata(); ?>

                            <?php get_template_part('include/paginate'); ?>
                        <?php else:
                            get_template_part('content', 'none');
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>