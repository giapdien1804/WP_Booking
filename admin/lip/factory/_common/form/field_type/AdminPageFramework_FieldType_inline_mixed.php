<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_FieldType__nested extends AdminPageFramework_FieldType
{
    public $aFieldTypeSlugs = array('_nested');
    protected $aDefaultKeys = array();

    protected function getStyles()
    {
        return ".admin-page-framework-fieldset > .admin-page-framework-fields > .admin-page-framework-field.with-nested-fields > .admin-page-framework-fieldset.multiple-nesting {margin-left: 2em;}.admin-page-framework-fieldset > .admin-page-framework-fields > .admin-page-framework-field.with-nested-fields > .admin-page-framework-fieldset {margin-bottom: 1em;}.with-nested-fields > .admin-page-framework-fieldset.child-fieldset > .admin-page-framework-child-field-title {display: inline-block;padding: 0 0 0.4em 0;}.admin-page-framework-fieldset.child-fieldset > label.admin-page-framework-child-field-title {display: table-row; white-space: nowrap;}";
    }

    protected function getField($aField)
    {
        $_oCallerForm = $aField['_caller_object'];
        $_aInlineMixedOutput = array();
        foreach ($this->getAsArray($aField['content']) as $_aChildFieldset) {
            if (is_scalar($_aChildFieldset)) {
                continue;
            }
            if (!$this->isNormalPlacement($_aChildFieldset)) {
                continue;
            }
            $_aChildFieldset = $this->getFieldsetReformattedBySubFieldIndex($_aChildFieldset, ( integer )$aField['_index'], $aField['_is_multiple_fields'], $aField);
            $_oFieldset = new AdminPageFramework_Form_View___Fieldset($_aChildFieldset, $_oCallerForm->aSavedData, $_oCallerForm->getFieldErrors(), $_oCallerForm->aFieldTypeDefinitions, $_oCallerForm->oMsg, $_oCallerForm->aCallbacks);
            $_aInlineMixedOutput[] = $_oFieldset->get();
        }
        return implode('', $_aInlineMixedOutput);
    }
}

class AdminPageFramework_FieldType_inline_mixed extends AdminPageFramework_FieldType__nested
{
    public $aFieldTypeSlugs = array('inline_mixed');
    protected $aDefaultKeys = array('label_min_width' => '',);

    protected function getStyles()
    {
        return ".admin-page-framework-field-inline_mixed {width: 98%;}.admin-page-framework-field-inline_mixed > fieldset {display: inline-block;overflow-x: visible;padding-right: 0.4em;}.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields{display: inline;width: auto;table-layout: auto;margin: 0;padding: 0;vertical-align: middle;white-space: nowrap;}.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field {float: none;clear: none;width: 100%;display: inline-block;margin-right: auto;vertical-align: middle; }.with-mixed-fields > fieldset > label {width: auto;padding: 0;}.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field .admin-page-framework-input-label-string {padding: 0;}.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field > .admin-page-framework-input-label-container,.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field > * > .admin-page-framework-input-label-container{padding: 0;display: inline-block;}.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field > .admin-page-framework-input-label-container > label,.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field > * > .admin-page-framework-input-label-container > label{display: inline-block;}.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field > .admin-page-framework-input-label-container > label > input,.admin-page-framework-field-inline_mixed > fieldset > .admin-page-framework-fields > .admin-page-framework-field > * > .admin-page-framework-input-label-container > label > input{display: inline-block;min-width: 100%;margin-right: auto;margin-left: auto;}";
    }
}
