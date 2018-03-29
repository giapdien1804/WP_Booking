<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('include/category', 'post'); ?>
<?php endwhile;
    wp_reset_postdata(); ?>

    <?php get_template_part('include/paginate'); ?>
<?php else:
    get_template_part('content', 'none');
endif; ?>