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
                                <?php if (is_active_sidebar('widget_home_sidebar')) {
                                    dynamic_sidebar('widget_home_sidebar');
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-8" data-sticky_column="">
                        <div>
                            <h1 class="title-category text-capitalize margin-top-0">
                                <?php
                                if (is_tag()) : printf(__(' %1$s', '7gmt'), single_tag_title('', false));
                                elseif (is_category()) : printf(__(' %1$s', '7gmt'), single_cat_title('', false));
                                elseif (is_day()) :printf(__(' %1$s', '7gmt'), get_the_time('l, F j, Y'));
                                elseif (is_month()) :printf(__(' %1$s', '7gmt'), get_the_time('F Y'));
                                elseif (is_year()) :printf(__(' %1$s', '7gmt'), get_the_time('Y'));
                                endif;
                                ?>
                            </h1>
                        </div>
                        <hr class="hr-cate">
                        <?php if (category_description()) {
                            echo "<div class='margin-bottom-30'>" . tag_description() . "</div>";
                        } ?>
                        <?php get_template_part('content', 'tag'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>