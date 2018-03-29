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
<div class="container">

    <div class="row">
        <div class="content-con" data-sticky_parent="">
            <div class="col-sm-7 col-md-8 col-lg-8">
                <div class="content-responsive-img not-found-tailor page-line margin-bottom-50">
                    <div>
                        <h1 class="title-category text-capitalize text-bold margin-top-0 margin-bottom-15">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                    <?php the_content(); ?>
                </div>
                <h2 class="title-category text-capitalize text-bold">See by location</h2>
                <hr class="hr-cate">
                <div class="margin-bottom-50">
                    <?php
                    global $post;
                    $tour = CRQ::by_location($post->post_name, 'tour', 5);
                    ?>
                    <div>
                        <?php
                        if ($tour->have_posts()) {
                            while ($tour->have_posts()) {
                                $tour->the_post();
                                get_template_part('taxonomy/tour_location');
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<h2>No tour in location</h2>';
                        }
                        ?>
                    </div>
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