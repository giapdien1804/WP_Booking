<?php
/**
 * Copyright (c) 2016. giapdien1804@gmail.com
 */

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 5/7/2016
 * Time: 4:06 PM
 */

/**
 * @var $the_query WP_Query
 */

global $the_query;

$count = 1;
if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
    <?php if ($count == 1): ?>
        <div class="row">
        <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="row">
    <?php endif; ?>
    <?php if ($count <= 2): ?>
        <div class="col-sm-12 fix-col-50 col-md-6 col-lg-6">
            <figure class="item-scroll item-gallery text-uppercase">
                <a href="<?php the_permalink(); ?>" class="thumbnail thumbnail-remove">
                    <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                </a>
                <figcaption class="caption-scroll text-center">
                    <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"
                       class="title-scroll"><?php the_title(); ?></a>
                </figcaption>
            </figure>
        </div>
    <?php endif; ?>
    <?php if ($count == 3): ?>
        <div class="col-sm-12 fix-col-50 col-md-12 col-lg-12">
            <figure class="item-scroll c-item item-gallery text-uppercase">
                <a href="<?php the_permalink(); ?>" class="thumbnail thumbnail-remove">
                    <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                </a>
                <figcaption class="caption-scroll text-center">
                    <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"
                       class="title-scroll"><?php the_title(); ?></a>
                </figcaption>
            </figure>
        </div>
    <?php endif; ?>
    <?php if ($count == 3): ?>
    </div>
    </div>
<?php endif; ?>
    <?php if ($count == 4): ?>
    <div class="col-sm-6 col-md-4 col-lg-4">
    <div class="row">
    <div class="col-sm-12 fix-col-50 col-md-12 col-lg-12">
        <figure class="item-scroll item-gallery text-uppercase">
            <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"
               class="thumbnail thumbnail-remove">
                <?php the_post_thumbnail('block_2_lg', ['title' => get_the_title()]); ?>
            </a>
            <figcaption class="caption-scroll text-center">
                <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"
                   class="title-scroll"><?php the_title(); ?></a>
            </figcaption>
        </figure>
    </div>
<?php endif; ?>
    <?php if ($count == 5): ?>
        <div class="col-sm-12 fix-col-50  col-md-12 col-lg-12">
            <figure class="item-scroll item-gallery text-uppercase">
                <a href="<?php the_permalink(); ?>" class="thumbnail thumbnail-remove">
                    <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                </a>
                <figcaption class="caption-scroll text-center">
                    <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"
                       class="title-scroll"><?php the_title(); ?></a>
                </figcaption>
            </figure>
        </div>
    <?php endif; ?>
    <?php if ($count == 6): ?>
        <div class="col-sm-12 fix-col-50  col-md-12 col-lg-12">
            <figure class="item-scroll item-gallery text-uppercase">
                <a href="<?php the_permalink(); ?>" class="thumbnail thumbnail-remove">
                    <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                </a>
                <figcaption class="caption-scroll text-center">
                    <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"
                       class="title-scroll"><?php the_title(); ?></a>
                </figcaption>
            </figure>
        </div>
        </div>
        </div>
        </div>
        <?php $count = 0; endif; ?>
    <?php $count++; endwhile;
    wp_reset_postdata(); endif; ?>