<?php

class contact extends AdminPageFramework_Widget
{
    public function start()
    {

    }

    public function setUp()
    {

        $this->setArguments(
            array(
                'description' => 'Contact widget',
            )
        );

    }

    public function load($oAdminWidget)
    {

        $this->addSettingFields(
            [
                'field_id' => 'title',
                'type' => 'text',
                'title' => 'Title'
            ],
            [
                'field_id' => 'description',
                'type' => 'text',
                'title' => 'Description'
            ],
            [
                'field_id' => 'address',
                'type' => 'text',
                'title' => 'Address'
            ],
            [
                'field_id' => 'phone',
                'type' => 'text',
                'title' => 'Phone'
            ],
            [
                'field_id' => 'email',
                'type' => 'text',
                'title' => 'Email'
            ],
            [
                'field_id' => 'web',
                'type' => 'text',
                'title' => 'Website'
            ],
            [
                'field_id' => 'hotline',
                'type' => 'text',
                'title' => 'Hotline'
            ]
        );

    }

    public function validate($aSubmit, $aStored, $oAdminWidget)
    {

        // Uncomment the following line to check the submitted value.
        // AdminPageFramework_Debug::log( $aSubmit );

        return $aSubmit;

    }

    public function content($sContent, $aArguments, $aFormData)
    {
        if (GDS::get_option(['option_logo', 'footer_logo']) != null)
            $sContent = "<a href=\"" . esc_html(home_url('/')) . "\"><img
                        src=\"" . GDS::get_option(['option_logo', 'footer_logo']) . "\"
                        alt=\"" . get_bloginfo('title') . "\" title=\"" . get_bloginfo('title') . "\"></a>";
        $sContent .= "
        <address>
            <div class=\"address-footer\">
            <h5>" . $aFormData['description'] . "</h5>
            <i class=\"fa fa-map-marker\"></i> " . $aFormData['address'] . "<br>
            <i class=\"fa fa-phone\"></i> <a href=\"tel:" . $aFormData['phone'] . "\"> " . $aFormData['phone'] . "</a><br>
            <i class=\"fa fa-envelope\"></i><a href=\"mailto:" . $aFormData['email'] . "\"> " . $aFormData['email'] . "</a><br>
            <i class=\"fa fa-home\"></i><a href=\"" . $aFormData['web'] . "\"> " . preg_replace("(^https?://)", "", $aFormData['web']) . "</a><br>";
        if ($aFormData['hotline'] != null)
            $sContent .= "<b>Hotline:</b> <a href=\"tel:" . $aFormData['hotline'] . "\">" . $aFormData['hotline'] . "</a>";
        $sContent .= "</div>
        </address>";

        $sContent .= "<div class=\"social\">";
        if (GDS::get_option(['other_social', 'facebook']) != null)
            $sContent .= "Follow us
        <ul class=\"social-network social-circle\">";
        if (GDS::get_option(['other_social', 'facebook']) != null)
            $sContent .= " <li><a href=\"" . GDS::get_option(['other_social', 'facebook']) . "\" target=\"_blank\" class=\"icoFacebook\"
                       title=\"Facebook\"><i class=\"fa fa-facebook\"></i></a></li>";
        if (GDS::get_option(['other_social', 'twitter']) != null)
            $sContent .= "<li><a href=\"" . GDS::get_option(['other_social', 'twitter']) . "\" target=\"_blank\" class=\"icoTwitter\"
                       title=\"Twitter\"><i class=\"fa fa-twitter\"></i></a></li>";
        if (GDS::get_option(['other_social', 'google']) != null)
            $sContent .= "<li><a href=\"" . GDS::get_option(['other_social', 'google']) . "\" target=\"_blank\"
                       class=\"icoGoogle\" title=\"Google +\"><i class=\"fa fa-google-plus\"></i></a></li>";
        if (GDS::get_option(['other_social', 'pinterest']) != null)
            $sContent .= "<li><a href=\"" . GDS::get_option(['other_social', 'pinterest']) . "\" target=\"_blank\"
                       class=\"icoPinterest\" title=\"Pinterest\"><i class=\"fa fa-pinterest-p\"></i></a>
                </li>";
        $sContent .= "
        </ul>
    </div>

<div class=\"trip-advisor\">" .
            GDS::get_option(['other_social', 'tripadvisor']) . "
</div>";
        return $sContent;
    }
}

new contact('7gmt Contact');


