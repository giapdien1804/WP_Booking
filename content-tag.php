<?php
$current_tag = get_query_var('tag');
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$args = [
    'post_type' => array_keys(LIP::get_post_type_list()),
    'tag' => $current_tag,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
    'paged' => $paged,
];
$the_query = new WP_Query($args);
?>

<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
    <?php get_template_part('include/category', 'post'); ?>
<?php endwhile;
    wp_reset_postdata(); ?>
    <nav class="pagination-custom">
        <?php
        $big = 7600;
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'total' => $the_query->max_num_pages,
            'current' => $paged,
            'prev_next' => True,
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'type' => 'list'));
        ?>
    </nav>
<?php else:
    get_template_part('content', 'none');
endif; ?>