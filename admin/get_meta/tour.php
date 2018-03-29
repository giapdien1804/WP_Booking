<?php
/**
 * Copyright (c) 2016. giapdien1804@gmail.com
 */

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 21/7/2016
 * Time: 11:32 AM
 */
class tour_meta extends GDS
{
    public static function price_range()
    {
        global $wpdb;
        $min_max = $wpdb->get_results("SELECT min(CAST(`meta_value` AS UNSIGNED )) AS `min`, max(CAST(`meta_value` AS UNSIGNED )) AS `max` FROM {$wpdb->postmeta},{$wpdb->posts} WHERE {$wpdb->postmeta}.meta_key='tour_price_from' AND {$wpdb->posts}.post_type='tour'", OBJECT);

        if ($min_max[0] == null) {
            $min_max = (object)[
                'min' => 10,
                'max' => 1000,
            ];
        }
        return (object)[
            'min' => $min_max[0]->min,
            'max' => $min_max[0]->max,
        ];
    }

    public static function code($echo = true)
    {
        $code = self::do_meta('tour_default');
        $code = $code['code'];

        if ($echo && $code) {
            echo $code;
        }

        return $code;
    }

    public static function departure($echo = true)
    {
        $departure = self::do_meta('tour_default');
        $departure = $departure['departure'];

        if ($echo && $departure) {
            echo $departure;
        }

        return $departure;
    }

    public static function highlight($echo = true)
    {

        $highlight = self::do_meta('tour_highlight');

        $highlight = isset($highlight['highlight']) ? $highlight['highlight'] : [];

        if ($echo && $highlight) {
            echo $highlight;
        }

        return $highlight;
    }

    public static function is_include($echo = true)
    {
        $include = self::do_meta('tour_included');

        $include = isset($include['included']) ? $include['included'] : [];

        if ($echo && $include) {
            echo $include;
        }

        return $include;
    }

    public static function not_include($echo = true)
    {

        $not_include = self::do_meta('tour_included');
        $not_include = isset($not_include['not_included']) ? $not_include['not_included'] : [];

        if ($echo && $not_include) {
            echo $not_include;
        }

        return $not_include;
    }

    public static function media($echo = true, $style = 'gallery')
    {

        $media = self::do_meta('tour_media');
        $media = isset($media['image']) ? $media['image'] : [0 => null];

        if ($echo && $media[0] != null) {
            if ($style == 'grid') {
                self::images_grid($media);
            } elseif ($style == 'slide') {
                self::images_slide($media);
            } else {
                self::images_gallery($media);
            }

        }

        return $media;
    }

    public static function itinerary($echo = true)
    {

        $itinerary = self::do_meta('tour_itinerary');
        $itinerary = $itinerary['itinerary'];

        if ($echo && $itinerary) {
            echo $itinerary;
        }

        return $itinerary;
    }

    public static function implode_itinerary($echo = true)
    {

        $itinerary = self::do_meta('tour_itinerary');
        $itinerary = $itinerary['itinerary'];
        if ($echo && $itinerary) {
            $itinerary = explode('-', $itinerary);
            $itinerary = implode('&rarr;', $itinerary);
        }

        return $itinerary;
    }

    public static function itinerary_detail($echo = true)
    {

        $itinerary_detail = self::do_meta('tour_itinerary_detail');
        if ($echo == true) {
            ?>
            <?php
            foreach ($itinerary_detail as $k => $detail):
                ?>
                <div class="margin-bottom-10">
                    <button class="btn btn-block btn-itinerary" type="button"
                            data-toggle="collapse" data-target="#collapse_<?= $k ?>" aria-expanded="false"
                            aria-controls="collapseExample">
                        <i class="fa fa-minus-circle"></i> <?= $detail['title'] ?>
                    </button>
                    <div class="collapse in collapse-itinerary" id="collapse_<?= $k ?>">
                        <?= $detail['content'] ?>
                    </div>
                </div>
            <?php
            endforeach; ?>
            <?php
        }

        return $itinerary_detail;
    }

    public static function check_price_from()
    {
        $price_from = self::do_meta('tour_price_from');
        return $price_from;
    }

    public static function check_price_old()
    {
        $price_old = self::do_meta('tour_price_old');
        return $price_old;
    }

    public static function check_price_sales()
    {
        $price_sales = '';
        $price_from = self::do_meta('tour_price_from');
        $price_old = self::do_meta('tour_price_old');
        if ($price_from && $price_old) {
            $price_new = ((float)$price_old - (float)$price_from) / (float)$price_old;
            $price_sales = round($price_new * 100);
            echo "-" . $price_sales . "&#37;";
        }

        return $price_sales;
    }

    public static function price_from($echo = true)
    {
        $price_from = self::do_meta('tour_price_from');

        if ($echo && $price_from) {
            printf("<ins class=\"price-new\">%s</ins>", LIP::out_price($price_from));
        }

        return $price_from;
    }

    public static function price_old($echo = true)
    {
        $price_old = self::do_meta('tour_price_old');

        if ($echo && $price_old) {
            printf("<del class=\"price-old\">%s</del>", LIP::out_price($price_old));
        }

        return $price_old;
    }

    public static function pick_up($echo = true)
    {
        $pickup = self::do_meta('tour_pick_up');

        if ($echo) {
            printf("%s", LIP::out_price($pickup));
        }

        return $pickup;

    }

    public static function check_star()
    {
        $star = self::do_meta('tour_star');
        return $star;
    }

    public static function star($echo = true)
    {
        $star = self::do_meta('tour_star');

        $result = '
    <div class="star-rating">
        <input class="kv-ltr-theme-fa-star rating-loading" value="' . $star . '" data-size="xs" title="Star rating">
    </div>';

        if ($echo) {
            echo $result;
        }

        return $result;
    }

    public static function show_label($name = 'feature')
    {
        $check = false;

        $show_label = self::do_meta('tour_show_label');
        if ($show_label[$name] == 1) {
            $check = true;
        }

        return $check;
    }

    public static function duration($echo = true)
    {

        $duration = self::do_meta('tour_duration');

        if ($echo && $duration) {
            echo $duration;
        }
        return $duration;
    }

    public static function explode_duration($number = true)
    {

        $duration = self::do_meta('tour_duration');

        $duration = explode('-', $duration);

        if ($number == true) {
            $duration = $duration[0];
        } else {
            $duration = $duration[1];
        }

        return $duration;
    }

    public static function group_size($echo = true)
    {

        $group_size = self::do_meta('tour_group_size');
        if ($echo && $group_size) {
            echo $group_size;
        }

        return $group_size;
    }

    public static function pre_book($echo = true)
    {
        $pre_book = self::do_meta('tour_pre_book');
        if ($echo) {
            echo $pre_book;
        }

        return $pre_book;
    }

    public static function check_pre_book()
    {
        $pre_book = self::do_meta('tour_pre_book');
        return $pre_book;
    }

    public static function get_find_date()
    {
        $max = strtotime(date('m/d/Y'));
        $options = self::do_meta('tour_options');
        foreach ($options as $v1) {
            foreach ($v1['option_table'] as $v2) {
                if ($max < strtotime($v2['valid_to']))
                    $max = strtotime($v2['valid_to']);
            }
        }

        return date('m/d/Y', $max);
    }

    public static function find_qty_adult($qty = 'min')
    {
        $min = 1;
        $options = self::do_meta('tour_options');
        foreach ($options as $v1) {
            if (array_key_exists($qty . '_qty', $v1))
                if ($qty == 'min') {
                    if ($min > $v1[$qty . '_qty'])
                        $min = $v1[$qty . '_qty'];
                } else {
                    if ($min < $v1[$qty . '_qty'])
                        $min = $v1[$qty . '_qty'];
                }

        }

        return $min;
    }

    public static function tour_option($echo = true)
    {

        $options = self::do_meta('tour_options');
        if ($echo) {
            foreach ($options as $option): ?>
                <div class="row">
                    <div class="wp-tour-option">
                        <div class="col-md-12">
                            <h4><?= LIP::out_put_array($option, 'option_title') ?></h4>
                            <p><?= LIP::out_put_array($option, 'option_note') ?></p>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="margin: 0">
                        <?php foreach ($option['option_table'] as $table): ?>
                            <div class="wp-in-option">
                                <div class="col-md-12" style="margin-bottom: 10px">
                                    <strong><?= LIP::out_put_array($table, 'list_price_name') ?></strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Valid from: </strong> <?= LIP::out_put_array($table, 'valid_from') ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Valid to: </strong> <?= LIP::out_put_array($table, 'valid_to') ?>
                                </div>
                                <div class="col-md-8">
                                    <?php if ($table['by_group'] != null):
                                        printf('<strong>Price from: </strong>%s', LIP::out_price(LIP::out_put_array($table, 'by_group')));
                                    else: ?>
                                        <table class="table table-bordered" style="margin-bottom: 0">
                                            <tr>
                                                <th width="90px"> Quantity</th>
                                                <?php foreach ($table['qty'] as $qty) {
                                                    if ($qty != null) {
                                                        printf('<td>%s</td>', $qty);
                                                    }
                                                } ?>
                                            </tr>
                                            <tr>
                                                <th>Price/Pax</th>
                                                <?php foreach ($table['pax'] as $pax) {
                                                    if ($pax != null) {
                                                        printf('<td>%s</td>', $pax);
                                                    }
                                                } ?>
                                            </tr>
                                        </table>
                                    <?php endif ?>
                                    <div style="margin-top: 10px">
                                        <strong>Minimum quantity:</strong> <?= LIP::out_put_array($option, 'min_qty') ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Maximum quantity:</strong> <?= LIP::out_put_array($option, 'max_qty') ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <table>
                                        <tr>
                                            <td><strong>Price from:</strong></td>
                                            <td><?php
                                                if ($table['by_group'] == null) {
                                                    echo LIP::out_price((isset($option['option_table'][0]['pax'][0])) ? $option['option_table'][0]['pax'][0] : null);
                                                } else {
                                                    echo LIP::out_price(LIP::out_put_array($table, 'by_group'));
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Promotion: </strong></td>
                                            <td><?php
                                                $pro = LIP::out_put_array($table, 'promotion');
                                                if (substr($pro, 0, 1) == '$') {
                                                    echo LIP::out_price(LIP::str_to_float($pro));
                                                } else {
                                                    echo LIP::out_put_array($table, 'promotion') . '%';
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-right: 10px;"><strong>Single supplement: </strong></td>
                                            <td><?php echo LIP::out_price(LIP::out_put_array($table, 'single_sup')); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        <?php
                        endforeach; ?>
                    </div>
                </div>
            <?php endforeach;
        }
        return $options;
    }

    public static function get_valid_count_down()
    {
        $current_date = strtotime(date('m/d/Y'));
        $options = self::do_meta('tour_options');
        $min_valid = strtotime($options[0]['option_table'][0]['valid_to']);
        foreach ($options as $option) {
            foreach ($option['option_table'] as $table) {
                $valid = strtotime($table['valid_to']);
                if ($valid > $current_date) {
                    $min_valid = $valid;
                    break;
                }
            }
            if ($min_valid > $current_date) {
                break;
            }
        }

        return date('m/d/Y', $min_valid);
    }
}