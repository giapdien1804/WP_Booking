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
                <figure class="item-scroll text-capitalize">
                    <a href="<?php the_permalink(); ?>" class="thumbnail thumbnail-remove thumbnail-package">
                        <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                    </a>
                    <?php if (service_meta::price_from(false)) : ?>
                        <div class="price-scroll price-package">
                            <?php service_meta::price_old(); ?>
                            <?php service_meta::price_from(); ?>
                        </div>
                    <?php endif; ?>
                    <p class="footer-package">
                        <?php if (service_meta::group_size(false)) : ?>
                            <span data-toggle="tooltip" data-placement="bottom"
                                  title="Group size"><i
                                        class="fa fa-users"></i> <?php service_meta::group_size(); ?></span>
                        <?php endif; ?>
                    </p>
                </figure>
                <div class="caption-package">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                       class="title-package text-capitalize">
                        <?php the_title(); ?>
                    </a>
                    <p><?php echo LIP::excerpt(28); ?></p>
                </div>
            </div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); endif; ?>
</div>
