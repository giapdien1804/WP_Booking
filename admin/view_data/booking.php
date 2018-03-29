<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 27/5/2016
 * Time: 5:40 PM
 */
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class booking extends WP_List_Table
{
    public static $tbl;

    function __construct()
    {
        parent::__construct([
            'singular' => 'Booking data', //singular name of the listed records
            'plural' => 'Booking data', //plural name of the listed records
            'ajax' => false //should this table support ajax?

        ]);
        global $wpdb;
        self::$tbl = $wpdb->prefix . 'booking';
    }

    public static function get_booking($per_page = 5, $page_number = 1)
    {

        global $wpdb;

        $sql = "SELECT * FROM " . self::$tbl;

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;


        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    public static function delete_booking($id)
    {
        global $wpdb;

        $wpdb->delete(
            self::$tbl,
            ['id' => $id],
            ['%d']
        );
    }

    public static function record_count()
    {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM " . self::$tbl;

        return $wpdb->get_var($sql);
    }

    function column_name($item)
    {

        // create a nonce
        $delete_nonce = wp_create_nonce('sp_delete_booking');

        $title = '<strong>' . $item['travel_full_name'] . '</strong>';

        $actions = [
            'delete' => sprintf('<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr($_REQUEST['page']), 'delete', absint($item['ID']), $delete_nonce)
        ];

        return $title . $this->row_actions($actions);
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'travel_book_code':
            case 'travel_date':
            case 'post_id':
            case 'post_name':
            case 'travel_code':
            case 'travel_full_name':
            case 'travel_email':
            case 'travel_phone':
            case 'travel_nationality':
            case 'travel_pickup_address':
            case 'travel_departure_date':
            case 'travel_adult':
            case 'travel_child':
            case 'travel_infant':
            case 'travel_option_title':
            case 'travel_option_table':
            case 'travel_ip':
            case 'total_book':
            case 'pay_status':
            case 'note':
                return $item[$column_name];
                break;
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }

    function get_columns()
    {
        $columns = [
//            'cb' => '<input type="checkbox" />',
            'id' => 'ID',
            'travel_book_code' => 'Booking code',
            'travel_date' => 'Date time',
            'post_id' => 'Travel ID',
            'post_name' => 'Travel name',
            'travel_code' => 'Travel code',
            'travel_full_name' => 'Full name',
            'travel_email' => 'Email',
            'travel_phone' => 'Phone',
            'travel_nationality' => 'Nationality',
            'travel_pickup_address' => 'Pick up address',
            'travel_departure_date' => 'Departure',
            'travel_adult' => 'Adult',
            'travel_child' => 'Child',
            'travel_infant' => 'Infant',
            'travel_option_title' => 'Option title',
            'travel_option_table' => 'Table price',
            'travel_ip' => 'IP book',
            'total_book' => 'Total',
            'pay_status' => 'Pay status',
            'note' => 'Note'
        ];

        return $columns;
    }

    public function get_sortable_columns()
    {
        $sortable_columns = [
            'travel_full_name' => ['travel_full_name', true],
            'travel_phone' => ['travel_phone', false],
            'travel_email' => ['travel_email', false],
            'total_book' => ['total_book', false],
        ];

        return $sortable_columns;
    }

    /*public function get_bulk_actions() {
        $actions = [
            'bulk-delete' => 'Delete'
        ];

        return $actions;
    }*/

    public function prepare_items()
    {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page = $this->get_items_per_page('booking_per_page', 5);
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();

        $this->set_pagination_args([
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page //WE have to determine how many items to show on a page
        ]);


        $this->items = self::get_booking($per_page, $current_page);
    }

    public function process_bulk_action()
    {

        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr($_REQUEST['_wpnonce']);

            if (!wp_verify_nonce($nonce, 'sp_delete_customer')) {
                die('Go get a life script kiddies');
            } else {
                self::delete_booking(absint($_GET['customer']));

                wp_redirect(esc_url(add_query_arg()));
                exit;
            }

        }

        // If the delete bulk action is triggered
        if ((isset($_POST['action']) && $_POST['action'] == 'bulk-delete')
            || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')
        ) {

            $delete_ids = esc_sql($_POST['bulk-delete']);

            // loop over the array of record IDs and delete them
            foreach ($delete_ids as $id) {
                self::delete_booking($id);

            }

            wp_redirect(esc_url(add_query_arg()));
            exit;
        }
    }
}

class booking_list
{

    // class instance
    static $instance;

    // customer WP_List_Table object
    public $booking_obj;

    // class constructor
    public function __construct()
    {
        add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
        add_action('admin_menu', [$this, 'plugin_menu']);
    }

    public static function set_screen($status, $option, $value)
    {
        return $value;
    }

    public function plugin_menu()
    {

        $hook = add_menu_page(
            'Booking list',
            'Booking list',
            'manage_options',
            'booking_list',
            [$this, 'plugin_settings_page']
        );

        add_action("load-$hook", [$this, 'screen_option']);

    }

    public function screen_option()
    {

        $option = 'per_page';
        $args = [
            'label' => 'Booking list',
            'default' => 5,
            'option' => 'booking_per_page'
        ];

        add_screen_option($option, $args);

        $this->booking_obj = new booking();
    }

    public function plugin_settings_page()
    {
        ?>
        <div class="wrap">
            <h2>Travel booking list</h2>

            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
                                <?php
                                $this->booking_obj->prepare_items();
                                $this->booking_obj->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
    }

    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

$d = new booking_list();