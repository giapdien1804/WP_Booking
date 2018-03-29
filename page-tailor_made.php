<?php
/**
 * Template Name: Tailor made
 * Created by giapdien.
 * User: giapdien
 * email: giapdien1804@gmail.com | traihogiap@hotmail.com
 * Date: 16/05/2016
 * Time: 4:08 CH
 */

get_header(); ?>
<div class="content margin-bottom-50">
    <div id="mainBanner" class="class-main-banner"
         style="background-image: url(<?php echo GDS::get_option(['option_text', 'header_bg']) ?>);"></div>
    <div class="container page-content">
        <div class="the-breadcrumb margin-bottom-30 breadcrumb-cate">
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
        <div class="clearfix"></div>
        <?php if (have_posts()) : the_post(); ?>
            <div class="row">
                <div class="content-con" data-sticky_parent="">
                    <div class="col-sm-7 col-md-8 col-lg-8 content-responsive-img page-line">
                        <div>
                            <h1 class="title-category text-capitalize text-bold margin-bottom-10">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                        <?php the_content(); ?>
                        <?php echo do_shortcode('[tailor_made]'); ?>
                    </div>
                    <div id="sidebar" data-sticky_column="" class="col-sm-5 col-md-4 col-lg-4"
                         style="position: inherit">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php get_sidebar(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php wp_reset_postdata(); endif; ?>
    </div>
</div>
<?php get_footer(); ?>
