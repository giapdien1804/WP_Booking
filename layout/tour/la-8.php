<div class="row">
    <?php
    global $the_query;
    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="content-blog-full-main">
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <figure class="item-scroll">
                            <a class="thumbnail-blog-post border-img" href="<?php the_permalink(); ?>"
                               title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('col_three', ['title' => get_the_title()]); ?>
                            </a>
                            <?php if (tour_meta::show_label('feature')): ?>
                                <div class="st-featured position-top">Featured</div>
                            <?php endif; ?>
                            <?php if (tour_meta::show_label('best_sale')): ?>
                                <div class="st-bestseller"><span>Bestseller</span></div>
                            <?php endif; ?>
                        </figure>
                    </div>
                    <div class="col-sm-12 col-md-7 col-lg-7 content-block-blog">
                        <div>
                            <a class="title-blog" title="<?php the_title_attribute(); ?>"
                               href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <?php if (!empty(tour_meta::check_star())) { ?>
                                <div class="star-review">
                                    <?php tour_meta::star(); ?>
                                </div>
                            <?php } ?>
                            <p class="footer-category-content">
                                <?php if (tour_meta::duration(false)) : ?>
                                    <span title="Durations"><i
                                                class="fa fa-calendar"></i>Duration: <?php tour_meta::duration(); ?></span>
                                <?php endif; ?>
                                <?php if (tour_meta::group_size(false)) : ?>
                                    <span title="Group size"><i
                                                class="fa fa-users"></i>Group size: <?php tour_meta::group_size(); ?></span>
                                <?php endif; ?>
                            </p>
                            <div class="highlight-cate"><?php tour_meta::highlight() ?></div>
                            <hr class="hr">
                            <div class="price-right-column">
                                <?php if (tour_meta::price_from(false)) : ?>
                                    <div class="pull-left">
                                        Price from <?php tour_meta::price_old(); ?><?php tour_meta::price_from(); ?>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= GDS::do_book_link() ?>" class="btn btn-blue">Book Now</a>
                                    </div>
                                <?php else: ?>
                                    <div class="pull-right">
                                        <a href="/<?= GDS::get_option(['booking_page', 'contact']) ?>"
                                           class="btn btn-blue">Contact</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); endif; ?>
</div>
