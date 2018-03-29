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
     **/

    global $the_query;
    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
        <div class="col-sm-6 fix-col-50 col-md-4 col-lg-4">
            <div class="item-scroll">
                <figure class="item-scroll text-capitalize">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                       class="thumbnail thumbnail-remove">
                        <?php the_post_thumbnail('img_three_equal', ['title' => get_the_title()]); ?>
                    </a>
                    <figcaption class="caption-scroll text-center">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                           class="title-scroll"><?php the_title(); ?></a>
                        <?php if (service_meta::price_from(false)) : ?>
                            <div class="price-scroll">
                                From <?php service_meta::price_old(); ?><?php service_meta::price_from(); ?>/pax
                            </div>
                        <?php endif; ?>
                    </figcaption>
                    <div class="item-bottom-scroll">
                        <div class="pull-left">
                            <div class="">
                                <?php if (service_meta::group_size(false)) : ?>
                                    <span data-toggle="tooltip" data-placement="bottom"
                                          title="Group size"><i
                                                class="fa fa-users"></i> <?php service_meta::group_size(); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-blog btn-search-aside">view
                                more</a>
                        </div>
                    </div>
                </figure>
            </div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); endif; ?>
</div>

