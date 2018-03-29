<div class="content-category">
    <div class="row">
        <div class="col-sm-6 col-md-5 col-lg-5">
            <div class="item-package">
                <div class="item-package-img">
                    <figure>
                        <a class="thumbnail-img" title="<?php the_title_attribute(); ?>"
                           href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?></a>
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
            </div>
        </div>
        <div class="col-sm-6 col-md-7 col-lg-7">
            <div class="item-package-content">
                <a class="text-capitalize item-package-title text-600 text-green"
                   title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <?php if (!empty(tour_meta::check_star())) { ?>
                    <div class="star-icon">
                        <?php tour_meta::star(); ?>
                    </div>
                <?php } ?>
                <div class="pull-left item-package-ds">
                    <?php if (tour_meta::duration(false)) : ?>
                        <span><i class=" fa fa-clock-o"></i> Duration: <?= tour_meta::explode_duration(true); ?> <?= tour_meta::explode_duration(false); ?></span> &#124;
                    <?php endif; ?>
                    <?php if (tour_meta::group_size(false)) : ?>
                        <span><i class="fa fa-users"></i> Group size: <?php tour_meta::group_size(); ?></span>
                    <?php endif; ?>
                </div>
                <div class="pull-right item-package-price">
                    <?php if (tour_meta::price_from(false)) : ?>
                        Price from <?php tour_meta::price_old(); ?><?php tour_meta::price_from(); ?>
                    <?php else: ?>
                        <a href="/<?= GDS::get_option(['booking_page', 'contact']) ?>" class="btn btn-green text-bold">Contact</a>
                    <?php endif; ?>
                </div>
                <div class="clearfix"></div>
                <p class="the-content-category"><?php echo LIP::excerpt(100); ?></p>
            </div>
        </div>
    </div>
</div>