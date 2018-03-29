<?php

class GDS
{

    //<editor-fold desc="Images list style">
    public static function images_grid($data)
    {
        echo '<div class="row">';
        foreach ($data as $v): ?>
            <div class="col-md-3 col-sm-3">
                <a href="<?= $v ?>" class="fancybox"><img src="<?= $v ?>" class="img-responsive"></a>
            </div>
        <?php endforeach;
        echo '</div>';
    }

    public static function images_slide($data)
    {
        $id = get_the_ID();
        $count = count($data);
        ?>
        <div id="carousel-tour-<?= $id ?>" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php for ($i = 0; $i < $count; $i++) {
                    $active = ($i == 0) ? 'active' : null; ?>
                    <li data-target="#carousel-tour-<?= $id; ?>"
                        data-slide-to="<?= $i ?>"
                        class="<?= $active ?>"></li>
                <?php } ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php $stt = 0;
                foreach ($data as $val) {
                    $active = ($stt == 0) ? 'active' : null; ?>
                    <div class="item <?= $active ?>">
                        <a data-fancybox-group="gallery" href="<?= $val ?>" class="fancybox"> <img src="<?= $val ?>"
                                                                                                   class="img-responsive"></a>
                    </div>
                    <?php $stt++;
                } ?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-tour-<?= $id ?>" role="button"
               data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-tour-<?= $id ?>" role="button"
               data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    <?php }

    public static function images_gallery($data)
    {
        ?>
        <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
            <?php foreach ($data as $val) { ?>
                <li data-thumb="<?= $val ?>">
                    <img class="img-responsive" alt="tour" src="<?= $val ?>"/>
                </li>
            <?php } ?>
        </ul>
    <?php }

    //</editor-fold>

    public static function do_meta($name)
    {
        return get_post_meta(get_the_ID(), $name, true);
    }

    public static function do_book_link($type = 'tour')
    {
        global $wpdb;
        $post_id = get_the_ID();
        $post_slug = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = '{$post_id}'");
        $link = '/' . self::get_option(['booking_page', 'booking']) . '/?type=' . $type . '&booking=' . $post_slug;
        return $link;
    }

    public static function get_option($arrayPath)
    {
        $opt = get_option('GdsOption');
        foreach ($arrayPath as $name) {
            if (isset($opt[$name])) {
                $opt = $opt[$name];
            } else {
                return null;
            }
        }
        return $opt;
    }

    public static function the_option($arrayPath)
    {
        $_data = self::get_option($arrayPath);
        if (!is_array($_data)) {
            echo $_data;
        } else {
            echo 'Error, option return array';
        }
    }

    public static function data_block_slide()
    {
        $the_query = false;
        if (self::get_option(['home_slide']) != null) {
            $option = self::get_option(['home_slide']);

            $tax = ($option['post_type'] == 'category') ? 'category' : $option['post_type'] . '_category';

            $by_id = explode(',', $option['data']['by_id']);
            if ($option['data_from'] == 'post_item') {

                $the_query = CRQ::by_id($option['post_type'], $by_id);
            } elseif ($option['data_from'] == 'post_tax') {

                $the_query = CRQ::by_taxonomy_term($option['post_type'], $tax, $option['data'][$tax], $option['number']);
            } elseif ($option['data_from'] == 'images') {

                if (count($option['images']) > 1) {
                    $the_query = (object)['images' => $option['images']];
                }
            } else {

                $the_query = CRQ::by_post_type($option['post_type'], $option['number']);
            }

        }
        return $the_query;
    }

    public static function the_home_page()
    {
        $option = self::get_option(['home_row']);
        foreach ($option as $item => $value) {
            echo $value['row_extra']['row_before']; //after row
            LIP::open_row('block-' . $item . ' ' . $value['row_extra']['class'], CSS::background($value['background']['color'], $value['background']['image'], $value['background']['repeat'], $value['background']['size']));
            if ($value['row_extra']['container'] == true)
                echo '<div class="container">';
            if ($value['show_option']['row_title'] == true) {
                LIP::style_html_tag('row_title', ucfirst($value['row_title']));
            }

            foreach ($value['column'] as $item_c => $value_c) {
                $post_type = $value_c['option']['post_type'];
                echo $value_c['col_extra']['col_before'];
                if ($value['row_extra']['row'] == true)
                    echo '<div class="row">';
                LIP::open_column('column-' . $item_c . ' ' . $value_c['col_extra']['class'], $value_c['option']['type'], $value_c['option']['width']);
                echo '<div>';
                if ($value_c['option']['show_title'] == true) {
                    echo '<header class="row-title">';
                    LIP::style_html_tag('heading', ucfirst($value_c['option']['title']));
                    if ($value_c['option']['desc'] != '')
                        echo "<p class='description-heading'>{$value_c['option']['desc']}</p>";
                    echo '</header>';
                }

//                echo ($post_type != 'html' | $post_type != 'widget') ? '<div class="row">' : '';

                if ($post_type == 'html') {
                    echo html_entity_decode($value_c['html_widget']['html']);
                } elseif ($post_type == 'widget') {
                    if (is_active_sidebar($value_c['html_widget']['widget'])) {
                        dynamic_sidebar($value_c['html_widget']['widget']);
                    }
                } else {
                    //query by post type
                    $args_type = [
                        'post_type' => $post_type,
                    ];

                    //query by ID
                    $args_id = [];
                    if (trim($value_c['data']['by_id']) != '') {
                        $args_id = ['post__in' => explode(',', $value_c['data']['by_id'])];
                    }

                    //query by taxonomy
                    $args_taxonomy = [];
                    $taxonomy = ($post_type == 'post') ? 'category' : $post_type . "_category";
                    if ($value_c['data'][$taxonomy] != '') {
                        $args_taxonomy = ['tax_query' =>
                            [
                                [
                                    'taxonomy' => $taxonomy,
                                    'field' => 'slug',
                                    'terms' => $value_c['data'][$taxonomy]
                                ]
                            ],
                        ];
                    }

                    $sticky = [];
                    if ($value['show_option']['sticky_posts'] == true) {
                        $sticky = [
                            'post__in' => get_option('sticky_posts'),
                            'ignore_sticky_posts' => 1,
                        ];
                    }

                    $other = [
                        'posts_per_page' => (LIP::str_to_int($value_c['option']['number']) > 0) ? $value_c['option']['number'] : 5,
                        'order' => 'DESC',
                        'orderby' => 'modified',
                        'post_status' => 'publish'
                    ];
                    $args = array_merge($args_type, $args_id, $args_taxonomy, $sticky, $other);
                    global $the_query;
                    $the_query = new WP_Query($args);

                    get_template_part("/layout/{$post_type}/{$value_c['option']['layout']}");

                }
//                echo ($post_type != 'html' | $post_type != 'widget') ? '</div>' : '';
                echo '</div>';
                LIP::close_div();//close column
                echo $value_c['col_extra']['col_after'];
            }

            if ($value['row_extra']['row'] == true) //close row add
                echo '</div>';
            if ($value['row_extra']['container'] == true) //close column add
                echo '</div>';
            LIP::close_div(); //close row
            echo $value['row_extra']['row_after']; //before row
        }
    }
}

