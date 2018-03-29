<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 11/7/2016
 * Time: 3:36 PM
 */
class CSS
{
    static function background($color, $image, $repeat, $size)
    {
        $str = '';

        if ($color != null)
            $str = "background-color: {$color};";
        if ($image != null) {
            $str .= "background-image: url(\"{$image}\");background-repeat: {$repeat}; background-position: center;  background-attachment: fixed; background-size: {$size};";
        }

        return $str;
    }
}