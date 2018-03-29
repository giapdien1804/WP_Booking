<div class="media media-block">
    <div class="media-left">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail('thumbnail', ['title' => get_the_title()]); ?>
        </a>
    </div>
    <div class="media-body">
        <a class="media-posts" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
           class="media-heading"><?php the_title(); ?></a>
        <?php if (!empty(tour_meta::check_star())) : ?>
            <div class="star-icon pull-left">
                <?php tour_meta::star() ?>
            </div>
        <?php endif; ?>
        <?php if (tour_meta::price_from(false)) : ?>
            <div class="price-media pull-right">
                <?php tour_meta::price_old(); ?><?php tour_meta::price_from(); ?>
            </div>
        <?php else: ?>
            <div class="price-media pull-right">
                <span class="price-new">Contact</span>
            </div>
        <?php endif; ?>
    </div>
</div>