<div class="row">
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

    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
        <div class="col-sm-6 fix-col-50 col-md-4 col-lg-4">
            <div class="item-package">
                <figure class="item-scroll">
                    <a href="<?php the_permalink(); ?>" class="thumbnail-img border-img-top">
                        <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                    </a>
                    <?php if (tour_meta::show_label('feature')): ?>
                        <div class="st-featured position-top">Featured</div>
                    <?php endif; ?>
                    <?php if (tour_meta::show_label('best_sale')): ?>
                        <div class="st-bestseller"><span>Bestseller</span></div>
                    <?php endif; ?>
                    <?php if (tour_meta::price_from(false)) : ?>
                        <div class="price-scroll price-package">
                            Price from<?php tour_meta::price_old(); ?>
                            <?php tour_meta::price_from(); ?>
                        </div>
                    <?php else: ?>
                        <div class="price-scroll price-package">
                            Price:<span class="price-new">Contact</span>
                        </div>
                    <?php endif; ?>
                    <p class="footer-package">
                        <?php if (tour_meta::duration(false)) : ?>
                            <span title="Durations"><i
                                        class="fa fa-calendar"></i> <?php tour_meta::duration(); ?></span> &#124;
                        <?php endif; ?>
                        <?php if (tour_meta::group_size(false)) : ?>
                            <span title="Group size"><i
                                        class="fa fa-users"></i> <?php tour_meta::group_size(); ?></span>
                        <?php endif; ?>
                    </p>
                </figure>
                <div class="caption-package">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                       class="title-package text-capitalize">
                        <?php the_title(); ?>
                    </a>
                    <?php if (!empty(tour_meta::check_star())) { ?>
                        <div class="star-review">
                            <?php tour_meta::star(); ?>
                        </div>
                    <?php } ?>
                    <p><?php echo LIP::excerpt(27); ?></p>
                </div>
            </div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); endif; ?>
</div>
