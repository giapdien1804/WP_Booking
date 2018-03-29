<?php get_header(); ?>
    <div>
        <?php get_template_part('include/slider'); ?>
        <?php GDS::the_home_page(); ?>
        <?php echo GDS::get_option(['option_text', 'box_contact_us']) ?>
    </div>
<?php get_footer(); ?>