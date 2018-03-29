<?php
/**
 * Copyright (c) 2016. giapdien1804@gmail.com
 */

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 21/7/2016
 * Time: 11:28 AM
 */
class service_meta extends GDS
{
    public static function price_range()
    {
        global $wpdb;
        $min_max = $wpdb->get_results("SELECT min(CAST(`meta_value` AS UNSIGNED )) AS `min`, max(CAST(`meta_value` AS UNSIGNED )) AS `max` FROM {$wpdb->postmeta},{$wpdb->posts} WHERE {$wpdb->postmeta}.meta_key='service_price_from' AND {$wpdb->posts}.post_type='service'", OBJECT);

        if ($min_max[0] == null) {
            $min_max = (object)[
                'min' => 10,
                'max' => 1000
            ];
        }
        return (object)[
            'min' => $min_max[0]->min,
            'max' => $min_max[0]->max
        ];
    }

    public static function code($echo = true)
    {
        $code = self::do_meta('service_default');
        $code = $code['code'];

        if ($echo && $code) {
            echo $code;
        }

        return $code;
    }

    public static function departure($echo = true)
    {
        $departure = self::do_meta('service_default');
        $departure = $departure['departure'];

        if ($echo && $departure) {
            echo $departure;
        }

        return $departure;
    }

    public static function check_price_from()
    {
        $price_from = self::do_meta('service_price_from');

        return $price_from;
    }

    public static function price_from($echo = true)
    {
        $price_from = self::do_meta('service_price_from');

        if ($echo && $price_from) {
            printf("<ins class=\"price-new\">%s</ins>", LIP::out_price($price_from));
        }

        return $price_from;
    }

    public static function price_old($echo = true)
    {
        $price_old = self::do_meta('service_price_old');

        if ($echo && $price_old) {
            printf("<del class=\"price-old\">%s</del>", LIP::out_price($price_old));
        }

        return $price_old;
    }

    public static function group_size($echo = true)
    {
        $group_size = self::do_meta('service_group_size');
        if ($echo && $group_size) {
            echo $group_size;
        }

        return $group_size;
    }

    public static function highlight($echo = true)
    {

        $highlight = self::do_meta('service_highlight');

        $highlight = isset($highlight['highlight']) ? $highlight['highlight'] : [];

        if ($echo && $highlight) {
            echo $highlight;
        }

        return $highlight;
    }

    public static function is_include($echo = true)
    {
        $include = self::do_meta('service_included');

        $include = isset($include['included']) ? $include['included'] : [];

        if ($echo && $include) {
            echo $include;
        }

        return $include;
    }

    public static function not_include($echo = true)
    {
        $not_include = self::do_meta('service_included');
        $not_include = isset($not_include['not_included']) ? $not_include['not_included'] : [];

        if ($echo && $not_include) {
            echo $not_include;
        }

        return $not_include;
    }

    public static function itinerary($echo = true)
    {
        $itinerary = self::do_meta('service_itinerary');
        $itinerary = $itinerary['itinerary'];

        if ($echo && $itinerary) {
            echo $itinerary;
        }

        return $itinerary;
    }

    public static function service_option($echo = true)
    {

        $options = self::do_meta('service_options');
        if ($echo) {
            foreach ($options as $option): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-bold"><?= LIP::out_put_array($option, 'option_title') ?></h4>
                        <p><?= LIP::out_put_array($option, 'option_note') ?></p>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <?php foreach ($option['option_table'] as $table): ?>
                        <div class="wp-in-option">
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <strong><?= LIP::out_put_array($table, 'list_price_name') ?></strong>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Valid from: <?= LIP::out_put_array($table, 'valid_from') ?></strong>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Valid to: <?= LIP::out_put_array($table, 'valid_to') ?></strong>
                            </div>
                            <div class="col-md-8">
                                <?php if ($table['by_group'] != null):
                                    printf('<strong>Price from: </strong> <strong class="info-popup-book">%s</strong>', LIP::out_price(LIP::out_put_array($table, 'by_group')));
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
                                <div style="margin-top: 10px;">
                                    <strong>Minimum quantity: <?= LIP::out_put_array($option, 'min_qty') ?></strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Maximum quantity: <?= LIP::out_put_array($option, 'max_qty') ?></strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr class="text-bold">
                                        <td><strong>Price from:</strong></td>
                                        <td class="info-popup-book text-bold"><?php
                                            if ($table['by_group'] == null) {
                                                echo LIP::out_price((isset($option['option_table'][0]['pax'][0])) ? $option['option_table'][0]['pax'][0] : null);
                                            } else {
                                                echo LIP::out_price(LIP::out_put_array($table, 'by_group'));
                                            }
                                            ?></td>
                                    </tr>
                                    <tr class="text-bold">
                                        <td><strong>Promotion: </strong></td>
                                        <td><?php
                                            $pro = LIP::out_put_array($table, 'promotion');
                                            if ($pro) {
                                                if (substr($pro, 0, 1) == '$') {
                                                    echo LIP::out_price(LIP::str_to_float($pro));
                                                } else {
                                                    echo LIP::out_put_array($table, 'promotion') . '%';
                                                }
                                            }
                                            ?></td>
                                    </tr>
                                    <tr class="text-bold">
                                        <td style="padding-right: 10px;"><strong>Single supplement: </strong></td>
                                        <?php $single_sup = LIP::out_put_array($table, 'single_sup');
                                        if ($single_sup) { ?>
                                            <td><?php echo LIP::out_price(LIP::out_put_array($table, 'single_sup')); ?></td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php
                    endforeach; ?>
                </div>
            <?php endforeach;
        }
        return $options;
    }

}