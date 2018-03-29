<?php

/**
 * Class CQR
 * Create query
 */
class CRQ
{
    /**
     * @param string $post_type
     * @param int $posts_per_page
     * @param array $extra
     * @return WP_Query
     */
    public static function popular_view($post_type, $posts_per_page = 10, $extra = [])
    {
        $args = [
            'post_type' => $post_type,
            'meta_key' => 'wpb_post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }

    public static function tour_might_like($post_type, $posts_per_page = 10, $extra = [])
    {


        global $post;
        $type_name = wp_get_post_terms($post->ID, 'tour_category');
        if (isset($type_name[0]->slug)):
            $type_name = $type_name[0]->slug;
            $args = array(
                'post__not_in' => array($post->ID),
                'posts_per_page' => $posts_per_page,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => $post_type,
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tour_category',
                        'field' => 'slug',
                        'terms' => $type_name,
                    ),
                ),
            );


            $args = array_merge($args, $extra);

            $the_query = new WP_Query($args);
            return $the_query;
        endif;
    }


    /**
     * @param string $post_type
     * @param int $posts_per_page
     * @param array $extra
     * @return null|WP_Query
     */
    public static function recent_view($post_type, $posts_per_page = 10, $extra = [])
    {
        $the_query = null;

        if (isset($_SESSION['client_view'])) {
            $post_id = $_SESSION['client_view'];
            $args = [
                'post_type' => $post_type,
                'posts_per_page' => $posts_per_page,
                'post__in' => $post_id,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
            ];

            $args = array_merge($args, $extra);

            $the_query = new WP_Query($args);
        }

        return $the_query;
    }

    /**
     * @param string $post_type
     * @param int $posts_per_page
     * @param array $extra
     * @return null|WP_Query
     */
    public static function deals_view($post_type, $posts_per_page = 10, $extra = [])
    {
        $the_query = null;

        $args = [
            'post_type' => $post_type,
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => [
                [
                    'key' => $post_type . '_price_old',
                    'value' => 0,
                    'type' => 'numeric',
                    'compare' => '>',
                ],
            ],
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);


        return $the_query;
    }

    /**
     * @param string $post_type
     * @param array $id
     * @param int $posts_per_page
     * @param array $extra
     * @return WP_Query
     */
    public static function by_id($post_type, $id = [], $posts_per_page = 10, $extra = [])
    {
        $args = [
            'post_type' => $post_type,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'post__in' => $id
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }

    /**
     * @param string $post_type
     * @param $taxonomy
     * @param $taxonomy_name
     * @param int $posts_per_page
     * @param array $extra
     * @return WP_Query
     */
    public static function by_taxonomy_term($post_type, $taxonomy, $taxonomy_name, $posts_per_page = 10, $extra = [])
    {

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $args = [
            'post_type' => $post_type,
            //'meta_key' => 'tour_price_from',
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $taxonomy_name
                ],
            ],
            'posts_per_page' => $posts_per_page,
            'paged' => $paged
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }

    public static function by_taxonomy_term_tour($order, $post_type, $taxonomy, $taxonomy_name, $posts_per_page = 10, $extra = [])
    {

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $args = [
            'post_type' => $post_type,
            'meta_key' => 'tour_price_from',
            'orderby' => 'meta_value_num',
            'order' => $order,
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $taxonomy_name
                ],
            ],
            'posts_per_page' => $posts_per_page,
            'paged' => $paged
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }

    public static function by_taxonomy_term_tour_best($post_type, $taxonomy, $taxonomy_name)
    {

        $args = [
            'post_type' => $post_type,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $taxonomy_name
                ],
            ],
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'tour_price_old',
                    'value' => 0,
                    'type' => 'numeric',
                    'compare' => '>',
                ),
                array(
                    'key' => 'tour_price_from',
                    'value' => 0,
                    'type' => 'numeric',
                    'compare' => '>',
                ),
            ),
            'posts_per_page' => 3,
        ];
        $the_query = new WP_Query($args);

        return $the_query;
    }

    public static function by_post_type($post_type, $posts_per_page = 10, $extra = [])
    {

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $args = [
            'post_type' => $post_type,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }

    /**
     * @param string $paged
     * @param string $post_type
     * @param $taxonomy
     * @param int $posts_per_page
     * @param array $extra
     * @return WP_Query
     */
    public static function taxonomy_page($paged, $post_type, $taxonomy, $posts_per_page = 10, $extra = [])
    {
        $type_name = get_queried_object();
        $args = [
            'post_type' => $post_type,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged,
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $type_name->slug
                ],
            ],
            'posts_per_page' => $posts_per_page,
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }

    /**
     * @param $tag
     * @param int $posts_per_page
     * @param array $extra
     * @return WP_Query
     */
    function by_tag($tag, $posts_per_page = 10, $extra = [])
    {
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $args = [
            'post_type' => array_keys(LIP::get_post_type_list()),
            'tag' => $tag,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);
        return $the_query;
    }

    /**
     * @param string $label
     * @param string $post_type
     * @param int $posts_per_page
     * @param array $extra
     * @return WP_Query
     */
    public static function by_show_label($label, $post_type, $posts_per_page = 10, $extra = [])
    {
        $args = [
            'post_type' => $post_type,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'tour_show_label',
                    'compare' => '=',
                ],
                [
                    'key' => 'tour_show_label',
                    'value' => serialize($label) . serialize('1'),
                    'compare' => 'LIKE'
                ]
            ],
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }

    /**
     * @param string $location_slug
     * @param string $post_type
     * @param int $posts_per_page
     * @param array $extra
     * @return WP_Query
     */
    public static function by_location($location_slug, $post_type, $posts_per_page = 10, $extra = [])
    {
        $args = [
            'post_type' => $post_type,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => $post_type . '_location',
                    'compare' => '=',
                ],
                [
                    'key' => $post_type . '_location',
                    'value' => $location_slug,
                    'compare' => '='
                ]
            ],
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $posts_per_page,
            'post_status' => 'publish',
        ];
        $args = array_merge($args, $extra);

        $the_query = new WP_Query($args);

        return $the_query;
    }


    public static function query_search($post_type, $location, $term_name, $duration, $price)
    {
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $v_args = [
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'paged' => $paged,
            'post_type' => $post_type,
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => $post_type . '_location',
                    'value' => $location,
                    'compare' => 'LIKE',
                ],
                [
                    'key' => $post_type . '_duration',
                    'value' => $duration,
                    'compare' => 'LIKE',
                ],
                [
                    'key' => $post_type . '_price_from',
                    'value' => explode(',', $price),
                    'type' => 'numeric',
                    'compare' => 'BETWEEN',
                ],
            ]
        ];

        if ($term_name != '') {
            $v_args['tax_query'] = [
                [
                    'taxonomy' => $post_type . '_category',
                    'field' => 'slug',
                    'terms' => $term_name,
                ],
            ];
        }
        $the_search_query = new WP_Query($v_args);
        return $the_search_query;
    }
}