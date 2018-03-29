<?php
/**
 * Copyright (c) 2016. giapdien1804@gmail.com
 */

/**
 * Created by PhpStorm.
 * User: traih
 * Date: 21/7/2016
 * Time: 9:59 AM
 */
class tailor_made
{
    function __construct()
    {
        add_action('wp_enqueue_scripts', 'validator', 100);
        add_action('wp_head', 'google_captcha_script', 100);
        add_shortcode('tailor_made', [$this, 'tailor_made_shortcode']);
    }

    function html_tour_form()
    {
        ?>
        <form id="customize_form" role="form" data-toggle="validator" method="post"
              action="/<?= GDS::get_option(['booking_page', 'tailor_made']) ?>">
            <div class="row">
                <div class="col-sm-12">
                    <div class="margin-bottom-10">
                        <h3><span class="span-day span-day-tailor"><strong>1</strong></span><span
                                    class="title-tailor-made">Where would you like to visit?</span</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group form-destination">
                                <div class="row row-render">
                                    <?php
                                    $args = [
                                        'post_type' => 'location',
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish',
                                        'order' => 'ASC',
                                        'orderby' => 'menu_order'
                                    ];
                                    $the_query = new WP_Query($args);
                                    if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
                                        <div class="col-sm-4 col-md-3 col-lg-3 col-render">
                                            <div class="checkbox">
                                                <a href="<?php the_permalink(); ?>"
                                                   class="thumbnail-img"><?php the_post_thumbnail('medium_large', ['title' => get_the_title()]); ?></a>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="preferred_destination[]"
                                                           value="<?php the_title(); ?>"> <?php the_title(); ?>
                                                </label>

                                            </div>
                                        </div>
                                    <?php endwhile;
                                        wp_reset_postdata(); endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="margin-bottom-30">
                        <h3><span class="span-day span-day-tailor"><strong>2</strong></span><span
                                    class="title-tailor-made">Tour Information</span</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="contact_estimated">Estimated length of stay</label>
                                <input type="text" class="form-control" name="contact_estimated" id="contact_estimated">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group inner-addon right-addon">
                                <label for="contact_arrival">Estimated arrival date</label>
                                <i class="glyphicon glyphicon-calendar"></i>
                                <input type="text" class="form-control customize-date" name="contact_arrival"
                                       id="contact_arrival" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group inner-addon right-addon">
                                <label for="contact_departure">Estimated departure date</label>
                                <i class="glyphicon glyphicon-calendar"></i>
                                <input type="text" class="form-control customize-date" name="contact_departure"
                                       id="contact_departure" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="contact_adult">Adult(s)</label>
                                <input type="number" class="form-control" name="contact_adult" id="contact_adult"
                                       required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="contact_children">Kids(4 - 8 years old)</label>
                                <input type="number" class="form-control" name="contact_children" id="contact_children"
                                       required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="contact_kids">Kids(0 - 4 years old)</label>
                                <input type="number" class="form-control" name="contact_kids" id="contact_kids"
                                       required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Preferred Transportation</label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Train"> Train
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Flight"> Flight
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Car"> Car
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Motobike">
                                        Motobike
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Bike"> Bike
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Cruise"> Cruise
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Cyclo"> Cyclo
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_transportation[]" value="Ox-cart">
                                        Ox-cart
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Preferred Activities</label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_activities[]" value="Adventure">
                                        Adventure
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_activities[]" value="Trekking"> Trekking
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_activities[]" value="Kayaking"> Kayaking
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_activities[]" value="Cruising"> Cruising
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_activities[]" value="History"> History
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_activities[]" value="Culture"> Culture
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Preferred Accommodation</label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_accommodation[]" value="Budget"> Budget
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_accommodation[]" value="Superior">
                                        Superior
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_accommodation[]" value="Duluxe"> Duluxe
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="preferred_accommodation[]" value="Luxury"> Luxury
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label" for="contact_sms">Others request</label>
                                <textarea class="form-control" name="contact_sms" rows="5" id="contact_sms"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="margin-bottom-30">
                        <h3><span class="span-day span-day-tailor"><strong>3</strong></span><span
                                    class="title-tailor-made">Room Quality</span</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="double_room">Number of Double room</label>
                                <input type="number" class="form-control" name="double_room" id="double_room">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="twin_room">Number of Twin room</label>
                                <input type="number" class="form-control" name="twin_room" id="twin_room">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="single_room">Number of Single room</label>
                                <input type="number" class="form-control" name="single_room" id="single_room">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="trip_room">Number of Triple room</label>
                                <input type="number" class="form-control" name="trip_room" id="trip_room">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="family_room">Number of Family room</label>
                                <input type="number" class="form-control" name="family_room" id="family_room">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="extra_bed">Number of Extra bed</label>
                                <input type="number" class="form-control" name="extra_bed" id="extra_bed">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Include meals</label>
                                <div class="checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="include_meals[]" value="Breakfast"> Breakfast
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="include_meals[]" value="Breakfast+Lunch/Dinner">
                                        Breakfast + Lunch/Dinner
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="include_meals[]" value="Breakfast+Lunch+Dinner">
                                        Breakfast + Lunch + Dinner
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="margin-bottom-30">
                        <h3><span class="span-day span-day-tailor"><strong>4</strong></span><span
                                    class="title-tailor-made">Contact Information</span</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label for="contact_full_name">Title</label>
                                <select class="form-control" name="title" title="Title">
                                    <option value="mr">Mr.</option>
                                    <option value="ms">Ms.</option>
                                    <option value="dr">Dr</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5 col-lg-5">
                            <div class="form-group">
                                <label for="customize_tours_name">Full name</label>
                                <input type="text" class="form-control" name="customize_tours_name"
                                       id="customize_tours_name"
                                       required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5 col-lg-5">
                            <div class="form-group">
                                <label for="customize_email">Email</label>
                                <input type="email" class="form-control" name="customize_email"
                                       id="customize_email" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="customize_phone">Phone</label>
                                <input type="tel" class="form-control" name="customize_phone" id="customize_phone">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="customize_nationality">Nationality</label>
                                <select class="form-control" name="customize_nationality" id="customize_nationality"
                                        required>
                                    <?php LIP::the_nationality_list() ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
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
                        <button class="btn btn-green btn-block text-bold text-uppercase clickGoDiv"
                                name="tours-submitted" type="submit">Send
                        </button>
                    </div>
                </div>
                <!--<div class="col-sm-4 col-md-4">
                    <?php /*get_sidebar() */
                ?>
                </div>-->
            </div>
        </form>
        <?php
    }

    private function save_tour($data)
    {
        global $wpdb;
        $sql = /** @lang text */
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}customize_tours` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(10) NOT NULL,
            `customize_tours_name` VARCHAR(200) NOT NULL,
            `customize_email` VARCHAR(200) NOT NULL,
            `customize_phone` VARCHAR(50) DEFAULT NULL,
            `customize_nationality` VARCHAR(200) NOT NULL,
            `contact_adult` VARCHAR(50) NOT NULL,
            `contact_children` VARCHAR(50) NOT NULL,
            `contact_kids` VARCHAR(50) NOT NULL,
            `contact_estimated` VARCHAR(200) DEFAULT NULL,
            `contact_arrival` VARCHAR(50) NOT NULL,
            `contact_departure` VARCHAR(50) NOT NULL,
            `preferred_destination` VARCHAR(200) DEFAULT NULL,
            `preferred_transportation` VARCHAR(200) DEFAULT NULL,
            `preferred_activities` VARCHAR(200) DEFAULT NULL,
            `preferred_accommodation` VARCHAR(200) DEFAULT NULL,
            `double_room` VARCHAR(50) DEFAULT NULL,
            `twin_room` VARCHAR(50) DEFAULT NULL,
            `single_room` VARCHAR(50) DEFAULT NULL,
            `trip_room` VARCHAR(50) DEFAULT NULL,
            `family_room` VARCHAR(50) DEFAULT NULL,
            `extra_bed` VARCHAR(50) DEFAULT NULL,
            `include_meals` VARCHAR(200) DEFAULT NULL,
            `content` TEXT(200) NOT NULL,
            `customize_date` DATETIME DEFAULT NULL,
            `is_active` VARCHAR(10) NOT NULL,
             PRIMARY KEY (`id`)
            )";
        $wpdb->query($sql);

        $data_insert = [
            'title' => $data['title'],
            'is_active' => 0,
            'customize_tours_name' => $data['customize_tours_name'],
            'customize_email' => $data['customize_email'],
            'customize_phone' => $data['customize_phone'],
            'customize_nationality' => $data['customize_nationality'],
            'contact_adult' => $data['contact_adult'],
            'contact_children' => $data['contact_children'],
            'contact_kids' => $data['contact_kids'],
            'contact_estimated' => $data['contact_estimated'],
            'contact_arrival' => $data['contact_arrival'],
            'contact_departure' => $data['contact_departure'],
            'preferred_destination' => $data['preferred_destination'],
            'preferred_transportation' => $data['preferred_transportation'],
            'preferred_activities' => $data['preferred_activities'],
            'preferred_accommodation' => $data['preferred_accommodation'],
            'double_room' => $data['double_room'],
            'twin_room' => $data['twin_room'],
            'single_room' => $data['single_room'],
            'trip_room' => $data['trip_room'],
            'family_room' => $data['family_room'],
            'extra_bed' => $data['extra_bed'],
            'include_meals' => $data['include_meals'],
            'content' => $data['content'],
            'customize_date' => date("Y-m-d H:m:s"),
        ];

        $wpdb->insert(
            $wpdb->prefix . 'customize_tours',
            $data_insert,
            array(
                '%s',
                '%d'
            )
        );
    }

    function tour_mail()
    {
        $data = [];
        if (isset($_POST['tours-submitted'])) {
            $secretKey = GDS::get_option(['other_security', 'google_secret']);
            $captcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];
            //$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);

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
                $data['title'] = sanitize_text_field($_POST["title"]);
                $data['customize_tours_name'] = sanitize_text_field($_POST["customize_tours_name"]);
                $data['customize_email'] = sanitize_email($_POST["customize_email"]);
                $data['customize_phone'] = sanitize_text_field($_POST['customize_phone']);
                $data['customize_nationality'] = sanitize_text_field($_POST['customize_nationality']);
                $data['contact_adult'] = sanitize_text_field($_POST["contact_adult"]);
                $data['contact_children'] = sanitize_text_field($_POST['contact_children']);
                $data['contact_kids'] = sanitize_text_field($_POST['contact_kids']);
                $data['contact_estimated'] = sanitize_text_field($_POST["contact_estimated"]);
                $data['contact_arrival'] = sanitize_text_field($_POST['contact_arrival']);
                $data['contact_departure'] = sanitize_text_field($_POST['contact_departure']);
                $data['preferred_destination'] = sanitize_text_field(implode(", ", $_POST["preferred_destination"]));
                $data['preferred_transportation'] = sanitize_text_field(implode(", ", $_POST["preferred_transportation"]));
                $data['preferred_activities'] = sanitize_text_field(implode(", ", $_POST["preferred_activities"]));
                $data['preferred_accommodation'] = sanitize_text_field(implode(", ", $_POST["preferred_accommodation"]));
                $data['double_room'] = sanitize_text_field($_POST["double_room"]);
                $data['twin_room'] = sanitize_text_field($_POST['twin_room']);
                $data['single_room'] = sanitize_text_field($_POST['single_room']);
                $data['trip_room'] = sanitize_text_field($_POST["trip_room"]);
                $data['family_room'] = sanitize_text_field($_POST['family_room']);
                $data['extra_bed'] = sanitize_text_field($_POST['extra_bed']);
                $data['include_meals'] = sanitize_text_field(implode(", ", $_POST["include_meals"]));
                $data['content'] = sanitize_text_field($_POST["contact_sms"]);
                $subject = 'New tailor made from ' . site_url() . " <" . $data['customize_email'] . ">";
                $message = /** @lang HTML */
                    "<div>
                    <p>Full name: {$data['customize_tours_name']}</p>
                   <p>Email: {$data['customize_email']}</p>
                   <p>Nationality: {$data['customize_nationality']}</p>
                   <p>Phone: {$data['customize_phone']}</p>
                   <p>Adult: {$data['contact_adult']}</p>
                   <p>Children: {$data['contact_children']}</p>
                   <p>Kids: {$data['contact_kids']}</p>
                   <p>Estimated: {$data['contact_estimated']}</p>
                   <p>Arrival: {$data['contact_arrival']}</p>
                   <p>Departure: {$data['contact_departure']}</p>
                   <p>Destination: {$data['preferred_destination']}</p>
                   <p>Transportation: {$data['preferred_transportation']}</p>
                   <p>Activities: {$data['preferred_activities']}</p>
                   <p>Accommodation: {$data['preferred_accommodation']}</p>
                   <p>Double room: {$data['double_room']}</p>
                   <p>Twin room: {$data['twin_room']}</p>
                   <p>Single room: {$data['single_room']}</p>
                   <p>Trip room: {$data['trip_room']}</p>
                   <p>Family room: {$data['family_room']}</p>
                   <p>Extra bed: {$data['extra_bed']}</p>
                   <p>Include meals: {$data['include_meals']}</p>
                   <p>Message:</p>
                   <p>{$data['content']}</p>
                   </div>";

                //save database
                $this->save_tour($data);

                // get the blog administrator's email address
                $to = GDS::get_option(['booking_email', 'global']);
                $contact_cc = GDS::get_option(['booking_email', 'cc']);
                $contact_bcc = GDS::get_option(['booking_email', 'bcc']);

                $headers = "Cc: {$contact_cc}\r\n";
                $headers .= "Bcc: {$contact_bcc}\r\n";
                $headers .= "From: {$data['customize_email']}\r\n";
                $headers .= "Reply-To: {$data['customize_tours_name']} <{$data['customize_email']}>\r\n";


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

    function tailor_made_shortcode()
    {
        ob_start();
        $this->tour_mail();
        $this->html_tour_form();

        return ob_get_clean();
    }
}

new tailor_made();