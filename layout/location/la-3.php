<?php
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
?>

<div class="row" style="margin:0">
    <?php
    if ($the_query->have_posts()): while ($the_query->have_posts()):
        $the_query->the_post(); ?>
        <div class="col-sm-6 col-md-6 col-lg-6" style="padding:0">
            <figure class="item-scroll item-gallery text-capitalize">
                <a href="<?php the_permalink(); ?>" class="thumbnail-img border-img">
                    <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                </a>
                <figcaption class="caption-scroll text-center">
                    <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"
                       class="title-scroll font-size-gallery"><?php the_title(); ?></a>
                </figcaption>
            </figure>
        </div>
    <?php endwhile;
        wp_reset_postdata();
    endif; ?>
</div>


