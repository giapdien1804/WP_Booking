<div class="row">
    <?php
    global $the_query;
    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
        <div class="col-sm-12">
            <div class="media">
                <div class="media-left">
                    <a class="border-img" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('img_small', ['title' => get_the_title()]); ?>
                    </a>
                </div>
                <div class="media-body">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                       class="media-heading"><?php the_title(); ?></a>
                    <div class="caption-media">
                        <?php if (!empty(tour_meta::check_star())) { ?>
                            <div class="star-review pull-left">
                                <?php tour_meta::star() ?>
                            </div>
                        <?php } ?>
                        <?php if (tour_meta::price_from(false)) : ?>
                            <div class="price-media pull-right">
                                Price from <?php tour_meta::price_old(); ?><?php tour_meta::price_from(); ?>
                            </div>
                        <?php else: ?>
                            <div class="price-media pull-right">
                                Price: <span class="price-new">Contact</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); endif; ?>
</div>
