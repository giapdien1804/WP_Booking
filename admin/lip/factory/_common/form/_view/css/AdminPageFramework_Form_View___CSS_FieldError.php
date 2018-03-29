<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Form_View___CSS_FieldError extends AdminPageFramework_Form_View___CSS_Base
{
    protected function _get()
    {
        return $this->_getFieldErrorRules();
    }

    private function _getFieldErrorRules()
    {
        return ".field-error, .section-error{color: red;float: left;clear: both;margin-bottom: 0.5em;}.repeatable-section-error,.repeatable-field-error {float: right;clear: both;color: red;margin-left: 1em;}";
    }
}
