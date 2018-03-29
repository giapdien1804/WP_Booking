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
                <?php if (!empty(tour_meta::check_star())) { ?>
                    <div class="star-icon" itemprop="review" itemscope itemtype="http://schema.org/Review">
                        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                            <span itemprop="name">
                                 <?php tour_meta::star(); ?>
                            </span>
                        </span>
                    </div>
                <?php } ?>
                <div class="nav nav-list-sidebar margin-top-10">
                    <ul class="text-capitalize">
                        <li><i class="fa fa-barcode"></i> Code: <span><?php tour_meta::code(); ?></span></li>
                        <li><i class="fa fa-clock-o"></i> Duration:
                            <span><?= tour_meta::explode_duration(true); ?> <?= tour_meta::explode_duration(false); ?></span>
                        </li>
                        <li><i class="fa fa-users"></i> Group size: <span><?php tour_meta::group_size(); ?></span></li>
                    </ul>
                    <div class="clearfix"></div>
                    <p><i class="fa fa-map-marker"></i> <?php echo tour_meta::implode_itinerary(); ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3">
            <?php if (tour_meta::price_from(false)): ?>
                <div>
                    <div class="price-tag">
                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            Price from:
                            <?php if (tour_meta::price_old(false)) : ?>
                                <span class="price-old" itemprop="priceCurrency" content="USD">$</span><span
                                        class="price-old" style="margin-left: 0"
                                        itemprop="price"
                                        content="<?= tour_meta::check_price_old(); ?>"><?= tour_meta::check_price_old(); ?></span>
                            <?php endif; ?>
                            <span class="price-new" itemprop="priceCurrency" content="USD">$</span><span
                                    class="price-new" style="margin-left: 0"
                                    itemprop="price"
                                    content="<?= tour_meta::check_price_from(); ?>"><?= tour_meta::check_price_from(); ?></span>
                        </div>

                        <span class="price-tag-arrow"></span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (tour_meta::price_from(false)): ?>
                <button class="btn btn-block btn-green text-bold text-uppercase clickGoDivs">Book now</button>
            <?php else: ?>
                <a style="padding:15px 12px;" href="/<?= GDS::get_option(['booking_page', 'contact']) ?>"
                   class="btn btn-block btn-green text-bold text-uppercase">Contact us</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="clearfix margin-bottom-10"></div>
    <div class="row">
        <div class="content-con" data-sticky_parent="">
            <div class="col-sm-7 col-md-8 col-lg-8">
                <div class="slider-single margin-bottom-30" style="position: relative">
                    <?php if (tour_meta::show_label('feature')): ?>
                        <div class="st-featured" style="bottom:30%">Featured</div>
                    <?php endif; ?>
                    <?php if (tour_meta::show_label('best_sale')): ?>
                        <div class="st-bestseller"><span>Bestseller</span></div>
                    <?php endif; ?>
                    <?php if (tour_meta::price_from(false) && tour_meta::price_old(false)) : ?>
                        <span class="st-percent"><?php tour_meta::check_price_sales(); ?></span>
                    <?php endif; ?>
                    <?php tour_meta::media('gallery'); ?>
                </div>
                <div id="boxSearchForm" itemprop="description"
                     class="margin-bottom-30 what-in  div-trip-highlight not-found-tailor content-responsive-img"><?php the_content(); ?></div>
                <?php if (tour_meta::highlight(false)): ?>
                    <div class="margin-bottom-30 div-trip-highlight">
                        <h4 class="text-capitalize trip-highlight margin-bottom-10">Highlights <span
                                    class="arrow-right"></span></h4>
                        <?php tour_meta::highlight(); ?>
                    </div>
                <?php endif; ?>
                <div class="not-found-tailor margin-bottom-30">
                    <form method="post" id="formSearchTours" data-toggle="validator">
                        <div class="row row-render">
                            <div class="col-sm-3 col-render">
                                <div class="form-group">
                                    <label for="max_adult">Adult(s)</label>
                                    <input type="number" class="form-control" name="max_adult" id="max_adult"
                                           value="<?= tour_meta::find_qty_adult('min'); ?>"
                                           required min="<?= tour_meta::find_qty_adult('min'); ?>"
                                           max="<?= tour_meta::find_qty_adult('max'); ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-render">
                                <div class="form-group">
                                    <label for="max_child">Child(4-8 yrs)</label>
                                    <input type="number" class="form-control" name="max_child" id="max_child" min="0"
                                           max="<?= tour_meta::find_qty_adult('max') / 2 ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-render">
                                <div class="form-group">
                                    <label for="max_infant">Infant(under 4)</label>
                                    <input type="number" class="form-control" name="max_infant" id="max_infant" min="0"
                                           max="<?= tour_meta::find_qty_adult('max') / 2 ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-render">
                                <div class="form-group inner-addon right-addon">
                                    <label for="booking_departure_date">Departure date</label>
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    <?php
                                    $today = date('m/d/Y');
                                    $pre_book = tour_meta::check_pre_book();
                                    $default_date = date('m/d/Y', strtotime("{$today} +{$pre_book} day")); ?>
                                    <input type="text" class="form-control" name="date_get"
                                           id="date_get" placeholder="mm/dd/yyyy"
                                           value="<?= $default_date ?>"
                                           data-start-date="<?= '+' . $pre_book . 'd' ?>"
                                           data-end-date="<?= tour_meta::get_find_date(); ?>">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="get_the_id" id="get_the_id" value="<?= get_the_ID(); ?>">
                        <div class="row row-render">
                            <div class="col-sm-3 col-render pull-right">
                                <button type="submit" class="btn btn-green btn-block text-bold text-uppercase"
                                        id="submitSearchOption" name="submit">Check Rates
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div id="LoadingImage" style="display:none" class="text-center margin-bottom-30">
                    <img src="/wp-content/themes/viigmt2/public/img/preloader.gif"/>
                </div>
                <div id="resultSearchOption" style="display:none" class="margin-bottom-30">

                </div>
                <div class="content-post-responsive margin-bottom-30">
                    <ul class="nav nav-tabs nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                                <i class="fa fa-check"></i> Included & Not Included</a>
                        </li>
                        <li role="presentation"><a href="#itinerary" aria-controls="messages" role="tab"
                                                   data-toggle="tab"><i
                                        class="fa fa-list" aria-hidden="true"></i> Details Itinerary</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="not-found-tailor">
                                <?php if (tour_meta::is_include(false)): ?>
                                    <div class="margin-bottom-30 what-in">
                                        <h4 class="text-capitalize">What's Included</h4>
                                        <?php tour_meta::is_include(); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (tour_meta::not_include(false)): ?>
                                    <div class="margin-bottom-30 what-not">
                                        <h4 class="text-capitalize">What's Not Included</h4>
                                        <?php tour_meta::not_include(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (tour_meta::itinerary_detail(false)): ?>
                            <div role="tabpanel" class="tab-pane" id="itinerary">
                                <?php tour_meta::itinerary_detail(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (tour_meta::price_from(false)): ?>
                    <button class="btn btn-block btn-green text-bold text-uppercase margin-bottom-30 clickGoDivs">Book
                        now
                    </button>
                <?php else: ?>
                    <a href="/<?= GDS::get_option(['booking_page', 'contact']) ?>"
                       class="btn btn-block btn-green text-bold text-uppercase margin-bottom-30">Contact us</a>
                <?php endif; ?>
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