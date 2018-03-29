<div class="the-breadcrumb margin-bottom-30 padding-top-25">
    <div class="container">
        <div class="pull-left">
            <?php if (function_exists('custom_breadcrumb')) {
                custom_breadcrumb();
            } ?>
        </div>
        <div class="pull-right">
            <div class="support float-right">
                <small><span class="support"></span><a href="javascript:;" data-toggle="modal"
                                                       data-target="#modalEmail">Need help?</a>
                </small> <?php echo GDS::get_option(['other_contact', 'hotline']) ?></div>
        </div>
    </div>
</div>
<div class="container margin-bottom-50">
    <div class="row">
        <div class="content-con" data-sticky_parent="">
            <div class="col-sm-7 col-md-8 col-lg-8">
                <div class="content-responsive-img not-found-tailor page-line">
                    <div>
                        <h1 class="heading-title-post margin-bottom-30"><?php the_title(); ?></h1>
                    </div>
                    <div class="margin-bottom-30">
                        <div class="what-in">
                            <h4 class="text-capitalize">Details</h4>
                            <p><strong>Code:</strong> <strong><?php service_meta::code(); ?></strong></p>
                            <p class="item-package-price">
                                <strong>Price
                                    from: </strong><?php service_meta::price_old(); ?><?php service_meta::price_from(); ?>
                            </p>
                            <?php if (service_meta::itinerary(false)): ?>
                                <p><strong>Itinerary:</strong> <?php service_meta::itinerary(); ?></p>
                            <?php endif; ?>
                        </div>
                        <hr class="hr-border">
                    </div>
                    <?php if (service_meta::highlight(false)): ?>
                        <div class="margin-bottom-30">
                            <h4 class="text-capitalize">Highlights</h4>
                            <?php service_meta::highlight(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="margin-bottom-30"><?php the_content(); ?></div>
                    <hr class="hr-border">
                    <div class="margin-bottom-30"> <?php service_meta::service_option(); ?></div>
                    <hr class="hr-border">
                    <?php if (service_meta::is_include(false)): ?>
                        <div class="what-in margin-bottom-30">
                            <h4 class="text-capitalize">What's Included</h4>
                            <?php service_meta::is_include(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (service_meta::not_include(false)): ?>
                        <div class="what-not margin-bottom-30">
                            <h4 class="text-capitalize">What's Not Included</h4>
                            <?php service_meta::not_include(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="text-right">
                        <a class="btn btn-green margin-bottom-30 btn-block text-uppercase clickGoDiv text-bold"
                           href="/<?= GDS::get_option(['booking_page', 'contact']) ?>">Contact</a>
                    </div>
                    <?php if (get_the_tag_list()) : ?>
                        <div class="post-tag">
                            <span class="pull-left"><i class="fa fa-tag"></i> Tags:</span>
                            <?php echo get_the_tag_list('<ul><li>', '</li><li>', '</li></ul>'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div id="sidebar" data-sticky_column="" class="col-sm-5 col-md-4 col-lg-4" style="position: inherit">
                <div class="row">
                    <div class="col-lg-12">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>