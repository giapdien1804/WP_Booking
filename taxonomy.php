<?php get_header();
$term_obj = get_queried_object();
?>

<div class="content">
    <?php if (is_tax('tour_category')) : ?>
        <div id="mainBanner"
             style="background-image: url(<?php echo GDS::get_option(['option_text', 'header_bg']) ?>);">
            <?php get_template_part('include/search', 'home'); ?>
        </div>
    <?php endif; ?>
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
    <div class="clearfix"></div>
    <div class="container">
        <header>
            <h1 class="title-category text-capitalize text-bold">
                <?php single_cat_title(); ?>
            </h1>
        </header>
        <hr class="hr-cate">
        <div class="margin-bottom-30">
            <?php echo category_description(); ?>
        </div>
        <?php $sub_cate_slide = get_term_meta($term_obj->term_id, 'tour_category_slide', true);
        if ($sub_cate_slide) {
            $sub_cate_slide = array_filter($sub_cate_slide);
            if (!empty($sub_cate_slide)) { ?>
                <div id="adaptive">
                    <?php foreach ($sub_cate_slide as $sub_slide) { ?>
                        <figure class="slideShow">
                            <img class="img-responsive" src="<?php echo $sub_slide ?>">
                        </figure>
                    <?php } ?>
                </div>
            <?php }
        } ?>
        <?php

        $get_label = isset($_GET['label']) ? $_GET['label'] : '';
        $get_location = isset($_GET['tour_search_location']) ? $_GET['tour_search_location'] : '';
        $get_price = isset($_GET['tour_search_price_range']) ? $_GET['tour_search_price_range'] : tour_meta::price_range()->min . ',' . tour_meta::price_range()->max;
        $get_duration = isset($_GET['tour_search_howlong']) ? $_GET['tour_search_howlong'] : '';

        if (is_tax('tour_category')) {
            $term_id = $term_obj->term_id;
            $taxonomy_name = 'tour_category';
            $termchildren = get_term_children($term_id, $taxonomy_name);

            if ($termchildren) {
                echo "<h3>In this list</h3><div class='row row-render margin-bottom-30'>";
                foreach ($termchildren as $child) {
                    $term = get_term_by('id', $child, $taxonomy_name);
                    echo "<div class='col-sm-4 col-md-3 col-lg-3 col-render'>
                            <div class='item-list-content'>
                              <a href=" . get_term_link($child, $taxonomy_name) . " class='thumbnail-img'>
                                <img src=" . get_term_meta($term->term_id, 'tour_category_img', true) . " alt='sub_category'>
                                <span class='text-600'>" . $term->name . "</span>
                              </a>
                            </div>
                        </div>";
                }
                echo "</div>";
            }
        } ?>

        <?php
        $post_type = $term_obj->taxonomy;
        $post_type = explode('_', $post_type)[0];
        $sort_by_price = '';
        if (isset($_GET['order'])) {
            $sort_by_price = $_GET['order'];
        }
        global $wp_query;
        if (is_tax('tour_category')) {
            $wp_query = CRQ::by_taxonomy_term_tour($sort_by_price, $post_type, $term_obj->taxonomy, $term_obj->slug, get_option('post_per_page'));
        } else {
            $wp_query = CRQ::by_taxonomy_term($post_type, $term_obj->taxonomy, $term_obj->slug, get_option('post_per_page'));
        }

        $wp_query1 = CRQ::by_taxonomy_term_tour_best($post_type, $term_obj->taxonomy, $term_obj->slug);
        ?>
        <div class="row">
            <?php
            if ($wp_query1->have_posts()):
                echo "<div class='col-sm-12'><h2 class='text-center text-capitalize title-home-page text-green margin-bottom-30'>The top deals today</h2></div>";
                while ($wp_query1->have_posts()) {
                    $wp_query1->the_post();
                    get_template_part("include/besttaxonomy");
                    wp_reset_postdata();
                } endif; ?>
        </div>
        <?php if (is_tax('tour_category')) { ?>
            <div class="pull-right margin-bottom-30">
                <form method="get" class="form-inline">
                    <span>Sort by: &nbsp;</span>
                    <div class="form-group">
                        <select id="select-form-order" name="order" class="form-control">
                            <option disabled="disabled" selected>Pricing</option>
                            <option <?php if ($sort_by_price == 'ASC') echo 'selected'; ?> value="ASC">Ascending
                            </option>
                            <option <?php if ($sort_by_price == 'DESC') echo 'selected'; ?> value="DESC">Descending
                            </option>
                        </select>
                    </div>
                </form>
            </div>
        <?php } ?>
        <div class="clearfix"></div>
        <div>
            <?php
            if (have_posts()):
                while (have_posts()) {
                    the_post();
                    get_template_part("taxonomy/{$post_type}");
                } ?>

                <div>
                    <?php
                    get_template_part('include/paginate');
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else:
                get_template_part('content', 'none');
            endif;
            ?>
        </div>
    </div>
    <?php echo GDS::get_option(['option_text', 'box_contact_us']) ?>
</div>

<?php get_footer(); ?>
