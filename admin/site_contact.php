<?php

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 1/6/2016
 * Time: 11:13 AM
 */
class site_contact
{
    function __construct()
    {
        add_action('wp_enqueue_scripts', 'validator', 100);
        add_action('wp_head', 'google_captcha_script', 100);
        add_shortcode('site_contact_form', [$this, 'contact_shortcode']);
    }

    function html_contact_form()
    {
        ?>
        <h3 style="font-weight: 600;margin-bottom: 20px;">Leave us a message</h3>
        <form id="travel_contact_form" role="form" data-toggle="validator" method="post"
              action="/<?= GDS::get_option(['booking_page', 'contact']) ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="contact_full_name" id="contact_full_name" required
                               placeholder="Full Name">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <input type="email" class="form-control" name="contact_email_add" id="contact_email_add"
                               required placeholder="Email">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="tel" class="form-control" name="contact_phone" id="contact_phone" required
                               placeholder="Phone">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="contact_nationality" id="contact_nationality" required>
                            <?php LIP::the_nationality_list() ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" name="contact_sms" id="contact_sms" required
                                  placeholder="Message"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <div>
                            <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha"
                                   id="hiddenRecaptcha" required>
                            <div class="g-recaptcha"
                                 data-sitekey="<?= GDS::get_option(['other_security', 'google_site']) ?>"></div>
                            <div class="cap-err"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-green btn-block text-bold text-uppercase clickGoDiv" name="cf-submitted"
                                type="submit">Send
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }

    private function save_contact($data)
    {
        global $wpdb;
        $sql = /** @lang text */
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}contact` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `status` VARCHAR(10) NOT NULL,
            `contact_full_name` VARCHAR(200) NOT NULL,
            `contact_date` DATETIME,
            `contact_email_add` VARCHAR(200) NOT NULL ,
            `contact_phone` VARCHAR(50) NOT NULL ,
            `contact_nationality` VARCHAR(200) NOT NULL ,
            `note` TEXT(200) NOT NULL ,
            PRIMARY KEY (`id`)
            )";
        $wpdb->query($sql);

        $data_insert = [
            'contact_date' => date('Y-m-d H:I:S'),
            'status' => 0,
            'contact_full_name' => $data['contact_full_name'],
            'contact_email_add' => $data['contact_email_add'],
            'contact_phone' => $data['contact_phone'],
            'contact_nationality' => $data['contact_nationality'],
            'note' => $data['note']
        ];

        $wpdb->insert(
            $wpdb->prefix . 'contact',
            $data_insert,
            [
                '%s',
                '%d'
            ]
        );
    }

    function contact_mail()
    {

        $data = [];
        if (isset($_POST['cf-submitted'])) {
            $secretKey = GDS::get_option(['other_security', 'google_secret']);
            $captcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];
//            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);

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
                        'remoteip' => $ip
                    ],
                    'cookies' => array()
                )
            );


            $responseKeys = json_decode($response['body'], true);
            if ($responseKeys["success"] == false) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                       An unexpected error occurred.
                     </div>";
            } else {
                add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

                // sanitize form values
                $data['contact_full_name'] = sanitize_text_field($_POST["contact_full_name"]);
                $data['contact_email_add'] = sanitize_email($_POST["contact_email_add"]);
                $data['contact_nationality'] = sanitize_text_field($_POST['contact_nationality']);
                $data['contact_phone'] = sanitize_text_field($_POST['contact_phone']);
                $site = site_url();
                $subject = "New contact from: {$site} - {$data['contact_full_name']} <{$data['contact_email_add']}>";
                $data['note'] = sanitize_text_field($_POST["contact_sms"]);
                $message = /** @lang text */
                    "<div>
                    <p><strong>You have a new message.<strong></p>
                    <p>Full name: <strong>{$data['contact_full_name']}</strong></p>
                    <p>Email: <strong>{$data['contact_email_add']}</strong></p>
                    <p>Nationality: <strong>{$data['contact_nationality']}</strong></p>
                    <p>Phone: <strong>{$data['contact_phone']}</strong></p>
                    <p><strong>Message:</strong></p>
					<p>{$data['note']}</p>
                    </div>";

                //save database
                $this->save_contact($data);

                // get the blog administrator's email address
                $to = GDS::get_option(['booking_email', 'global']);

                $headers = array(
                    'From: ' . $data['contact_email_add'],
                    'CC: ' . GDS::get_option(['booking_email', 'cc']),
                    'BCC: ' . GDS::get_option(['booking_email', 'bcc']),
                    'Reply-To: ' . $data['contact_full_name'] . '<' . $data['contact_email_add'] . '>',
                );

                // If email has been process for sending, display a success message
                if (wp_mail($to, $subject, $message, $headers)) {
                    echo /** @lang text */
                    '<div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       Complete, thank you for contact us.
                     </div>';
                } else {
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                       An unexpected error occurred.
                     </div>";
                }
            }
        }
    }

    function contact_shortcode()
    {
        ob_start();
        $this->contact_mail();
        $this->html_contact_form();

        return ob_get_clean();
    }
}

new site_contact();