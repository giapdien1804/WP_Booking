<?php get_header(); ?>

<div class="content">
    <?php if (have_posts()) : the_post(); ?>
        <div>
            <?php
            $single_obj = get_queried_object();
            get_template_part("single/{$single_obj->post_type}");
            ?>
        </div>
        <?php wp_reset_postdata(); endif; ?>
</div>
<?php get_footer(); ?>
