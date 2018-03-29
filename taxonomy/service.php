<div class="content-category">
    <div class="row">
        <div class="col-sm-6 col-md-5 col-lg-5">
            <div class="item-package">
                <div class="item-package-img">
                    <figure>
                        <a class="thumbnail-img" title="<?php the_title_attribute(); ?>"
                           href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?></a>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-7 col-lg-7">
            <div class="item-package-content">
                <a class="text-capitalize item-package-title text-600 text-green"
                   title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <div class="pull-left item-package-ds">
                    <?php if (service_meta::group_size(false)) : ?>
                        <span><i class="fa fa-users"></i> Group size: <?php service_meta::group_size(); ?></span>
                    <?php endif; ?>
                </div>
                <div class="pull-right item-package-price">
                    <?php if (empty(service_meta::check_price_from())) { ?>
                        <a href="/<?= GDS::get_option(['booking_page', 'contact']) ?>" class="btn btn-green text-600">Contact</a>
                    <?php } else { ?>
                        Price from <?php service_meta::price_old(); ?><?php service_meta::price_from(); ?>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
                <p class="the-content-category"><?php echo LIP::excerpt(100); ?></p>
            </div>
        </div>
    </div>
</div>