<?php

/**
 * Created by giapdien.
 * User: giapdien
 * email: giapdien1804@gmail.com | traihogiap@hotmail.com
 * Date: 05/05/2016
 * Time: 8:18 SA
 */
class payment
{
    public $post_id;
    public $tour_options;
    public $option_index;
    public $table_index;
    public $max_adult;
    public $max_child;
    public $max_infant;
    public $number_adult;
    public $date_get;

    public function __construct($post_name)
    {
        $post_name = trim($post_name);
        $post_name = str_replace('\\u0000', "", $post_name);

        global $wpdb;
        $this->post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '{$post_name}'");
        $this->tour_options = get_post_meta($this->post_id, 'tour_options', true);

        $this->option_index = isset($_POST['option_index']) ? $_POST['option_index'] : '';
        $this->table_index = isset($_POST['table_index']) ? $_POST['table_index'] : '';
        $this->max_adult = isset($_POST['max_adult']) ? $_POST['max_adult'] : '';
        $this->max_child = isset($_POST['max_child']) ? $_POST['max_child'] : '';
        $this->max_infant = isset($_POST['max_infant']) ? $_POST['max_infant'] : '';
        $this->number_adult = isset($_POST['number_adult']) ? $_POST['number_adult'] : '';
        $this->date_get = isset($_REQUEST['date_get']) ? $_REQUEST['date_get'] : '';
    }

    public function sync_table_price($post_type, $option_index, $table_index)
    {
        $select_option = $this->tour_options[$option_index];
        $select_table = $select_option['option_table'][$table_index];

        $price_from = get_post_meta($this->post_id, $post_type . '_price_from', true);
        $price_default = (isset($select_table['pax'][0])) ? $select_table['pax'][0] : $price_from;
        $price_table[1] = $price_default;
        //dong bo so nguoi theo bang gia
        for ($i = 2; $i <= $this->find_qty('max'); $i++) {
            foreach ($select_table['qty'] as $index => $qty) {
                $ng = LIP::str_to_int($qty);
                if ($i == $ng) {
                    $price_default = LIP::str_to_float($select_table['pax'][$index]);
                    break;
                }
            }
            $price_table[$i] = $price_default;
        }

        return $price_table;
    }

    public function total_pay($option_index, $option_table, $date, $adult, $payment, $check_pick = true)
    {
        $price = 0;
        $price_new = 0;
        $price_pax = 0;
        $promotion = 0;
        $single_sup = 0;

        $price_from = get_post_meta($this->post_id, 'tour_price_from', true);
        $pick_up = get_post_meta($this->post_id, 'tour_pick_up', true);


        $select_option = $this->tour_options[$option_index];
        $select_table = $select_option['option_table'][$option_table];

        //tinh gia tour mac dinh
        if ($select_table['by_group'] != null) {
            $price_pax = LIP::str_to_float($select_table['by_group']);

        } else { //tinh gia theo bang gia va so nguoi
            $price_table = $this->sync_table_price('tour', $option_index, $option_table);

            $price_pax = $price_table[$adult];
        }

        $price = $adult * $price_pax;

        //tinh giam gia
        $pro = $select_table['promotion'];
        if (substr($pro, 0, 1) == '$') {
            $promotion = LIP::str_to_float($pro) * $adult;
        } else {
            $pro = LIP::str_to_float($pro);
            if ($pro > 0) {
                $promotion = ($price * $pro) / 100;
            } else {
                $promotion = 0;
            }
        }

        $price_new = $price - $promotion;

        //neu le 1 nguoi
        if ($adult % 2 != 0) {
            $single_sup = $select_table['single_sup'];
        }

        $price_new += $single_sup;

        //cong gia pick up
        if ($check_pick == true) {
            $price_new += $adult * LIP::str_to_float($pick_up);
        }

        $surcharge = '';

        if ($payment == 'paypal') {
            $surcharge = GDS::get_option(['booking_paypal', 'surcharge']);
        } elseif ($payment == 'one_pay') {
            $surcharge = GDS::get_option(['booking_onepay', 'surcharge']);
        } elseif ($payment == 'credit_card') {
            $surcharge = GDS::get_option(['booking_credit_card', 'surcharge']);
        }

        if (strstr($surcharge, '%') == '%') {
            $surcharge = ($price_new * LIP::str_to_float($surcharge)) / 100;
        }

        if ($surcharge > 0)
            $price_new += $surcharge;

        $total = [
            'subtotal' => LIP::out_price($price),
            'subtotal_pax' => $adult,
            'subtotal_price' => $price_pax,
            'discount' => LIP::out_price($promotion),
            'pickup' => LIP::out_price($pick_up),
            'single_sup' => LIP::out_price($single_sup),
            'payment_sur' => LIP::out_price($surcharge),
            'show_tour_option' => $this->show_tour_option_fix($date, $adult, $option_index),
            'total' => LIP::out_price($price_new),
        ];

        return $total;
    }

    public function save_database($data)
    {
        return GDS::get_option(['booking_page', 'save_database']);
    }

    public function pay_paypal($data)
    {
        //lam tron 2 con so de dam bao cho Paypal lam viec dc
        $total_pay = round($data['booking_total_amount'], 2);

        $pp_url_return = home_url() . '/' . GDS::get_option(['booking_page',
                'return']) . "/?bk_status=completed/" . $data['order_info'];
        $pp_url_pending = home_url() . '/' . GDS::get_option(['booking_page',
                'return']) . "/?bk_status=pending/" . $data['order_info'];

        $url_location = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' . GDS::get_option(['booking_paypal',
                'email']) . '&item_name=' . $data['order_info'] . '&buyer_credit_promo_code=&buyer_credit_product_category=&buyer_credit_shipping_method=&buyer_credit_user_address_change=&amount=' . $total_pay . '&no_shipping=1&return=' . $pp_url_return . '&cancel_return=' . $pp_url_pending . '&no_note=1&currency_code=USD&bn=PP%2dBuyNowBF&charset=UTF%2d8';

        return $url_location;
    }

    public function pay_one_pay($booking)
    {
        // Cac tham so co dinh
        //Title
        $Onepay['Title'] = "VPC 3-Party";

        //virtualPaymentClientURL
        $Onepay['virtualPaymentClientURL'] = "https://onepay.vn/vpcpay/vpcpay.op";

        //Merchant ID
        $Onepay['vpc_Merchant'] = GDS::get_option(['booking_onepay', 'merchant']);

        //Merchant AccessCode
        $Onepay['vpc_AccessCode'] = GDS::get_option(['booking_onepay', 'accessCode']);

        // Cac bien so
        //Merchant Transaction Reference
        $Onepay['vpc_MerchTxnRef'] = $booking['booking_hash_code'];
        //ID Transaction - (unique per transaction) - (max 40 char)

        //Transaction OrderInfo
        $Onepay['vpc_OrderInfo'] = $booking['order_info'];

        //Purchase Amount
        $totalpaynow = round($booking['booking_total_amount'], 2);

        $Onepay['vpc_Amount'] = $totalpaynow * 100;
        //Amount,Multiplied with 100, Ex: 100=1USD

        //Receipt ReturnURL
        $Onepay['vpc_ReturnURL'] = home_url() . '/' . GDS::get_option(['booking_page', 'onepay']);
        //URL for receiving payment result from gateway

        //VPC Version
        $Onepay['vpc_Version'] = "2";//Version (fixed)

        //Command Type
        $Onepay['vpc_Command'] = "pay";

        //Payment Server Display Language Locale
        $Onepay['vpc_Locale'] = "en";

        //IP address
        $Onepay['vpc_TicketNo'] = $_SERVER ['REMOTE_ADDR'];

        //Shipping Address
        $Onepay['vpc_SHIP_Street01'] = $booking['booking_pickup_address'];
        //Pickup Address

        //Shipping Province
        $Onepay['vpc_SHIP_Provice'] = "Hoan Kiem";

        //Shipping City
        $Onepay['vpc_SHIP_City'] = "Hanoi";

        //Shipping Country
        $Onepay['vpc_SHIP_Country'] = $booking['guest_nationality'];

        //Customer Phone
        $Onepay['vpc_Customer_Phone'] = $booking['guest_phone'] != "" ? $booking['guest_phone'] : 0;

        //Customer email
        $Onepay['vpc_Customer_Email'] = $booking['guest_email'];

        //Customer User Id
        $Onepay['vpc_Customer_Id'] = $booking['guest_fullname'];


        // Xu ly

        $SECURE_SECRET = GDS::get_option(['booking_onepay', 'secureSecret']);

        $vpcURL = $Onepay["virtualPaymentClientURL"] . "?";

        unset($Onepay["virtualPaymentClientURL"]);


        $Onepay['AgainLink'] = urlencode($_SERVER['HTTP_REFERER']);

        $md5HashData = "";

        ksort($Onepay);

        // set a parameter to show the first pair in the URL
        $appendAmp = 0;

        foreach ($Onepay as $key => $value) {

            if (strlen($value) > 0) {

                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }
                //$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
                if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                    $md5HashData .= $key . "=" . $value . "&";
                }
            }
        }
        //xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
        $md5HashData = rtrim($md5HashData, "&");
        // Create the secure hash and append it to the Virtual Payment Client Data if
        // the merchant secret has been provided.
        if (strlen($SECURE_SECRET) > 0) {
            //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
            // Thay hàm mã hóa dữ liệu
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)));
        }

        //header("Location: ".$vpcURL);
        $url_location = $vpcURL;

        return $url_location;
    }

    public function pay_by_vietinbank($booking)
    {
        //Title
        //global $_REQUEST;
        include 'security.php';

        $_do['Title'] = "Secure Acceptance - Vietinbank";

        $_do['action'] = GDS::get_option(['booking_credit_card',
            'url_credit']);//test: "https://testsecureacceptance.cybersource.com/pay";

        //
        $_vietinbank['access_key'] = GDS::get_option(['booking_credit_card',
            'access_key']);//test:'6efcd358d02231fc85e02f3b906428fc';//

        //
        $_vietinbank['profile_id'] = GDS::get_option(['booking_credit_card',
            'profile_id']);//test: "D41F9A1C-A2F2-44C0-BE24-33F300E62536";

        // Cac bien so
        //Merchant Transaction Reference
        $_vietinbank['reference_number'] = $booking['order_info']; //OrderRef
        //ID Transaction - (unique per transaction) - (max 25 char)

        $_vietinbank['transaction_uid'] = $booking['booking_hash_code'] . uniqid();

        //Purchase Amount
        $totalpaynow = round($booking['booking_total_amount'], 2);

        $_vietinbank['amount'] = $totalpaynow;// * 100;
        //Amount,Multiplied with 100, Ex: 100=1USD
        $_vietinbank['currency'] = "USD";

        //Receipt ReturnURL

        $_REQUEST['returnURL'] = site_url() . '/' . GDS::get_option(['booking_page', 'credit']);
        $_REQUEST['notifyEmail'] = GDS::get_option(['booking_email', 'global']);
        $_REQUEST['tour_id'] = $booking['tour_ID'];
        $_REQUEST['booking_id'] = $booking['booking_ID'];
        //URL for receiving payment result from gateway

        //signed_fied_names
        $_vietinbank['signed_field_names'] = "access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency";


        $_vietinbank['unsigned_field_names'] = "bill_to_address_line1,bill_to_address_city,bill_to_address_postal_code,bill_to_address_country,bill_to_phone,bill_to_email,bill_to_forename,bill_to_surname";

        $_vietinbank['signed_date_time'] = gmdate("Y-m-d\TH:i:s\Z");

        //Command Type
        $_vietinbank['transaction_type'] = "sale";

        //Payment Server Display Language Locale
        $_vietinbank['locale'] = "en";

        //IP address + uniqid
        $_vietinbank['transaction_uuid'] = uniqid();// . $_SERVER ['REMOTE_ADDR'];

        //Billing Address
        //$_vietinbank['bill_to_address_line1'] 	=	$booking['guest_billing_address_line1'];
        //Pickup Address
        //City
        // $_vietinbank['bill_to_address_city'] 		=	$booking['guest_nationality'];
        //$_vietinbank['bill_to_address_postal_code'] 		=	$booking['guest_billing_zipcode'];
        //Country
        $_vietinbank['bill_to_address_country'] = $booking['guest_nationality'];

        //Customer Phone
        $_vietinbank['bill_to_phone'] = $booking['guest_phone'];

        //Customer email
        $_vietinbank['bill_to_email'] = $booking['guest_email'];

        //$_vietinbank['bill_to_forename'] 	 	=	$booking['guest_firstname'];
        $_vietinbank['bill_to_surname'] = $booking['guest_fullname'];

        $_signature = sign($_vietinbank);

        $vtb = '';
        $vtb .= "<form id='payment_confirmation' action=" . GDS::get_option(['booking_credit_card',
                'url_credit']) . " method='POST' name='process'>";
        foreach ($_vietinbank as $name => $value) {
            $vtb .= "<input type='hidden' id=" . $name . " name=" . $name . " value=" . $value . ">\n";
        }
        $vtb .= "<input type='hidden' id='signature' name='signature' value=" . $_signature . ">\n";
        $vtb .= "</form>
    <script type='text/javascript'>
       document.process.submit();
    </script>";

        return $_do['action'];

        //return ['html' => $vtb];
    }

    private function find_end_date()
    {
        $max = strtotime(date('m/d/Y'));
        foreach ($this->tour_options as $v1) {
            foreach ($v1['option_table'] as $v2) {
                if ($max < strtotime($v2['valid_to']))
                    $max = strtotime($v2['valid_to']);
            }
        }

        return date('m/d/Y', $max);
    }

    private function find_qty($qty = 'min')
    {
        $min = 1;
        foreach ($this->tour_options as $v1) {
            if (array_key_exists($qty . '_qty', $v1))
                if ($min < $v1[$qty . '_qty'])
                    $min = $v1[$qty . '_qty'];
        }

        return $min;
    }

    function create_contact_form()
    {
        echo "<div class=' alert alert-warning'>We are sorry. we can not find out your request booking. Please give me your info, Tour operator will contact with you soon.  </div>";
        echo do_shortcode('[site_contact_form]');
    }

    function travel_send_mail($data)
    {

        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

        //send to user
        $site = site_url();
        $to = $data['guest_email'];
        $order_info = $data['order_info'];
        $travel_name = $data['travel_post_name'];
        $ip_guest = $data['guest_IP'];


        $subject = "New booking from {$site} [{$order_info}]";

        $message = "<p>A new booking on the tour  <strong>" . $travel_name . "</strong>  is waiting for your approval</p>";
        $message .= "<br>";
        $message .= "<p><strong>Tour details </strong></p>";
        $message .= "<p>Tour name: " . $data['travel_post_name'] . "</p>";
        $message .= "<p>Departure date: <strong>" . $data['booking_departure_date'] . "</strong></p>";
        $message .= "<p><strong>Option: </strong>" . $data['option_title'] . '--' . $data['option_table'] . "</p>";
        $message .= "<p>Pickup address: " . $data['booking_pickup_address'] . "</p>";
        $message .= "<p>Number of adults: <strong>" . $data['booking_number_of_adults'] . "</strong> -|-
						Number of kids (4-8): <strong>" . $data['booking_number_of_kids_50'] . "</strong> -|-
						Number of kids (0-4): <strong>" . $data['booking_number_of_kids_00'] . "</strong>
					 </p>";
        $message .= "<p><strong>Other request</strong></p>";
        $message .= "<p>" . $data['booking_other_request'] . "</p>";
        $message .= "<hr />";

        $message .= "<p><strong>Contact details </strong></p>";
        $message .= "<p>Full name: <strong>" . $data['guest_fullname'] . "</strong></p>";
        $message .= "<p>E-mail: <strong>" . $data['guest_email'] . "</strong></p>";
        $message .= "<p>Nationality: <strong>" . $data['guest_nationality'] . "</strong></p>";
        $message .= "<p>Phone: <strong>" . $data['guest_phone'] . "</strong></p>";
        $message .= "<p>Whois: <a href='http://ip2location.com/" . $ip_guest . "' target='_blank'>Click here</a><p>";
        $message .= "<hr />";
        $message .= "<p><strong>Payment details </strong></p>";
        $message .= "<p>Booking ID: " . $data['order_info'] . "</p>";
        $message .= "<p>Base price: " . $data['base_price'] . "</p>";
        $message .= "<p>Number of pax: " . $data['booking_number_of_adults'] . "</p>";
        $message .= "<p>Single supplement: " . $data['booking_single_supp'] . "</p>";
        $message .= "<p>Subtotal : " . $data['booking_sub_total'] . "</p>";

        $message .= "<p>Discount: " . $data['booking_discount'] . "</p>";

        if (GDS::get_option(['booking_page', 'hidden_payment']) == false) {
            $message .= "<p>Payment method: " . $data['booking_payment_method'] . "</p>";
            $message .= "<p>Booking fee: " . $data['booking_fee'] . "</p>";
        }

        $message .= "<p>Grand total: <strong>" . $data['booking_total_amount'] . "</strong></p>";

        $headers = "";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $headers .= array(
            'From: ' . GDS::get_option(['booking_email', 'global']),
            'Reply-To: ' . str_replace('www.', '', $_SERVER['SERVER_NAME']) . '<' . GDS::get_option(['booking_email',
                'global']) . '>',
        );

        $attachments = '';

        wp_mail($to, $subject, $message, $headers, $attachments);

        //send to admin
        $to = GDS::get_option(['booking_email', 'global']);
        $subject = "New booking from {$site} [{$order_info}]";

        $message = "<p>A new booking on the tour  <strong>" . $travel_name . "</strong>  is waiting for your approval</p>";
        $message .= "<br>";
        $message .= "<p><strong>Tour details </strong></p>";
        $message .= "<p>Tour name: " . $data['travel_post_name'] . "</p>";
        $message .= "<p>Departure date: <strong>" . $data['booking_departure_date'] . "</strong></p>";
        $message .= "<p><strong>Option: </strong>" . $data['option_title'] . '--' . $data['option_table'] . "</p>";
        $message .= "<p>Pickup address: " . $data['booking_pickup_address'] . "</p>";
        $message .= "<p>Number of adults: <strong>" . $data['booking_number_of_adults'] . "</strong> -|-
						Number of kids (4-8): <strong>" . $data['booking_number_of_kids_50'] . "</strong> -|-
						Number of kids (0-4): <strong>" . $data['booking_number_of_kids_00'] . "</strong>
					 </p>";
        $message .= "<p><strong>Other request</strong></p>";
        $message .= "<p>" . $data['booking_other_request'] . "</p>";
        $message .= "<hr />";

        $message .= "<p><strong>Contact details </strong></p>";
        $message .= "<p>Full name: <strong>" . $data['guest_fullname'] . "</strong></p>";
        $message .= "<p>E-mail: <strong>" . $data['guest_email'] . "</strong></p>";
        $message .= "<p>Nationality: <strong>" . $data['guest_nationality'] . "</strong></p>";
        $message .= "<p>Phone: <strong>" . $data['guest_phone'] . "</strong></p>";
        $message .= "<p>Whois: <a href='http://ip2location.com/" . $ip_guest . "' target='_blank'>Click here</a><p>";
        $message .= "<hr />";
        $message .= "<p><strong>Payment details </strong></p>";
        $message .= "<p>Booking ID: " . $data['order_info'] . "</p>";
        $message .= "<p>Base price: " . $data['base_price'] . "</p>";
        $message .= "<p>Number of pax: " . $data['booking_number_of_adults'] . "</p>";
        $message .= "<p>Single supplement: " . $data['booking_single_supp'] . "</p>";
        $message .= "<p>Subtotal : " . $data['booking_sub_total'] . "</p>";
        $message .= "<p>Discount: " . $data['booking_discount'] . "</p>";
        if (GDS::get_option(['booking_page', 'hidden_payment']) == false) {
            $message .= "<p>Payment method: " . $data['booking_payment_method'] . "</p>";
            $message .= "<p>Booking fee: " . $data['booking_fee'] . "</p>";
        }
        $message .= "<p>Grand total: <strong>" . $data['booking_total_amount'] . "</strong></p>";
        $headers = array(
            'From: ' . $data['guest_email'],
            'CC: ' . GDS::get_option(['booking_email', 'cc']),
            'BCC: ' . GDS::get_option(['booking_email', 'bcc']),
            'Reply-To: ' . $data['guest_fullname'] . '<' . $data['guest_email'] . '>',
        );
        $attachments = '';

        wp_mail($to, $subject, $message, $headers, $attachments);


    }

    //fix show option theo code moi cua khoa
    function show_tour_option_fix($date, $adult, $option_return = 0)
    {
        $option_book = $this->tour_options[$this->option_index];
        $table = $option_book['option_table'][$this->table_index];
        $str = '';
        $pick_up_check = $single_sup_check = $promotion_check = $price_pax = $single_sup = $pick_up = $promotion = 0;

        $price_pax = ($table['by_group'] != null) ? LIP::str_to_float($table['by_group']) : $this->sync_table_price('tour', $this->option_index, $this->table_index)[$adult];
        $single_sup = LIP::out_price($table['single_sup']);
        $pick_up = LIP::out_price(get_post_meta($this->post_id, 'tour_pick_up', true));
        $promotion = (substr($table['promotion'], 0, 1) == '$') ? LIP::out_price(Lip::str_to_float($table['promotion'])) : $table['promotion'] . '%';

        $promotion_check = LIP::out_put_array($table, 'promotion');
        $single_sup_check = LIP::out_put_array($table, 'single_sup');
        $pick_up_check = get_post_meta($this->post_id, 'tour_pick_up', true);

        $content = "<p class='text-600' style='line-height: 1.8'>Price: <span class='info-popup-book'>{$price_pax}/Pax</span><br/>";
        if ($promotion_check) {
            $content .= "Promotion: <span class='info-popup-book'> {$promotion}</span><br/>";
        }

        if ($single_sup_check)
            $content .= "Single supplement: <span class='info-popup-book'>{$single_sup}</span><br/>";
        if ($pick_up_check)
            $content .= "Pick up: <span class='info-popup-book'>{$pick_up}</span></p>";

        $str .= "
                   <div class='radio fix-by-diengiap'>
                      <label class='text-bold'><input class='text-bold' type='radio' name='travel_option_index' data-select-table='{$this->table_index}' value='{$this->option_index}' checked required>{$option_book['option_title']}</label>
                    </div>
                    <div class='collapses' id=\"collapseExample\">
                      <div class=\"well\">
                         <strong>{$table['lít_price_name']}</strong>
                         {$content}
                      </div>
                    </div>";

        return $str;
    }

    function show_tour_option_old($date, $adult, $option_return = 0)
    {
        $option_book = $this->tour_options[$this->option_index];
        $table = $option_book['option_table'][$this->table_index];
        $str = '';
        $user_date = strtotime($date);
        foreach ($this->tour_options as $index => $option) {
            $disabled = 'disabled';
            $checked = ($this->option_index == $index) ? 'checked' : '';
            $pick_up_check = $single_sup_check = $promotion_check = $price_pax = $single_sup = $pick_up = $promotion = 0;
            $list_price_name = '';
            $table_select = 0;
            $display = ($this->option_index == $index) ? '' : 'hidden';
            foreach ($option['option_table'] as $table_index => $table) {
                $valid_to = strtotime($table['valid_to']);
                $valid_from = strtotime($table['valid_from']);
                if ($user_date >= $valid_from && $user_date <= $valid_to) {
                    $price_pax = ($table['by_group'] != null) ? LIP::str_to_float($table['by_group']) : $this->sync_table_price('tour', $index, $table_index)[$adult];
                    $single_sup = LIP::out_price($table['single_sup']);
                    $pick_up = LIP::out_price(get_post_meta($this->post_id, 'tour_pick_up', true));
                    $promotion = (substr($table['promotion'], 0, 1) == '$') ? LIP::out_price(Lip::str_to_float($table['promotion'])) : $table['promotion'] . '%';
                    $list_price_name = $table['list_price_name'];
                    $disabled = '';
                    $table_select = $table_index;

                    //check
                    $promotion_check = LIP::out_put_array($table, 'promotion');
                    $single_sup_check = LIP::out_put_array($table, 'single_sup');
                    $pick_up_check = get_post_meta($this->post_id, 'tour_pick_up', true);

                    break;
                }
            }

            if ($disabled != '') {
                $list_price_name = 'Departure date is invalid !';
                $content = "<p>We can not find the service to be provided on the day of your choice. Please choose the  tour departure date.</p>";
            } else {
                $content = "<p class='text-600' style='line-height: 1.8'>Price: <span class='info-popup-book'>{$price_pax}/Pax</span><br/>";
                if ($promotion_check) {
                    $content .= "Promotion: <span class='info-popup-book'> {$promotion}</span><br/>";
                }

                if ($single_sup_check)
                    $content .= "Single supplement: <span class='info-popup-book'>{$single_sup}</span><br/>";
                if ($pick_up_check)
                    $content .= "Pick up: <span class='info-popup-book'>{$pick_up}</span></p>";
            }

            $str .= "
                   <div class='radio {$display} {$disabled}'>
                      <label class='text-bold'><input class='text-bold' type='radio' name='travel_option_index' data-select-table='{$table_select}' value='{$index}' {$disabled} {$checked} required>{$option['option_title']}</label>
                    </div>
                    <div class='collapses  {$display}' id=\"collapseExample\">
                      <div class=\"well\">
                         <strong>{$list_price_name}</strong>
                         {$content}
                      </div>
                    </div>";

        }

        return $str;
    }

    function get_pickup()
    {
        return $this->tour_options = get_post_meta($this->post_id, 'tour_pick_up', true);

    }

    function create_booking_form()
    {
        ?>
        <form id="travel_booking_form" role="form" method="post" class="margin-top-20"
              action="/<?= GDS::get_option(['booking_page', 'booking']) ?>">
            <input type="hidden" name="travel_local_id" id="travel_local_id"
                   value="<?php echo LIP::encryption(get_post_field('post_name', $this->post_id)) ?>"
                   title="">
            <input type="hidden" name="user_id" title="User id"
                   value="<?= isset($_GET['user_id']) ? $_GET['user_id'] : 0 ?>">
            <input type="hidden" name="sale_id" title="User id"
                   value="<?= isset($_GET['sale_id']) ? $_GET['sale_id'] : '00' ?>">
            <div class="margin-bottom-30">
                <h3><span class="span-day span-day-tailor"><strong>1</strong></span><span class="title-tailor-made">Tour information
                            </span></h3>
            </div>
            <div class="row">
                <div class="col-sm-5 col-md-4 col-lg-6">
                    <div class="thumbnail-img">
                        <?= get_the_post_thumbnail($this->post_id); ?>
                    </div>
                </div>
                <div class="col-sm-7 col-md-8 col-lg-6">
                    <h2 class="heading-title-post font-size-18 margin-bottom-10"><?= get_the_title($this->post_id); ?></h2>
                    <table class="table tale-booking-info">
                        <tr>
                            <td><strong><i class="fa fa-barcode"></i> Tour code:</strong></td>
                            <td><?= get_post_meta($this->post_id, 'tour_default', true)['code'] ?></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fa fa-clock-o"></i> Duration:</strong></td>
                            <td><?php $explode_tour = explode('-', get_post_meta($this->post_id, 'tour_duration', true)); ?>
                                <?= $explode_tour[0]; ?> <?= $explode_tour[1] ?></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fa fa-calendar"></i> Departure date:</strong></td>
                            <td><?= $this->date_get; ?></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fa fa-user"></i> Adult(s):</strong></td>
                            <td><?= $this->max_adult; ?></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fa fa-user"></i> Child(4-8 yrs):</strong> <?= $this->max_child; ?>
                            </td>
                            <td><strong><i class="fa fa-user"></i> Infant(under 4):</strong> <?= $this->max_infant; ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-12">
                    <div class="form-group hidden">
                        <?php
                        $today = date('m/d/Y');
                        $pre_book = get_post_meta($this->post_id, 'tour_pre_book', true); ?>
                        <input type="text" class="form-control" name="booking_departure_date"
                               id="booking_departure_date" value="<?= $this->date_get ?>">

                        <input type="number" class="form-control" name="booking_number_of_adults"
                               id="booking_number_of_adults" value="<?= $this->max_adult; ?>">

                        <input type="number" class="form-control" name="booking_number_of_kids_50"
                               id="booking_number_of_kids_50" value="<?= $this->max_child; ?>">

                        <input type="number" class="form-control" name="booking_number_of_kids_00"
                               id="booking_number_of_kids_00" value="<?= $this->max_infant; ?>">

                    </div>
                    <fieldset class="margin-bottom-30">
                        <legend><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Options</legend>
                        <div class="form-group show-tour-option">
                            <!--                            fix by diengiap-->
                            <?= $this->show_tour_option_fix($this->date_get, $this->max_adult) ?>
                        </div>
                        <div class="form-group">
                            <?php $pick_up_checkbox = get_post_meta($this->post_id, 'tour_pick_up', true);
                            if ($pick_up_checkbox) : ?>
                                <input type="checkbox" name="check_pick" id="check_pick"
                                       value="<?php echo $this->get_pickup() ?>"> Pick up
                                <a role="button" data-toggle="collapse" href="#collapsePickup" aria-expanded="false"
                                   aria-controls="collapsePickup"><i class="fa fa fa-info-circle"></i> </a></label>
                            <?php endif; ?>
                            <div class="collapse margin-top-10" id="collapsePickup">
                                <div class="well">
                                    Price per person for pickup transfer, you can book or not.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group" id="input_pick_up" style="display: none;">
                                    <label for="booking_pickup_address">Pickup address</label>
                                    <input type="text" class="form-control" name="booking_pickup_address"
                                           id="booking_pickup_address">
                                </div>
                                <div class="form-group">
                                    <label for="booking_other_request" class="control-label">Other request</label>
                                    <textarea name="booking_other_request" rows="5" id="booking_other_request"
                                              class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="margin-bottom-30">
                        <legend><i class="fa fa-list-alt" aria-hidden="true"></i> Payment details</legend>
                        <?php if (GDS::get_option(['booking_page', 'hidden_payment']) == false) { ?>
                            <div class="form-group payment_method">
                                <label class="control-label">Payment method: </label>
                                <?php if (GDS::get_option(['booking_paypal', 'show_paypal']) == true) { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="booking_payment_method" value="paypal" checked> Paypal
                                    </label>
                                <?php }
                                if (GDS::get_option(['booking_onepay', 'show_onepay']) == true) { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="booking_payment_method" value="one_pay"> Onepay
                                    </label>
                                <?php }
                                if (GDS::get_option(['booking_credit_card', 'show_credit_card']) == true) { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="booking_payment_method" value="credit_card"> Credit
                                        Card
                                    </label>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="form-group invoice">
                            <table width="50%" style="line-height: 2">
                                <tr>
                                    <td><strong>Subtotal:</strong></td>
                                    <td><strong><span class="subtotal-price"></span> X <span
                                                    class="subtotal-pax"></span> =
                                            <span class="subtotal"></span></strong></td>
                                </tr>
                                <tr>
                                    <td><strong class="text-danger">Discount amount:</strong></td>
                                    <td><strong><span class="text-danger discount"></span></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Single Supplement:</strong></td>
                                    <td><strong><span class="single-sup"></span></strong></td>
                                </tr>
                                <?php if ($pick_up_checkbox) { ?>
                                    <tr>
                                        <td><strong>Pick up:</strong></td>
                                        <td><strong><span class="pickup"></span>/person</strong></td>
                                    </tr>
                                <?php } ?>
                                <?php if (GDS::get_option(['booking_page', 'hidden_payment']) == false) { ?>
                                    <tr>
                                        <td><strong>Payment surcharge:</strong></td>
                                        <td><strong><span class="payment-sur"></span></strong></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td><strong class="text-danger">Total amount:</strong></td>
                                    <td><strong style="font-size: 22px"><span
                                                    class="text-danger total mark"></span></strong></td>
                                </tr>

                            </table>
                        </div>
                    </fieldset>
                    <fieldset class="margin-bottom-30">
                        <div class="margin-bottom-30">
                            <h3><span class="span-day span-day-tailor"><strong>2</strong></span><span
                                        class="title-tailor-made">Guest Information
                            </span></h3>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="guest_fullname">Full name</label>
                                    <input type="text" class="form-control" name="guest_fullname"
                                           id="guest_fullname" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="guest_email">Email</label>
                                    <input type="email" class="form-control" name="guest_email" id="guest_email"
                                           required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="guest_phone">Phone</label>
                                    <input type="tel" class="form-control" name="guest_phone" id="guest_phone"
                                           required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="guest_nationality">Nationality</label>
                                    <select class="form-control" name="guest_nationality" id="guest_nationality"
                                            required>
                                        <?php LIP::the_nationality_list() ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="margin-bottom-30">
                        <legend><i class="fa fa-file-text-o" aria-hidden="true"></i> Term and conditions</legend>
                        <div class="term-and-conditions">
                            <?= GDS::get_option(['term_and_condition']) ?>
                        </div>
                        <div class="form-group">
                            <hr/>
                            <label class="control-label">
                                <input type="checkbox" value="1" required>
                                By selecting to complete this booking I acknowledge that I have read and accept the
                                Terms & Conditions
                            </label>
                            <div class="help-block with-errors"></div>
                            <p></p>
                            <div>
                                <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha"
                                       id="hiddenRecaptcha" required>
                                <div class="g-recaptcha"
                                     data-sitekey="<?= GDS::get_option(['other_security', 'google_site']) ?>"></div>
                                <div class="cap-err"></div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="reset" class="btn btn-danger clickGoDiv text-bold text-uppercase">Reset
                            </button>
                            <button type="submit" name="travel_pay_now" id="travel_pay_now"
                                    class="btn btn-green clickGoDiv clickGoDiv text-bold text-uppercase">Book Now
                            </button>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
        <?php
    }

    function create_travel_booking_form()
    {
        if ($this->tour_options != null && $this->option_index != null && $this->table_index != null && $this->date_get != null && $this->max_adult != null) {
            $this->create_booking_form();
            add_action('wp_head', 'ajaxurl');
            do_action('wp_head');
            add_action('wp_enqueue_scripts', 'validator', 100);
            do_action('wp_enqueue_scripts');
            add_action('wp_head', 'google_captcha_script', 100);
            do_action('wp_head');
            add_action('wp_enqueue_scripts', 'payment', 100);
            do_action('wp_enqueue_scripts');
        } else {
            $this->create_contact_form();
        }
    }

    function save_booking($data)
    {

        global $wpdb;
        $sql = /** @lang text */
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}booking` (
          `booking_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
          `booking_hash_code` varchar(255) NOT NULL,
          `order_info` varchar(100) NOT NULL,
          `tour_ID` int(20)  DEFAULT '0',
          `guest_fullname` varchar(100) DEFAULT NULL,
          `guest_email` varchar(100) DEFAULT '',
          `guest_nationality` varchar(100) DEFAULT '',
          `guest_phone` varchar(20) DEFAULT '',
          `guest_IP` varchar(20) DEFAULT '0.0.0.0',
          `booking_departure_date` varchar(10) DEFAULT '00-00-0000',
          `booking_options` varchar(255) DEFAULT 'Default',
          `booking_pickup_address` varchar(255) DEFAULT NULL,
          `booking_number_of_adults` smallint(6) DEFAULT '1',
          `booking_number_of_kids_50` smallint(6) DEFAULT '0',
          `booking_number_of_kids_00` smallint(6) DEFAULT '0',
          `booking_other_request` text,
          `booking_item_price` float(8,2) DEFAULT '0.00',
          `base_price` float(8,2) DEFAULT '0.00',
          `booking_single_supp` float(8,2) DEFAULT '0.00',
          `booking_discount` float(5,2)  DEFAULT '0.00',
          `booking_payment_method` varchar(25) DEFAULT NULL,
          `booking_payment_status` varchar(64) NOT NULL DEFAULT 'Pending',
          `booking_fee` float(5,2) DEFAULT NULL,
          `booking_sub_total` float(9,2)  DEFAULT '0.00',
          `booking_total_amount` float(9,2) NOT NULL DEFAULT '0.00',
          `booking_approved` varchar(20) DEFAULT NULL,
          `booking_create_time` datetime DEFAULT NULL,
          `booking_update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `sale_id` varchar(32)  DEFAULT '00',
          `user_id` bigint(20) DEFAULT '0',
          `service_data` TEXT,
          `hotel_data` TEXT,
          `transfer_data` TEXT,
          `cruise_data` TEXT,
          `status` varchar(10) NOT NULL,
          PRIMARY KEY (`booking_ID`),
          UNIQUE KEY `session_id` (`booking_hash_code`)
        )";
        $wpdb->query($sql);

        $data['option_title'] = $this->tour_options[$data['travel_option_index']]['option_title'];
        $data['option_table'] = $this->tour_options[$data['travel_option_index']]['option_table'][$data['travel_option_table']]['list_price_name'];

        $data_insert = [
            'booking_ID' => $data['booking_ID'],
            'status' => 0,
            'booking_hash_code' => $data['booking_hash_code'],
            'order_info' => $data['order_info'],
            'tour_ID' => $this->post_id,
            //            'post_name' => $data['travel_post_name'],
            //            'travel_code' => get_post_meta($this->post_id, 'tour_default', true)['code'],
            'guest_fullname' => sanitize_text_field($data['guest_fullname']),
            'guest_email' => sanitize_email($data['guest_email']),
            'guest_nationality' => sanitize_text_field($data['guest_nationality']),
            'guest_phone' => sanitize_text_field($data['guest_phone']),
            'guest_IP' => $_SERVER['REMOTE_ADDR'],
            'booking_departure_date' => date('Y-m-d', strtotime($data['booking_departure_date'])),
            'booking_options' => $data['option_title'] . '---' . $data['option_table'],
            'booking_pickup_address' => sanitize_text_field($data['booking_pickup_address']),
            'booking_number_of_adults' => sanitize_text_field($data['booking_number_of_adults']),
            'booking_number_of_kids_50' => sanitize_text_field($data['booking_number_of_kids_50']),
            'booking_number_of_kids_00' => sanitize_text_field($data['booking_number_of_kids_00']),
            'booking_other_request' => sanitize_text_field($data['booking_other_request']),
            'booking_item_price' => $data['booking_item_price'],
            'base_price' => $data['base_price'],
            //            'booking_addition_price' => $data['booking_addition_price'],
            'booking_single_supp' => $data['booking_single_supp'],
            'booking_discount' => $data['booking_discount'],
            'booking_payment_method' => $data['booking_payment_method'],
            'booking_payment_status' => 'pending',
            'booking_fee' => $data['booking_fee'],
            'booking_sub_total' => $data['booking_sub_total'],
            'booking_total_amount' => $data['booking_total_amount'],
            'booking_approved' => $data['booking_approved'],
            'booking_create_time' => date('Y-m-d'),
            'sale_id' => $data['sale_id'],
            'user_id' => $data['user_id'],
        ];

        $wpdb->insert(
            $wpdb->prefix . 'booking',
            $data_insert,
            [
                '%s',
                '%d',
            ]
        );

        $data_update = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}booking WHERE booking_hash_code = '{$data['booking_hash_code']}'", ARRAY_A);

        if (!empty(GDS::get_option(['booking_price', 'code_book']))) {
            $code_book = GDS::get_option(['booking_price', 'code_book']);
        } else {
            $code_book = 'w1b';
        }


        $order_info_update = date('ym', strtotime($data['booking_departure_date'])) . $code_book . $data_update['booking_ID'] . '-' . get_post_meta($data_update['tour_ID'], 'tour_default', true)['code'];
        $data['order_info'] = $order_info_update;
        $wpdb->update($wpdb->prefix . 'booking',
            ['order_info' => $order_info_update],
            ['booking_hash_code' => $data_update['booking_hash_code']]
        );

        //send mail
        $this->travel_send_mail($data);
    }
}

function send_sms_data()
{
    $payment = new payment(LIP::decrypttion($_POST['travel_local_id']));

    $response = $payment->total_pay($_POST['option_index'], $_POST['table_index'], $_POST['date_get'], $_POST['number_adult'], $_POST['payment_method'], $_POST['check_pick']);
    echo json_encode($response);
    wp_die();
}

add_action('wp_ajax_send_sms_data', 'send_sms_data');
add_action('wp_ajax_nopriv_send_sms_data', 'send_sms_data');

function travel_pay_now()
{
    $out = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tmp = $_POST['data'];
        $data = [];
        foreach ($tmp as $k => $v) {
            $data[$v['name']] = $v['value'];
        }
        $payment = new payment(LIP::decrypttion($data['travel_local_id']));

        //check client key send
        if ($payment->post_id == null) {
            $out['status'] = 'false';
            echo json_encode($out);
            wp_die();
        }

        $secretKey = GDS::get_option(['other_security', 'google_secret']);
        $captcha = $data['g-recaptcha-response'];
        $ip = $_SERVER['REMOTE_ADDR'];
        // $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $response = wp_remote_post($url, array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'body' => [
                    'secret' => $secretKey,
                    'response' => $captcha,
                    'remoteip' => $ip,
                ],
                'cookies' => array(),
            )
        );

        $responseKeys = json_decode($response['body'], true);
        if ($responseKeys["success"] == false) {
            $out['status'] = 'recaptcha';
            echo json_encode($out);
            wp_die();
        } else {
            $total = $payment->total_pay($data['travel_option_index'], $data['travel_option_table'], $_POST['booking_departure_date'], $data['booking_number_of_adults'], $data['booking_payment_method']);
            $data['travel_post_name'] = get_the_title($payment->post_id);
            $data['base_price'] = get_post_meta($payment->post_id, 'tour_price_from')[0];
            $data['booking_total_amount'] = LIP::str_to_float($total['total']);
            $data['booking_single_supp'] = LIP::str_to_float($total['single_sup']);
            $data['booking_sub_total'] = LIP::str_to_float($total['subtotal']);
            $data['booking_fee'] = LIP::str_to_float($total['payment_sur']);
            $data['booking_discount'] = LIP::str_to_float($total['discount']);
            $data['booking_hash_code'] = date('YmdHis') . rand();
            $data['booking_create_time'] = date('Y-m-d H:i:s');
            $data['booking_discount'] = LIP::str_to_float($total['discount']);
            $data['booking_approved'] = 1;
            $data['order_info'] = date('ym', strtotime($data['booking_departure_date'])) . 'w1b' . $payment->post_id . '-' . get_post_meta($payment->post_id, 'tour_default', true)['code'];
            $payment->save_booking($data);
            global $wpdb;
            $data_order_update_info = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}booking WHERE booking_hash_code = '{$data['booking_hash_code']}'", ARRAY_A);
            $data['order_info'] = $data_order_update_info['order_info'];
            if ($data['booking_payment_method'] == 'one_pay')
                $link = $payment->pay_one_pay($data);
            elseif ($data['booking_payment_method'] == 'credit_card')
                $link = $payment->pay_by_vietinbank($data);
            elseif ($data['booking_payment_method'] == 'paypal')
                $link = $payment->pay_paypal($data);
            else
                $link = $payment->save_database($data);
            $out['status'] = 'complete';
            if (isset($link['html']))
                $out['html'] = $link['html'];
            else
                $out['link'] = $link;
            $_SESSION['payment_return'] = $link;
            echo json_encode($out);
            wp_die();
        }
    } else {
        $out['status'] = 'false';
    }

    echo json_encode($out);
    wp_die();
}

add_action('wp_ajax_travel_pay_now', 'travel_pay_now');
add_action('wp_ajax_nopriv_travel_pay_now', 'travel_pay_now');