<?php
/**
 * Template Name: Contact
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
            <div class="clearfix"></div>
            <ul class="list-get-page margin-bottom-30">
                <?php $get_page_list = explode(',', GDS::get_option(['post_get_list_page']));
                $query = new WP_Query(array('post_type' => 'page', 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'menu_order', 'post__in' => $get_page_list)); ?>
                <?php if ($query->have_posts()): while ($query->have_posts()): $query->the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"
                           title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile;
                    wp_reset_postdata(); endif; ?>
            </ul>

            <?php if (have_posts()) : the_post(); ?>
                <div class="row">
                    <div class="col-lg-12 content-responsive-img page-line">
                        <div class="text-center">
                            <h1 class="title-category text-capitalize text-bold margin-bottom-15">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                        <?php the_content(); ?>
                        <?php echo do_shortcode('[site_contact_form]'); ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); endif; ?>
        </div>
    </div>
<?php get_footer(); ?>