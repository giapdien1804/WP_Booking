<?php
/**
 * Template Name: Tour Option
 * Created by giapdien.
 * User: giapdien
 * email: giapdien1804@gmail.com | traihogiap@hotmail.com
 * Date: 16/05/2016
 * Time: 4:08 CH
 */
?>

<?php

class TourOptionClass extends GDS
{


    public $date_get;
    public $max_adult;
    public $get_the_id;
    public $max_child;
    public $max_infant;

    public function do_book_link_option($type = 'tour')
    {
        $this->get_the_id = $_POST['get_the_id'];
        global $wpdb;
        $post_id = $this->get_the_id;
        $post_slug = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = '{$post_id}'");
        $link = '/' . self::get_option(['booking_page', 'booking']) . '/?type=' . $type . '&booking=' . $post_slug;
        return $link;
    }

    public function check_tour_option($echo = true)
    {

        $this->date_get = isset($_POST['date_get']) ? $_POST['date_get'] : '';
        $this->max_adult = isset($_POST['max_adult']) ? $_POST['max_adult'] : '';
        $this->max_child = isset($_POST['max_child']) ? $_POST['max_child'] : '';
        $this->max_infant = isset($_POST['max_infant']) ? $_POST['max_infant'] : '';
        $this->get_the_id = isset($_POST['get_the_id']) ? $_POST['get_the_id'] : '';
        $user_date = strtotime($this->date_get);
        $options = get_post_meta($this->get_the_id, 'tour_options', true);
        if ($echo) {
            foreach ($options as $op_index => $option): ?>

                <?php foreach ($option['option_table'] as $tb_index => $table): ?>

                    <?php

                    $valid_to = strtotime(LIP::out_put_array($table, 'valid_from'));
                    $valid_from = strtotime(LIP::out_put_array($table, 'valid_to'));

                    if ($user_date >= $valid_to && $user_date <= $valid_from && $this->max_adult >= LIP::out_put_array($option, 'min_qty') && $this->max_adult <= LIP::out_put_array($option, 'max_qty')) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="wp-tour-option">
                                    <div class="col-md-12">
                                        <h4 class="text-bold"><?= LIP::out_put_array($option, 'option_title') ?></h4>
                                        <p><?= LIP::out_put_array($option, 'option_note') ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr style="margin: 0">
                                    <div class="wp-in-option">
                                        <div class="col-md-12" style="margin-bottom: 10px">
                                            <strong><?= LIP::out_put_array($table, 'list_price_name') ?></strong>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Valid from: <?= LIP::out_put_array($table, 'valid_from') ?></strong>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Valid to: <?= LIP::out_put_array($table, 'valid_to') ?></strong>
                                        </div>
                                        <div class="col-md-8">
                                            <?php if ($table['by_group'] != null):
                                                printf('<strong>Price from: </strong><strong class="font-size-18" style="color:#c01">%s</strong>', LIP::out_price(LIP::out_put_array($table, 'by_group')));
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
                                                <strong>Minimum quantity:</strong>
                                                <strong><?= LIP::out_put_array($option, 'min_qty') ?></strong>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <strong>Maximum quantity:</strong>
                                                <strong><?= LIP::out_put_array($option, 'max_qty') ?></strong>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <table>
                                                <tr>
                                                    <td><strong>Price from:</strong></td>
                                                    <td class="text-bold font-size-18" style="color: #c01;"><?php
                                                        if ($table['by_group'] == null) {
                                                            echo LIP::out_price((isset($option['option_table'][0]['pax'][0])) ? $option['option_table'][0]['pax'][0] : null);
                                                        } else {
                                                            echo LIP::out_price(LIP::out_put_array($table, 'by_group'));
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Promotion: </strong></td>
                                                    <td class="text-bold"><?php
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
                                                    <td style="padding-right: 10px;"><strong>Single
                                                            supplement: </strong></td>
                                                    <?php $single_sup = LIP::out_put_array($table, 'single_sup');
                                                    if ($single_sup) { ?>
                                                        <td><?php echo LIP::out_price(LIP::out_put_array($table, 'single_sup')); ?></td>
                                                    <?php } ?>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-4 pull-right margin-top-10">
                                            <form id="booking_form_<?= $op_index ?>_<?= $tb_index ?>"
                                                  action="<?= esc_html(home_url('')); ?><?= $this->do_book_link_option(); ?>"
                                                  method="post">
                                                <input type="hidden" name="option_index" value="<?= $op_index; ?>">
                                                <input type="hidden" name="table_index" value="<?= $tb_index; ?>">
                                                <input type="hidden" name="max_adult" value="<?= $this->max_adult; ?>">
                                                <input type="hidden" name="max_child" value="<?= $this->max_child; ?>">
                                                <input type="hidden" name="max_infant"
                                                       value="<?= $this->max_infant; ?>">
                                                <input type="hidden" name="date_get" value="<?= $this->date_get; ?>">
                                                <button class="btn btn-green btn-block text-uppercase text-bold"
                                                        type="submit">Book now
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php
                endforeach; ?>
            <?php endforeach;
        }
        return $options;
    }

}

$new_option = new TourOptionClass();
$new_option->check_tour_option();
$new_option->do_book_link_option();