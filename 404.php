<?php get_header(); ?>
    <div class="text-center">
        <div id="mainBanner"
             style="background-image: url(<?php echo GDS::get_option(['option_text', 'header_bg']) ?>);">
            <?php get_template_part('include/search', 'home'); ?>
        </div>
        <div style="padding: 100px 0;">
            <div>
                <h1 style="font-size: 45px" class="text-uppercase text-bold margin-bottom-30">404 not found</h1>
            </div>
            <div class="text-capitalize">
                <p class="margin-bottom-30">Oops! The page you are looking for is not found!</p>
                <a href="<?php echo esc_html(home_url('/')); ?>" class="btn btn-green text-600">Go home</a>
                <a href="javascript:history.go(-1)" class="btn btn-green text-600">Go back</a>
            </div>
        </div>
    </div>
<?php get_footer(); ?>