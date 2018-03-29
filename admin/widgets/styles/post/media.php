<div class="media media-block">
    <div class="media-left">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail('thumbnail', ['title' => get_the_title()]); ?>
        </a>
    </div>
    <div class="media-body">
        <a class="media-posts" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
           class="media-heading"><?php the_title(); ?></a>
        <p class="description-post"><?php echo LIP::excerpt(20); ?></p>
    </div>
</div>