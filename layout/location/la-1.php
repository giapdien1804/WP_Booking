<div class="row row-render">
    <?php
    /**
     * @var $the_query WP_Query
     */
    global $the_query;

    $count = 1;
    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
        <?php if ($count == 1): ?>
            <div class="col-sm-6 col-md-4 col-lg-4 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php if ($count == 2): ?>
            <div class="col-sm-6 col-md-4 col-lg-4 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php if ($count == 3): ?>
            <div class="col-sm-6 col-md-4 col-lg-4 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php if ($count == 4): ?>
            <div class="col-sm-6 col-md-6 col-lg-6 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php if ($count == 5): ?>
            <div class="col-sm-6 col-md-6 col-lg-6 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php if ($count == 6): ?>
            <div class="col-sm-6 col-md-4 col-lg-4 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php if ($count == 7): ?>
            <div class="col-sm-6 col-md-4 col-lg-4 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php if ($count == 8): ?>
            <div class="col-sm-6 col-md-4 col-lg-4 col-render">
                <figure class="item-list-content">
                    <a class="thumbnail-img" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        <span title="<?php the_title_attribute(); ?>"><?php the_title(); ?></span>
                    </a>
                </figure>
            </div>
        <?php endif; ?>
        <?php $count++; endwhile;
        wp_reset_postdata(); endif; ?>
</div>
