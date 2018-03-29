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

<div class="row row-render">
    <?php
    if ($the_query->have_posts()): while ($the_query->have_posts()):
        $the_query->the_post(); ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-render">
            <figure class="item-list-content">
                <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" class="thumbnail-img">
                    <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                    <span><?php the_title(); ?></span>
                </a>
            </figure>
        </div>
    <?php endwhile;
        wp_reset_postdata();
    endif; ?>
</div>


