<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 29/3/2016
 * Time: 10:57 PM
 */
class LIP
{
    function __construct()
    {
        self::$system_key = 'bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3';
    }

    public static function str_to_int($str)
    {
        return intval(preg_replace("/[^-0-9\.]/", "", $str));
    }

    public static function str_to_float($str)
    {
        return floatval(preg_replace("/[^-0-9\.]/", "", $str));
    }

    public static function out_price($price)
    {
        $unit = (GDS::get_option(['booking_price', 'unit']) != '') ? GDS::get_option(['booking_price', 'unit']) : '$';
        $position = (GDS::get_option(['booking_price', 'position']) != '') ? GDS::get_option(['booking_price', 'position']) : 'left';
        $space = (GDS::get_option(['booking_price', 'space']) != '') ? GDS::get_option(['booking_price', 'space']) : '';

        if ($position == 'left')
            $price = $unit . $space . $price;
        else
            $price .= $space . $unit;

        return $price;
    }

    public static function out_put_array($array, $key)
    {
        if (isset($array[$key]))
            return $array[$key];
        else
            return null;
    }

    public static function excerpt($limit)
    {
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        if (count($excerpt) >= $limit) {
            array_pop($excerpt);
            $excerpt = implode(" ", $excerpt) . '...';
        } else {
            $excerpt = implode(" ", $excerpt);
        }
        $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
        return $excerpt;
    }

    public static function arrayNumber($start, $step, $end)
    {
        $_list = [];
        for ($i = $start; $i <= $end; $i += $step) {
            $_list += [$i => strtoupper($i)];
        }

        return $_list;
    }

    public static function http_https()
    {

    }

    public static function layout_list()
    {
        return [
            'la-1' => 'Style 1',
            'la-2' => 'Style 2',
            'la-3' => 'Style 3',
            'la-4' => 'Style 4',
            'la-5' => 'Style 5',
            'la-6' => 'Style 6',
            'la-7' => 'Style 7',
            'la-8' => 'Style 8',
            'la-9' => 'Style 9',
            'la-10' => 'Style 10',
        ];
    }

    public static function star_list()
    {
        return [
            '0' => 0,
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
        ];
    }

    public static function duration_list($post_type = 'tour', $show_title = null)
    {
        $duration = explode(',', GDS::get_option(['post_' . $post_type, 'duration_list']));
        $tmp = [];
        foreach ($duration as $value) {
            if (!strpos($value, '<<') && strpos($value, '>>')) {
                $str = str_replace('<<', '', $value);
                $str = str_replace('>>', '', $str);
                $str = explode('.', $str);
                $range = explode('~', $str[0]);
                for ($i = $range[0]; $i <= $range[1]; $i++)
                    $tmp [] = $i . $str[1];
            } else {
                $tmp [] = $value;
            }
        }

        return LIP::array_map($tmp, null, null, $show_title);
    }

    public static function showLabel_list()
    {
        $list = explode(',', GDS::get_option(['post_show_label']));
        /* 'feature' => 'Feature',
         'best_sale' => 'Best sale',
         'best_price' => 'Best price',
         'top_10' => 'Top 10',
         'top_20' => 'Top 20',
         'top_30' => 'Top 30';*/
        $tmp = [];
        if (is_array($list))
            foreach ($list as $value) {
                $val = explode('=>', $value);
                if (is_array($val))
                    $tmp += [$val[0] => $val[1]];
            }

        return $tmp;
    }

    public static function showPrice_list()
    {
        $list = explode(',', GDS::get_option(['post_get_price_search']));
        $tmp = [];
        if (is_array($list))
            foreach ($list as $value) {
                $val = explode('=>', $value);
                if (is_array($val))
                    $tmp += [$val[0] => $val[1]];
            }

        return $tmp;
    }

    public static function get_post_type_list($extra = [])
    {
        $list = [
            'post' => 'Post',
            'location' => 'Location',
            'tour' => 'Tour',
            'cruise' => 'Cruise',
            'hotel' => 'Hotel',
            'room' => 'Room',
            'transfer' => 'Transfer',
            'service' => 'Services',
        ];


        if ($extra != []) {
            $list = array_merge($extra, $list);
        }

        return $list;
    }

    public static function get_taxonomy_list()
    {
        $tax = [];
        foreach (self::get_post_type_list() as $type => $name) {
            ($type == 'post') ? $tax[] = 'category' : $tax[] = $type . '_category';
        }

        return $tax;
    }

    public static function get_term_list($post_type, $taxonomy = null, $add_title = false)
    {
        $data = get_categories([
            'object_type' => $post_type,
            'taxonomy' => $taxonomy,
            'hide_empty' => 0,
            'orderby' => 'name',
            'order' => 'ASC'
        ]);

        $data = self::array_map($data, 'slug', 'name', ($add_title == false) ? false : 'Select ' . str_replace('_', ' ', $taxonomy));

        return $data;
    }

    public static function get_all_post_list($post_type, $title = true)
    {
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => -1
        ];

        $the_query = new WP_Query($args);
        if ($title == true)
            $list = [
                '' => 'Select ' . ucfirst(str_replace('_', ' ', $post_type))
            ];
        else
            $list = [];
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $list += [get_post_field('post_name', get_the_ID()) => get_the_title()];
        }
        wp_reset_postdata();

        return $list;
    }

    public static function term_list_select($post_type, $taxonomy)
    {
        echo "<option value=''>All</option>";
        foreach (self::get_term_list($post_type, $taxonomy) as $slug => $name) {
            echo "<option value='{$slug}'>{$name}</option>";
        }
    }

    public static function array_map($data, $name_val = null, $name_view = null, $select_title = false)
    {
        $tmp = [];

        if ($select_title != false) {
            $tmp[''] = $select_title;
        }

        foreach ($data as $v) {
            if ($name_val == null || $name_view == null)
                $tmp[$v] = $v;
            else
                $tmp[$v->$name_val] = $v->$name_view;

        }

        return $tmp;
    }

    public static function get_page_list()
    {
        $data = self::array_map(get_pages([
            'sort_order' => 'asc',
        ]), 'post_name', 'post_title');

        return $data;
    }

    public static function get_menu_list()
    {
        $data = get_registered_nav_menus();

        return $data;
    }

    public static function get_nationality_list()
    {
        $str = "VVNBLENhbmFkYSxBZmdoYW5pc3RhbixBbGJhbmlhLEFsZ2VyaWEsQW1lcmljYW4gU2Ftb2EsQW5kb3JyYSxBbmdvbGEsQW5ndWlsbGEsQW50YXJjdGljYSxBbnRpZ3VhIGFuZCBCYXJidWRhLA0KQXJnZW50aW5hLEFybWVuaWEsQXJ1YmEsQXVzdHJhbGlhLEF1c3RyaWEsQXplcmJhaWphbixCYWhhbWFzLEJhaHJhaW4sQmFuZ2xhZGVzaCxCYXJiYWRvcyxCZWxhcnVzLEJlbGdpdW0sQmVsaXplLEJlbmluLEJlcm11ZGEsDQpCaHV0YW4sQm9saXZpYSxCb3NuaWEgYW5kIEhlcnplZ292aW5hLEJvdHN3YW5hLEJvdXZldCBJc2xhbmQsQnJhemlsLEJyaXRpc2ggSW5kaWFuIE9jZWFuIFRlcnJpdG9yeSxCcml0aXNoIFZpcmdpbiBJc2xhbmRzLEJydW5laSwNCkJ1bGdhcmlhLEJ1cmtpbmEgRmFzbyxCdXJ1bmRpLENhbWJvZGlhLENhbWVyb29uLENhcGUgVmVyZGUsQ2F5bWFuIElzbGFuZHMsQ2VudHJhbCBBZnJpY2FuIFJlcHVibGljLENoYWQsQ2hpbGUsQ2hpbmEsQ2hyaXN0bWFzIElzbGFuZCwNCkNvY29zIElzbGFuZHMsQ29sb21iaWEsQ29tb3JvcyxDb25nbyxDb29rIElzbGFuZHMsQ29zdGEgUmljYSxDcm9hdGlhLEN1YmEsQ3lwcnVzLEN6ZWNoIFJlcHVibGljLERlbm1hcmssRGppYm91dGksRG9taW5pY2EsDQpEb21pbmljYW4gUmVwdWJsaWMsRWFzdCBUaW1vcixFY3VhZG9yLEVneXB0LEVsIFNhbHZhZG9yLEVxdWF0b3JpYWwgR3VpbmVhLEVyaXRyZWEsRXN0b25pYSxFdGhpb3BpYSxGYWxrbGFuZCBJc2xhbmRzLA0KRmFyb2UgSXNsYW5kcyxGaWppLEZpbmxhbmQsRnJhbmNlLEdhYm9uLEdhbWJpYSxHZW9yZ2lhLEdlcm1hbnksR2hhbmEsR2licmFsdGFyLEdyZWVjZSxHcmVlbmxhbmQsR3JlbmFkYSxHdWFkZWxvdXBlLEd1YW0sDQpHdWF0ZW1hbGEsR3VpbmVhLEd1aW5lYS1CaXNzYXUsR3V5YW5hLEhhaXRpLEhlYXJkLEhvbmR1cmFzLEhvbmcgS29uZyxIdW5nYXJ5LEljZWxhbmQsSW5kaWEsSW5kb25lc2lhLElyYW4sSXJhcSxJcmVsYW5kLA0KSXNyYWVsLEl0YWx5LEl2b3J5IENvYXN0LEphbWFpY2EsSmFwYW4sSm9yZGFuLEthemFraHN0YW4sS2VueWEsS2lyaWJhdGksS29yZWEsIE5vcnRoLEtvcmVhLCBTb3V0aCxLdXdhaXQsS3lyZ3l6c3RhbixMYW9zLA0KTGF0dmlhLExlYmFub24sTGVzb3RobyxMaWJlcmlhLExpYnlhLExpZWNodGVuc3RlaW4sTGl0aHVhbmlhLEx1eGVtYm91cmcsTWFjYXUsTWFjZWRvbmlhLE1hZGFnYXNjYXIsTWFsYXdpLE1hbGF5c2lhLE1hbGRpdmVzLA0KTWFsaSxNYWx0YSxNYXJzaGFsbCBJc2xhbmRzLE1hcnRpbmlxdWUsTWF1cml0YW5pYSxNYXVyaXRpdXMsTWF5b3R0ZSxNZXhpY28sTWljcm9uZXNpYSxNb2xkb3ZhLE1vbmFjbyxNb25nb2xpYSxNb250c2VycmF0LA0KTW9yb2NjbyxNb3phbWJpcXVlLE15YW5tYXIsTmFtaWJpYSxOYXVydSxOZXBhbCxOZXRoZXJsYW5kcyxOZXRoZXJsYW5kcyBBbnRpbGxlcyxOZXcgQ2FsZWRvbmlhLE5ldyBaZWFsYW5kLE5pY2FyYWd1YSxOaWdlciwNCk5pZ2VyaWEsTml1ZSxOb3Jmb2xrIElzbGFuZCxOb3J0aGVybiBNYXJpYW5hIElzbGFuZHMsTm9yd2F5LE9tYW4sUGFraXN0YW4sUGFsYXUsUGFuYW1hLFBhcHVhIE5ldyBHdWluZWEsUGFyYWd1YXksUGVydSwNClBoaWxpcHBpbmVzLFBpdGNhaXJuIElzbGFuZCxQb2xhbmQsUG9ydHVnYWwsUHVlcnRvIFJpY28sUWF0YXIsUmV1bmlvbixSb21hbmlhLFJ1c3NpYSxSd2FuZGEsUy5HZW9yZ2lhLFNhaW50IEtpdHRzICZhbXA7DQpOZXZpcyxTYWludCBMdWNpYSxTYWludCBWaW5jZW50LFNhbW9hLFNhbiBNYXJpbm8sU2FvIFRvbWUsU2F1ZGkgQXJhYmlhLFNlbmVnYWwsU2V5Y2hlbGxlcyxTaWVycmEgTGVvbmUsU2luZ2Fwb3JlLFNsb3Zha2lhLA0KU2xvdmVuaWEsU29tYWxpYSxTb3V0aCBBZnJpY2EsU3BhaW4sU3JpIExhbmthLFN0LiBIZWxlbmEsU3QuIFBpZXJyZSxTdWRhbixTdXJpbmFtZSxTdmFsYmFyZCxTd2F6aWxhbmQsU3dlZGVuLFN3aXR6ZXJsYW5kLA0KU3lyaWEsVGFpd2FuLFRhamlraXN0YW4sVGFuemFuaWEsVGhhaWxhbmQsVG9nbyxUb2tlbGF1LFRvbmdhLFRyaW5pZGFkLFR1bmlzaWEsVHVya2V5LFR1cmttZW5pc3RhbixUdXJrcyxUdXZhbHUsVWdhbmRhLA0KVWtyYWluZSxVbml0ZWQgQXJhYiBFbWlyYXRlcyxVbml0ZWQgS2luZ2RvbSxVcnVndWF5LFV6YmVraXN0YW4sVmFudWF0dSxWYXRpY2FuIENpdHksVmVuZXp1ZWxhLFZpZXRuYW0sVmlyZ2luIElzbGFuZHMsV2FsbGlzLA0KV2VzdGVybiBTYWhhcmEsWWVtZW4sWXVnb3NsYXZpYSxaYWlyZSxaYW1iaWEsWmltYmFid2UsT3RoZXI=";
        $str = base64_decode($str);

        return explode(',', $str);
    }

    public static function the_nationality_list()
    {
        foreach (self::get_nationality_list() as $v) {
            printf('<option value="%s">%s</option>', $v, $v);
        }
    }

    public static function encryption($plaintext)
    {
        # --- ENCRYPTION ---

        # the key should be random binary, use scrypt, bcrypt or PBKDF2 to
        # convert a string into a key
        # key is specified using hexadecimal
        $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

        # show key size use either 16, 24 or 32 byte keys for AES-128, 192
        # and 256 respectively
        $key_size = strlen($key);
//        echo "Key size: " . $key_size . "\n";

        # create a random IV to use with CBC encoding
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
            $plaintext, MCRYPT_MODE_CBC, $iv);

        # prepend the IV for it to be available for decryption
        $ciphertext = $iv . $ciphertext;

        # encode the resulting cipher text so it can be represented by a string
        $ciphertext_base64 = base64_encode($ciphertext);

        return $ciphertext_base64;

        # === WARNING ===

        # Resulting cipher text has no integrity or authenticity added
        # and is not protected against padding oracle attacks.
    }

    public static function decrypttion($ciphertext_base64)
    {
        $ciphertext_dec = base64_decode($ciphertext_base64);

        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $ciphertext_dec = substr($ciphertext_dec, $iv_size);

        # may remove 00h valued characters from end of plain text
        $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
            $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);

        return trim($plaintext_dec);
    }

    public static function renameKey($oldkey, $newkey, $array)
    {
        $val = $array[$oldkey];
        $tmp_A = array_flip($array);
        $tmp_A[$val] = $newkey;

        return array_flip($tmp_A);
    }

    public static function open_row($className = '', $css = false, $echo = true)
    {
        $str = "<div class='{$className}'>";

        if ($css != false) {
            $str = "<div class='{$className}' style='{$css}'>";
        }

        if ($echo == true)
            echo $str;
        return $str;

    }

    public static function close_div($echo = true)
    {
        $str = "</div>";
        if ($echo == true)
            echo $str;
        return $str;
    }

    public static function open_column($className = '', $type, $width, $echo = true)
    {
        $str = "<div class='col-{$type}-{$width} {$className}'>";
        if ($echo == true)
            echo $str;
        return $str;
    }

    public static function style_html_tag($placement, $content, $echo = true)
    {
        $tag = GDS::get_option(['style_html_tag', $placement]);
        $class = GDS::get_option(['style_html_tag', $placement . '_class']);
        if ($tag == '') $tag = 'h2';

        $str = "<{$tag} class='{$class}'>{$content}</{$tag}>";
        if ($echo == true)
            echo $str;
        return $str;
    }

    public static function repeat_list()
    {
        return [
            'repeat' => __('Repeat', 'gds'),
            'repeat-x' => __('Repeat x', 'gds'),
            'repeat-y' => __('Repeat y', 'gds'),
            'no-repeat' => __('No repeat')
        ];
    }

    public static function map_tag_to_array($array = [], $tag, $souc = 2, $echo = true)
    {
        $str = '';
        foreach ($array as $item => $value) {
            if ($souc == 2)
                $str .= sprintf($tag, $item, $value);
            else
                $str .= sprintf($tag, $value, $value);
        }

        if ($echo == true)
            echo $str;

        return $str;
    }

    public static function post_type_list($post_type)
    {
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => -1
        ];

        $the_query = new WP_Query($args);
        $list = ['' => 'Select ' . $post_type];
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $list += [get_post_field('post_name', get_the_ID()) => get_the_title()];
        }
        wp_reset_postdata();

        return $list;
    }

    public static function taxonomy_list($post_type, $taxonomy = null, $extra = [])
    {
        if ($taxonomy == null) {
            $taxonomy = ($post_type == 'post') ? 'category' : $post_type . '_category';
        }
        $data = get_categories([
            'object_type' => $post_type,
            'taxonomy' => $taxonomy,
            'hide_empty' => 0,
            'orderby' => 'name',
            'order' => 'ASC'
        ]);

        $data = array_merge($extra, self::array_map($data, 'slug', 'name'));


        return $data;
    }

    public static function load_template_part($template_name, $part_name = null)
    {
        ob_start();
        get_template_part($template_name, $part_name);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }

    public static function bgsize_list()
    {
        return ['auto' => 'Auto', 'cover' => 'Cover', 'contain' => 'Contain'];
    }

}