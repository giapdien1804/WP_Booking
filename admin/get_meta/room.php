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
class room_meta extends GDS
{

    public static function acreage($echo = true)
    {
        $acreage = self::do_meta('room_default');
        $acreage = $acreage['acreage'];

        if ($echo && $acreage) {
            echo $acreage;
        }

        return $acreage;
    }

    public static function bed_type($echo = true)
    {
        $bed_type = self::do_meta('room_default');
        $bed_type = $bed_type['bed_type'];

        if ($echo && $bed_type) {
            echo $bed_type;
        }

        return $bed_type;
    }

    public static function check_price()
    {
        $price_from = self::do_meta('room_default_price');
        return $price_from;
    }

    public static function price($echo = true)
    {
        $price = self::do_meta('room_default');
        $price = $price['price'];
        return $price;
    }

    public static function min_number($echo = true)
    {
        $min_number = self::do_meta('room_default');
        $min_number = $min_number['min_number'];

        if ($echo && $min_number) {
            echo $min_number;
        }

        return $min_number;
    }

    public static function max_number($echo = true)
    {
        $max_number = self::do_meta('room_default');
        $max_number = $max_number['max_number'];

        if ($echo && $max_number) {
            echo $max_number;
        }

        return $max_number;
    }

    public static function check_star($echo = true)
    {
        $star = self::do_meta('room_default');
        $star = $star['star'];
        return $star;
    }

    public static function star($echo = true)
    {
        $star = self::do_meta('room_default');
        $star = $star['star'];

        $result = '<div class="star-rating">
        <input class="kv-ltr-theme-fa-star rating-loading" value="' . $star . '" data-size="xs" title="Star rating">
    </div>';

        if ($echo && $star) {
            echo $result;
        }

        return $result;
    }


    public static function media($echo = true, $style = 'gallery')
    {
        $media = self::do_meta('room_media');
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

    public static function service_detail($echo = true)
    {

        $service_detail = self::do_meta('room_service_detail');
        if ($echo == true) {
            ?>
            <?php
            foreach ($service_detail as $k => $detail):
                ?>
                <div class="margin-bottom-10">
                    <button class="btn btn-block btn-itinerary" type="button" data-target="#collapse_<?= $k ?>"
                            aria-expanded="false"
                            aria-controls="collapseExample"><?= $detail['title'] ?>
                    </button>
                    <div class="collapse in collapse-itinerary" id="collapse_<?= $k ?>">
                        <?= $detail['content'] ?>
                    </div>
                </div>
            <?php
            endforeach; ?>
            <?php
        }

        return $service_detail;
    }

    public static function equipment_detail($echo = true)
    {

        $equipment_detail = self::do_meta('room_equipment_detail');
        if ($echo == true) {
            ?>
            <?php
            foreach ($equipment_detail as $k => $detail):
                ?>
                <div class="margin-bottom-10">
                    <button class="btn btn-block btn-itinerary" type="button" data-target="#collapse_<?= $k ?>"
                            aria-expanded="false"
                            aria-controls="collapseExample"><?= $detail['title'] ?>
                    </button>
                    <div class="collapse in collapse-itinerary" id="collapse_<?= $k ?>">
                        <?= $detail['content'] ?>
                    </div>
                </div>
            <?php
            endforeach; ?>
            <?php
        }

        return $equipment_detail;
    }

}
