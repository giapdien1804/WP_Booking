<?php
/**
 * Template Name: Booking-onepay
 * Created by giapdien.
 * User: giapdien
 * email: giapdien1804@gmail.com | traihogiap@hotmail.com
 * Date: 16/05/2016
 * Time: 4:08 CH
 */
?>

<?php
ob_start();
// *********************
// START OF MAIN PROGRAM
// *********************

// Define Constants
// ----------------
// This is secret for encoding the MD5 hash
// This secret will vary from merchant to merchant
// To not create a secure hash, let SECURE_SECRET be an empty string - ""
// $SECURE_SECRET = "secure-hash-secret";
$SECURE_SECRET = "6D0870CDE5F24F34F3915FB0045120DB";

// get and remove the vpc_TxnResponseCode code from the response fields as we
// do not want to include this field in the hash calculation
$vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
$vpc_MerchTxnRef = $_GET["vpc_MerchTxnRef"];
//$vpc_AcqResponseCode = $_GET["vpc_AcqResponseCode"];
unset($_GET["vpc_SecureHash"]);
// set a flag to indicate if hash has been validated
$errorExists = false;

if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {

    ksort($_GET);
    //$md5HashData = $SECURE_SECRET;
    //khởi tạo chuỗi mã hóa rỗng
    $md5HashData = "";
    // sort all the incoming vpc response fields and leave out any with no value
    foreach ($_GET as $key => $value) {
//        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
//            $md5HashData .= $value;
//        }
//      chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
        if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
            $md5HashData .= $key . "=" . $value . "&";
        }
    }
//  Xóa dấu & thừa cuối chuỗi dữ liệu
    $md5HashData = rtrim($md5HashData, "&");

//    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
//    Thay hàm tạo chuỗi mã hóa
    if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $SECURE_SECRET)))) {
        // Secure Hash validation succeeded, add a data field to be displayed
        // later.
        $hashValidated = "CORRECT";
    } else {
        // Secure Hash validation failed, add a data field to be displayed
        // later.
        $hashValidated = "INVALID HASH";
    }
} else {
    // Secure Hash was not validated, add a data field to be displayed later.
    $hashValidated = "INVALID HASH";
}

// Define Variables
// ----------------
// Extract the available receipt fields from the VPC Response
// If not present then let the value be equal to 'No Value Returned'

// Standard Receipt Data
$amount = null2unknown($_GET["vpc_Amount"]);
$locale = null2unknown($_GET["vpc_Locale"]);
//$batchNo = null2unknown($_GET["vpc_BatchNo"]);
$command = null2unknown($_GET["vpc_Command"]);
$message = null2unknown($_GET["vpc_Message"]);
$version = null2unknown($_GET["vpc_Version"]);
//$cardType = null2unknown($_GET["vpc_Card"]);
$orderInfo = null2unknown($_GET["vpc_OrderInfo"]);
//$receiptNo = null2unknown($_GET["vpc_ReceiptNo"]);
$merchantID = null2unknown($_GET["vpc_Merchant"]);
//$authorizeID = null2unknown($_GET["vpc_AuthorizeId"]);
$merchTxnRef = null2unknown($_GET["vpc_MerchTxnRef"]);
//$transactionNo = null2unknown($_GET["vpc_TransactionNo"]);
//$acqResponseCode = null2unknown($_GET["vpc_AcqResponseCode"]);
$txnResponseCode = null2unknown($_GET["vpc_TxnResponseCode"]);
// 3-D Secure Data
$verType = array_key_exists("vpc_VerType", $_GET) ? $_GET["vpc_VerType"] : "No Value Returned";
$verStatus = array_key_exists("vpc_VerStatus", $_GET) ? $_GET["vpc_VerStatus"] : "No Value Returned";
$token = array_key_exists("vpc_VerToken", $_GET) ? $_GET["vpc_VerToken"] : "No Value Returned";
$verSecurLevel = array_key_exists("vpc_VerSecurityLevel", $_GET) ? $_GET["vpc_VerSecurityLevel"] : "No Value Returned";
$enrolled = array_key_exists("vpc_3DSenrolled", $_GET) ? $_GET["vpc_3DSenrolled"] : "No Value Returned";
$xid = array_key_exists("vpc_3DSXID", $_GET) ? $_GET["vpc_3DSXID"] : "No Value Returned";
$acqECI = array_key_exists("vpc_3DSECI", $_GET) ? $_GET["vpc_3DSECI"] : "No Value Returned";
$authStatus = array_key_exists("vpc_3DSstatus", $_GET) ? $_GET["vpc_3DSstatus"] : "No Value Returned";

// *******************
// END OF MAIN PROGRAM
// *******************

// FINISH TRANSACTION - Process the VPC Response Data
// =====================================================
// For the purposes of demonstration, we simply display the Result fields on a
// web page.

// Show 'Error' in title if an error condition
$errorTxt = "";

// Show this page as an error page if vpc_TxnResponseCode equals '7'
if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
    $errorTxt = "Error ";
}

// This is the display title for 'Receipt' page 
$title = $_GET["Title"];

// The URL link for the receipt to do another transaction.
// Note: This is ONLY used for this example and is not required for 
// production code. You would hard code your own URL into your application
// to allow customers to try another transaction.
//TK//$againLink = URLDecode($_GET["AgainLink"]);


$transStatus = "";
if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
    $transStatus = "Transaction Successful";
} elseif ($hashValidated == "INVALID HASH" && $txnResponseCode == "0") {
    $transStatus = "Transaction  Pendding";
} else {
    $transStatus = "Transaction Error";
}
?>

<?php get_header(); ?>
    <div class="content" style="padding: 150px 0;">
        <div class="container">
            <div style="padding: 100px 0;" class="text-center">
                <h1 class="heading-title-post"><?php echo $transStatus; ?></h1>
                <?php

                if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {

                    $data = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}booking WHERE order_info = '{$orderInfo}'", ARRAY_A);

                    if (!empty($data)) {
                        global $wpdb;

                        $wpdb->update($wpdb->prefix . 'booking',
                            ['booking_payment_status' => 'completed'],
                            ['order_info' => $orderInfo]
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
                                        ";
                            //header('Location:'. get_permalink($data['tour_ID']), true, 301);
                        }

                    } else {
                        header('Location:' . site_url(), true, 301);
                    }

                } elseif ($hashValidated == "INVALID HASH" && $txnResponseCode == "0") {
                    echo "<p>The transaction is failed because of some errors. Please click the below link.</p>";
                    echo "<a class='btn btn-green' href='" . $_SESSION['payment_return'] . "'>Continue</a>";
                } else {
                    echo "<p>The transaction is failed because of some errors. Please click the below link.</p>";
                    echo "<a class='btn btn-green' href='" . $_SESSION['payment_return'] . "'>Continue</a>";
                }

                ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>


<?php
// End Processing

// This method uses the QSI Response code retrieved from the Digital
// Receipt and returns an appropriate description for the QSI Response Code
//
// @param $responseCode String containing the QSI Response Code
//
// @return String containing the appropriate description
//
function getResponseDescription($responseCode)
{

    switch ($responseCode) {
        case "0" :
            $result = "Transaction Successful";
            break;
        case "?" :
            $result = "Transaction status is unknown";
            break;
        case "1" :
            $result = "Bank system reject";
            break;
        case "2" :
            $result = "Bank Declined Transaction";
            break;
        case "3" :
            $result = "No Reply from Bank";
            break;
        case "4" :
            $result = "Expired Card";
            break;
        case "5" :
            $result = "Insufficient funds";
            break;
        case "6" :
            $result = "Error Communicating with Bank";
            break;
        case "7" :
            $result = "Payment Server System Error";
            break;
        case "8" :
            $result = "Transaction Type Not Supported";
            break;
        case "9" :
            $result = "Bank declined transaction (Do not contact Bank)";
            break;
        case "A" :
            $result = "Transaction Aborted";
            break;
        case "C" :
            $result = "Transaction Cancelled";
            break;
        case "D" :
            $result = "Deferred transaction has been received and is awaiting processing";
            break;
        case "F" :
            $result = "3D Secure Authentication failed";
            break;
        case "I" :
            $result = "Card Security Code verification failed";
            break;
        case "L" :
            $result = "Shopping Transaction Locked (Please try the transaction again later)";
            break;
        case "N" :
            $result = "Cardholder is not enrolled in Authentication scheme";
            break;
        case "P" :
            $result = "Transaction has been received by the Payment Adaptor and is being processed";
            break;
        case "R" :
            $result = "Transaction was not processed - Reached limit of retry attempts allowed";
            break;
        case "S" :
            $result = "Duplicate SessionID (OrderInfo)";
            break;
        case "T" :
            $result = "Address Verification Failed";
            break;
        case "U" :
            $result = "Card Security Code Failed";
            break;
        case "V" :
            $result = "Address Verification and Card Security Code Failed";
            break;
        case "99" :
            $result = "User Cancel";
            break;
        default  :
            $result = "Unable to be determined";
    }
    return $result;
}

// If input is null, returns string "No Value Returned", else returns input
function null2unknown($data)
{
    if ($data == "") {
        return "No Value Returned";
    } else {
        return $data;
    }
}

//  ----------------------------------------------------------------------------
?>