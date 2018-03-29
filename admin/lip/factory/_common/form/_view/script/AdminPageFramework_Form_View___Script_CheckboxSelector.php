<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Form_View___Script_CheckboxSelector extends AdminPageFramework_Form_View___Script_Base
{
    static public function getScript()
    {
        return <<<JAVASCRIPTS
(function ( $ ) {

    /**
     * Checks all the checkboxes in siblings.
     */        
    $.fn.selectAllAdminPageFrameworkCheckboxes = function() {
        jQuery( this ).parent()
            .find( 'input[type=checkbox]' )
            .attr( 'checked', true );                
    }
    /**
     * Unchecks all the checkboxes in siblings.
     */
    $.fn.deselectAllAdminPageFrameworkCheckboxes = function() {
        jQuery( this ).parent()
            .find( 'input[type=checkbox]' )
            .attr( 'checked', false );                             
    }          

}( jQuery ));
JAVASCRIPTS;

    }
}
