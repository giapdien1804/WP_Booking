<div class="row">
    <?php
    /**
     * @var $the_query WP_Query
     */
    global $the_query;

    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="item-package margin-bottom-30">
                <div class="item-package-img">
                    <figure>
                        <a href="<?php the_permalink(); ?>" class="thumbnail-img"
                           title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                        </a>
                        <?php if (tour_meta::show_label('feature')): ?>
                            <div class="st-featured position-top">Featured</div>
                        <?php endif; ?>
                        <?php if (tour_meta::show_label('best_sale')): ?>
                            <div class="st-bestseller"><span>Bestseller</span></div>
                        <?php endif; ?>
                        <?php if (tour_meta::price_from(false) && tour_meta::price_old(false)) : ?>
                            <span class="st-percent"><?php tour_meta::check_price_sales(); ?></span>
                        <?php endif; ?>
                    </figure>
                </div>
                <div class="item-package-content">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                       class="text-capitalize item-package-title">
                        <?php the_title(); ?>
                    </a>
                    <?php if (!empty(tour_meta::check_star())) { ?>
                        <div class="star-icon margin-bottom-10">
                            <?php tour_meta::star(); ?>
                        </div>
                    <?php } ?>
                    <div class="pull-left item-package-ds">
                        <?php if (tour_meta::duration(false)) : ?>
                            <span><i class="fa fa-calendar"></i> Duration: <?php tour_meta::duration(); ?></span> &#124;
                        <?php endif; ?>
                        <?php if (tour_meta::group_size(false)) : ?>
                            <span><i class="fa fa-users"></i> Group size: <?php tour_meta::group_size(); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (tour_meta::price_from(false)) : ?>
                        <div class="pull-right item-package-price">
                            Price from <?php tour_meta::price_old(); ?><?php tour_meta::price_from(); ?>
                        </div>
                    <?php else: ?>
                        <div class="pull-right item-package-price">
                            <span class="price-new">Contact</span>
                        </div>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <p class="margin-top-10"><i class="fa fa-map-marker"></i>
                        <span><?= tour_meta::implode_itinerary(); ?></span></p>
                    <hr class="hr">
                    <p><?php echo LIP::excerpt(30); ?></p>

                </div>
            </div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); endif; ?>
</div>