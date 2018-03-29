<div class="the-breadcrumb margin-bottom-30  padding-top-25">
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
<div itemscope itemtype="http://schema.org/Product" class="container margin-bottom-30">
    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-9">
            <div>
                <div>
                    <h1 itemprop="name" class="heading-title-post"><?php the_title(); ?></h1>
                </div>
                <?php if (!empty(room_meta::check_star())) { ?>
                    <div class="star-icon" itemprop="review" itemscope itemtype="http://schema.org/Review">
                        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                            <span itemprop="name">
                                 <?php room_meta::star(); ?>
                            </span>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="clearfix margin-bottom-10"></div>
    <div class="row">
        <div class="content-con" data-sticky_parent="">
            <div class="col-sm-7 col-md-8 col-lg-8">
                <div class="slider-single margin-bottom-30" style="position: relative">
                    <?php room_meta::media('gallery'); ?>
                </div>
                <div id="boxSearchForm" itemprop="description"
                     class="margin-bottom-30 what-in  div-trip-highlight not-found-tailor content-responsive-img"><?php the_content(); ?></div>
                <div class="content-post-responsive margin-bottom-30">
                    <?php if (room_meta::service_detail(false)): ?>
                        <div role="tabpanel" class="tab-pane" id="itinerary">
                            <?php room_meta::service_detail(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (room_meta::equipment_detail(false)): ?>
                        <div role="tabpanel" class="tab-pane" id="itinerary">
                            <?php room_meta::equipment_detail(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (get_the_tag_list()): ?>
                    <div class="post-tag">
                        <span class="pull-left"><i class="fa fa-tag"></i> Tags:</span>
                        <?php echo get_the_tag_list('<ul><li>', '</li><li>', '</li></ul>'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div id="sidebar" data-sticky_column="" class="col-sm-5 col-md-4 col-lg-4" style="position: inherit">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="not-found-tailor margin-bottom-30">
                            <?php if (room_meta::acreage(false)): ?>
                                <p><strong>Acreage:</strong> <?php room_meta::acreage(); ?></p>
                            <?php endif; ?>
                            <?php if (room_meta::bed_type(false)): ?>
                                <p><strong>Bed type:</strong> <?php room_meta::bed_type(); ?></p>
                            <?php endif; ?>
                            <?php if (room_meta::min_number(false)): ?>
                                <p><strong>Min number:</strong> <?php room_meta::min_number(); ?></p>
                            <?php endif; ?>
                            <?php if (room_meta::max_number(false)): ?>
                                <p><strong>Max number:</strong> <?php room_meta::max_number(); ?></p>
                            <?php endif; ?>
                            <?php if (room_meta::price(false)): ?>
                                <div class="item-package-price" itemprop="offers" itemscope
                                     itemtype="http://schema.org/Offer">
                                    Price:
                                    <span class="price-new" itemprop="priceCurrency" content="USD">$</span><span
                                            class="price-new" style="margin-left: 0"
                                            itemprop="price"
                                            content="<?= room_meta::price(); ?>"><?= room_meta::price(); ?></span>
                                </div>
                            <?php endif; ?>
                            <a href="/<?= GDS::get_option(['booking_page', 'contact']) ?>"
                               class="btn btn-block btn-green text-bold text-uppercase margin-top-20">Contact us</a>
                            <?php /*if (room_meta::price(false)): */ ?><!--
                                <button class="btn btn-block btn-green text-bold text-uppercase clickGoDivs margin-top-20">Book now</button>
	                        <?php /*else: */ ?>
                                <a href="/<? /*= GDS::get_option(['booking_page', 'contact']) */ ?>" class="btn btn-block btn-green text-bold text-uppercase clickGoDivs margin-top-20">Contact us</a>
	                        --><?php /*endif; */ ?>
                        </div>
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 margin-top-50">
            <?php if (is_active_sidebar('widget_booking_sidebar')) {
                dynamic_sidebar('widget_booking_sidebar');
            } ?>
        </div>
    </div>
</div>
<?php echo GDS::get_option(['option_text', 'box_contact_us']) ?>