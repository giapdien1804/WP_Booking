<div class="col-sm-12">
    <div class="item-package">
        <div class="item-package-img">
            <figure>
                <a href="<?php the_permalink(); ?>" class="thumbnail-img" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?>
                    <span class="text-capitalize item-col-title"><?php the_title(); ?></span>
                </a>
                <?php if (!empty(tour_meta::check_star())) { ?>
                    <div class="star-icon star-col">
                        <?php tour_meta::star(); ?>
                    </div>
                <?php } ?>
            </figure>
            <?php if (tour_meta::price_from(false) && tour_meta::price_old(false)) : ?>
                <span class="st-percent"><?php tour_meta::check_price_sales(); ?></span>
            <?php endif; ?>
        </div>
        <div class="margin-top-10">
            <?php if (tour_meta::duration(false)) : ?>
                <div>
                    <span class="span-day">
                        <span class="font-size-18"><?= tour_meta::explode_duration(true); ?></span><br>
                        <?= tour_meta::explode_duration(false); ?>
                    </span>
                </div>
            <?php endif; ?>
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
            <p class="margin-top-10"><?php echo LIP::excerpt(25); ?></p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>