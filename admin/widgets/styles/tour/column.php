<div class="col-sm-6 col-md-4 col-lg-4 margin-bottom-30">
    <div class="item-package">
        <div class="item-package-img">
            <figure>
                <a href="<?php the_permalink(); ?>" class="thumbnail-img">
                    <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                    <span class="text-capitalize most-col-title" href=""><?php the_title(); ?></span>
                </a>
            </figure>
        </div>
        <div class="">
            <div class="star-icon pull-left margin-top-10">
                <?php tour_meta::star(); ?>
            </div>
            <div class="pull-right">
                <div class="pull-left item-package-ds text-bold">
                    <?php if (tour_meta::duration(false)) : ?>
                        <span><i class=" fa fa-clock-o"></i> Duration: <?= tour_meta::explode_duration(true); ?> <?= tour_meta::explode_duration(false); ?></span> |
                    <?php endif; ?>
                    <?php if (tour_meta::group_size(false)) : ?>
                        <span><i class="fa fa-users"></i> Group size: <?php tour_meta::group_size(); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php if (tour_meta::price_from(false)) : ?>
                <div class="item-package-price">
                    Price from<?php tour_meta::price_old(); ?>
                    <?php tour_meta::price_from(); ?>
                </div>
            <?php else: ?>
                <div class="item-package-price">
                    Price:<span class="price-new">Contact</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>