<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Form_View___CSS_Form extends AdminPageFramework_Form_View___CSS_Base
{
    protected function _get()
    {
        $_sSpinnerURL = esc_url(admin_url('/images/wpspin_light-2x.gif'));
        return ".admin-page-framework-form-warning {font-weight: bold;color: red;font-size: 1.32em;}";
    }
}
