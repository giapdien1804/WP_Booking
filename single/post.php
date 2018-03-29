<div id="mainBanner" class="class-main-banner"
     style="background-image: url(<?php echo GDS::get_option(['option_text', 'header_bg']) ?>);"></div>
<div class="container page-content margin-bottom-50 page-line">
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
            <div id="sidebar" data-sticky_column="" class="col-sm-5 col-md-4 col-lg-4" style="position: inherit">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (is_active_sidebar('widget_home_sidebar')) {
                            dynamic_sidebar('widget_home_sidebar');
                        } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-md-8 col-lg-8" data-sticky_column="">
                <h1 class="title-category text-capitalize margin-top-0 margin-bottom-15">
                    <?php the_title(); ?>
                </h1>
                <?php if (!empty(tour_meta::check_star())) { ?>
                    <div class="star-icons margin-bottom-10" itemprop="review" itemscope
                         itemtype="http://schema.org/Review">
                        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                            <span itemprop="name">
                                 <?php tour_meta::star(); ?>
                            </span>
                        </span>
                    </div>
                <?php } ?>
                <div class="content-responsive-img margin-bottom-50">
                    <?php the_content(); ?>
                </div>
                <?php if (get_the_tag_list()) : ?>
                    <hr class="hr-border">
                    <div class="post-tag">
                        <span class="pull-left"><i class="fa fa-tag"></i> Tags:</span>
                        <?= get_the_tag_list('<ul><li>', '</li><li>', '</li></ul>'); ?>
                    </div>
                <?php endif; ?>
                <hr class="hr-border">
                <div class="post-related margin-top-20">
                    <div>
                        <h2 class="title-category text-capitalize margin-bottom-15">Related articles</h2>
                    </div>
                    <hr class="hr-cate">
                    <div>
                        <?php
                        global $post;
                        $categories = get_the_category($post->ID);
                        if ($categories):
                            $category_ids = array();
                            foreach ($categories as $individual_category) $category_ids[] = $individual_category->term_id;
                            $args = array(
                                'category__in' => $category_ids,
                                'post__not_in' => array($post->ID),
                                'posts_per_page' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'post_type' => 'post',
                                'post_status' => 'publish'
                            );
                            $tour_reled = new WP_Query($args);
                            if ($tour_reled->have_posts()) : while ($tour_reled->have_posts()):$tour_reled->the_post(); ?>
                                <div class="media media-block">
                                    <div class="media-left">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('thumbnail', ['title' => get_the_title()]); ?>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a class="media-posts" href="<?php the_permalink(); ?>"
                                           title="<?php the_title_attribute(); ?>"
                                           class="media-heading"><?php the_title(); ?></a>
                                        <p class="description-post"><?php echo LIP::excerpt(30); ?></p>
                                    </div>
                                </div>
                            <?php endwhile;
                                wp_reset_postdata(); endif; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>