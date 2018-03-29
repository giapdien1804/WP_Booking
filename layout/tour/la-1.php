<div class="row">
    <div class="responsive-slide">
        <?php
        /**
         * @var $the_query WP_Query
         **/
        global $the_query;
        if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="item-package">
                    <div class="item-package-img">
                        <figure>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                               class="thumbnail-img"><?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?></a>
                        </figure>
                        <?php if (tour_meta::show_label('feature')): ?>
                            <div class="st-featured position-top">Featured</div>
                        <?php endif; ?>
                        <?php if (tour_meta::show_label('best_sale')): ?>
                            <div class="st-bestsellers"><span>Bestseller</span></div>
                        <?php endif; ?>
                        <?php if (tour_meta::price_from(false) && tour_meta::price_old(false)) : ?>
                            <span class="st-percent"><?php tour_meta::check_price_sales(); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="item-package-content">
                        <a class="text-capitalize item-package-title" title="<?php the_title_attribute(); ?>"
                           href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <div class="star-icon">
                            <?php tour_meta::star(); ?>
                        </div>
                        <div class="pull-left item-package-ds">
                            <?php if (tour_meta::duration(false)) : ?>
                                <span><i class="fa fa-calendar"></i> Duration: <?= tour_meta::explode_duration(true); ?> <?= tour_meta::explode_duration(false); ?></span> &#124;
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
                        <hr class="hr">
                        <div class="item-package-highlight">
                            <?php if (tour_meta::highlight(false)) : tour_meta::highlight(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile;
            wp_reset_postdata(); endif; ?>
    </div>
</div>
