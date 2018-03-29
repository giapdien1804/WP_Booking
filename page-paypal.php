<?php
/**
 * Template Name: Booking-return
 * Created by giapdien.
 * User: giapdien
 * email: giapdien1804@gmail.com | traihogiap@hotmail.com
 * Date: 16/05/2016
 * Time: 4:08 CH
 */
?>

<?php ob_start();
get_header(); ?>
    <div class="content" style="padding: 150px 0">
        <div class="container">
            <div style="padding: 100px 0;" class="text-center">
                <?php
                if (isset($_GET['bk_status'])) {
                    $status = explode('/', $_GET['bk_status']);


                    $data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}booking WHERE order_info = '{$status[1]}'", ARRAY_A);

                    if (!empty($data)) {
                        global $wpdb;

                        $wpdb->update($wpdb->prefix . 'booking',
                            ['booking_payment_status' => $status[0]],
                            ['booking_hash_code' => $status[1]]
                        );

                        if ($data['booking_payment_status'] == 'completed') {
                            add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

                            //send to user
                            $site = site_url();
                            $tour_name = get_the_title($data['tour_ID']);
                            $order_info = $data['order_info'];
                            $to = $data['guest_email'];
                            $ip_guest = $data['guest_IP'];

                            $subject = "Booking [{$order_info}] in {$site} -  payment: Complete";

                            $message = "<p>The booking on the tour  <strong>" . $tour_name . "</strong>  payment status has been changed to: \"Complete\"!!! </p>";
                            $message .= "<br>";
                            $message .= "<p><strong>Tour details </strong></p>";
                            $message .= "<p>Tour name: " . $tour_name . "</p>";
                            $message .= "<p>Departure date: <strong>" . $data['booking_departure_date'] . "</strong></p>";
                            $message .= "<p><strong>Option: </strong>" . $data['booking_options'] . "</p>";
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
                            $message .= "<p>Whois: <a href='http://ip2location.com/" . $ip_guest . "' target='_blank'>" . $ip_guest . "</a><p>";
                            $message .= "<hr />";
                            $message .= "<p><strong>Payment details </strong></p>";
                            $message .= "<p>Booking ID: " . $data['order_info'] . "</p>";
                            $message .= "<p>Base price: " . $data['base_price'] . "</p>";
                            $message .= "<p>Number of pax: " . $data['booking_number_of_adults'] . "</p>";
                            $message .= "<p>Single supplement: " . $data['booking_single_supp'] . "</p>";
                            $message .= "<p>Subtotal : " . $data['booking_sub_total'] . "</p>";
                            $message .= "<p>Discount: " . $data['booking_discount'] . "</p>";
                            $message .= "<p>Payment method: " . $data['booking_payment_method'] . "</p>";
                            $message .= "<p>Booking fee: " . $data['booking_fee'] . "</p>";
                            $message .= "<p>Grand total: <strong>" . $data['booking_total_amount'] . "</strong></p>";
                            $message .= "<p>Payment status : Complete</p>";
                            $message .= "<p>Payment description : Transaction Successful</p>";
                            $message .= "<p>Check payment status: <a href='" . $site . "/check-payment-status.php?code=" . $data['booking_hash_code'] . "' target='_blank'>" . $site . "/check-payment-status.php?code=" . $data['booking_hash_code'] . "</a> </p>";

                            $headers = "";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $headers .= array(
                                'From: ' . GDS::get_option(['booking_email', 'global'])
                            );
                            $attachments = '';

                            wp_mail($to, $subject, $message, $headers, $attachments);

                            //send to admin
                            $to = GDS::get_option(['booking_email', 'global']);

                            $subject = "Booking [{$order_info}] in {$site} -  payment: Complete";

                            $message = "<p>The booking on the tour  <strong>" . $tour_name . "</strong>  payment status has been changed to: \"Complete\"!!! </p>";
                            $message .= "<br>";
                            $message .= "<p><strong>Tour details </strong></p>";
                            $message .= "<p>Tour name: " . $tour_name . "</p>";
                            $message .= "<p>Departure date: <strong>" . $data['booking_departure_date'] . "</strong></p>";
                            $message .= "<p><strong>Option: </strong>" . $data['booking_options'] . "</p>";
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
                            $message .= "<p>Whois: <a href='http://ip2location.com/" . $ip_guest . "' target='_blank'>" . $ip_guest . "</a><p>";
                            $message .= "<hr />";
                            $message .= "<p><strong>Payment details </strong></p>";
                            $message .= "<p>Booking ID: " . $data['order_info'] . "</p>";
                            $message .= "<p>Base price: " . $data['base_price'] . "</p>";
                            $message .= "<p>Number of pax: " . $data['booking_number_of_adults'] . "</p>";
                            $message .= "<p>Single supplement: " . $data['booking_single_supp'] . "</p>";
                            $message .= "<p>Subtotal : " . $data['booking_sub_total'] . "</p>";
                            $message .= "<p>Discount: " . $data['booking_discount'] . "</p>";
                            $message .= "<p>Payment method: " . $data['booking_payment_method'] . "</p>";
                            $message .= "<p>Booking fee: " . $data['booking_fee'] . "</p>";
                            $message .= "<p>Grand total: <strong>" . $data['booking_total_amount'] . "</strong></p>";
                            $message .= "<p>Payment status : Complete</p>";
                            $message .= "<p>Payment description : Transaction Successful</p>";
                            $message .= "<p>Check payment status: <a href='" . $site . "/check-payment-status.php?code=" . $data['booking_hash_code'] . "' target='_blank'>" . $site . "/check-payment-status.php?code=" . $data['booking_hash_code'] . "</a> </p>";


                            $headers = array(
                                'From: ' . $data['guest_email'],
                                'CC: ' . GDS::get_option(['booking_email', 'cc']),
                                'BCC: ' . GDS::get_option(['booking_email', 'bcc'])
                            );
                            $attachments = '';

                            wp_mail($to, $subject, $message, $headers, $attachments);
                            echo "<script>
                                            alert('Transaction Successful. Thankyou for using our services');
                                            window.location.href='" . $site . "';
                                         </script>";
                            //header('Location:'. get_permalink($data['tour_ID']), true, 301);
                        } else {
                            echo "<p><i class='fa fa-exclamation-triangle fa-warning-alert'></i></p>";
                            echo "<p>The transaction is failed because of some errors. Please click the below link.</p>";
                            echo "<a class='btn btn-green' href='" . $_SESSION['payment_return'] . "'>Continue</a>";
                        }

                    } else {
                        header('Location:' . site_url(), true, 301);
                    }
                } else {
                    header('Location:' . site_url(), true, 301);
                }
                ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>