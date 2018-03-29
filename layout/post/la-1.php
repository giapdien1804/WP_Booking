<div class="row">
    <?php
    global $the_query;
    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
        <div class="col-sm-6 col-md-4 col-lg-4">
            <div class="margin-bottom-30">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <figure class="item-package-img">
                            <a class="thumbnail-img"
                               href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?></a>
                        </figure>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="caption-blog caption-package">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                               class="text-capitalize item-package-title font-size-18 text-600 margin-top-10">
                                <?php the_title(); ?>
                            </a>
                            <p><?php echo LIP::excerpt(28); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); endif; ?>
</div>