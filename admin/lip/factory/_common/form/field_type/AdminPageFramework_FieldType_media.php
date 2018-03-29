<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_FieldType_image extends AdminPageFramework_FieldType
{
    public $aFieldTypeSlugs = array('image',);
    protected $aDefaultKeys = array('attributes_to_store' => array(), 'show_preview' => true, 'allow_external_source' => true, 'attributes' => array('input' => array('size' => 40, 'maxlength' => 400,), 'button' => array(), 'remove_button' => array(), 'preview' => array(),),);

    protected function setUp()
    {
        $this->enqueueMediaUploader();
    }

    protected function getScripts()
    {
        return $this->_getScript_ImageSelector("admin_page_framework") . PHP_EOL . $this->_getScript_RegisterCallbacks();
    }

    protected function _getScript_RegisterCallbacks()
    {
        $_aJSArray = json_encode($this->aFieldTypeSlugs);
        return <<<JAVASCRIPTS
jQuery( document ).ready( function(){

    jQuery().registerAdminPageFrameworkCallbacks( {   
        /**
         * The repeatable field callback for the add event.
         * 
         * @param object    node
         * @param string    sFieldType      the field type slug
         * @param string    sFieldTagID     the field container tag ID
         * @param integer   iCallerType     the caller type. 1 : repeatable sections. 0 : repeatable fields.
         */
        added_repeatable_field: function( oCloned, sFieldType, sFieldTagID, iCallType, iSectionIndex, iFieldIndex ) {

            // If it is not the type, do nothing.
            if ( oCloned.find( '.select_image' ).length <= 0 ) { 
                return; 
            }
            
            // Remove the value of the cloned preview element - check the value for repeatable sections.
            var sValue = oCloned.find( 'input' ).first().val();
            if ( 1 !== iCallType || ! sValue ) { // if it's not for repeatable sections
                oCloned.find( '.image_preview' ).hide(); // for the image field type, hide the preview element
                oCloned.find( '.image_preview img' ).attr( 'src', '' ); // for the image field type, empty the src property for the image uploader field
            }
                                    
            // Update attributes.
            switch( iCallType ) {
                
                // Repeatable sections (calling a belonging field)
                case 1: 

                    var _oSectionsContainer     = jQuery( oCloned ).closest( '.admin-page-framework-sections' );
                    var _iSectionIndex          = _oSectionsContainer.attr( 'data-largest_index' );
                    var _sSectionIDModel        = _oSectionsContainer.attr( 'data-section_id_model' );
                    jQuery( oCloned ).find( '.image_preview, .image_preview img, .select_image' ).incrementAttribute(
                        'id', // attribute name
                        _iSectionIndex, // increment from
                        _sSectionIDModel // digit model
                    );
                    break;
                    
                // Repeatable fields
                default:
                case 0:
                // Parent repeatable fields (calling a nested field)
                case 2:
                
                    var _oFieldsContainer   = jQuery( oCloned ).closest( '.admin-page-framework-fields' );
                    var _iFieldIndex        = Number( _oFieldsContainer.attr( 'data-largest_index' ) - 1 );
                    var _sFieldTagIDModel   = _oFieldsContainer.attr( 'data-field_tag_id_model' );
                    jQuery( oCloned ).find( '.image_preview, .image_preview img, .select_image' ).incrementAttribute(
                        'id', // attribute name
                        _iFieldIndex, // increment from
                        _sFieldTagIDModel // digit model
                    );                    
                    break;                                

            }
            
            // Bind the event.
            var _oFieldContainer = oCloned.closest( '.admin-page-framework-field' );
            var _oSelectButton   = _oFieldContainer.find( '.select_image' );            
            var _oImageInput     = _oFieldContainer.find( '.image-field input' );
            if ( _oImageInput.length <= 0 ) {
                return true;
            }           

            setAdminPageFrameworkImageUploader( 
                _oImageInput.attr( 'id' ), 
                true, 
                _oSelectButton.attr( 'data-enable_external_source' )
            );               
            
        }
    },
    $_aJSArray
    );
});
JAVASCRIPTS;

    }

    private function _getScript_ImageSelector($sReferrer)
    {
        $_sThickBoxTitle = esc_js($this->oMsg->get('upload_image'));
        $_sThickBoxButtonUseThis = esc_js($this->oMsg->get('use_this_image'));
        $_sInsertFromURL = esc_js($this->oMsg->get('insert_from_url'));
        if (!function_exists('wp_enqueue_media')) {
            return <<<JAVASCRIPTS
/**
 * Bind/rebinds the thickbox script the given selector element.
 * The fMultiple parameter does not do anything. It is there to be consistent with the one for the WordPress version 3.5 or above.
 */
setAdminPageFrameworkImageUploader = function( sInputID, fMultiple, fExternalSource ) {
    jQuery( '#select_image_' + sInputID ).unbind( 'click' ); // for repeatable fields
    jQuery( '#select_image_' + sInputID ).click( function() {
        var sPressedID                  = jQuery( this ).attr( 'id' );     
        window.sInputID                 = sPressedID.substring( 13 ); // remove the select_image_ prefix and set a property to pass it to the editor callback method.
        window.original_send_to_editor  = window.send_to_editor;
        window.send_to_editor           = hfAdminPageFrameworkSendToEditorImage;
        var fExternalSource             = jQuery( this ).attr( 'data-enable_external_source' );
        tb_show( '{$_sThickBoxTitle}', 'media-upload.php?post_id=1&amp;enable_external_source=' + fExternalSource + '&amp;referrer={$sReferrer}&amp;button_label={$_sThickBoxButtonUseThis}&amp;type=image&amp;TB_iframe=true', false );
        return false; // do not click the button after the script by returning false.     
    });    
}     

var hfAdminPageFrameworkSendToEditorImage = function( sRawHTML ) {

    var sHTML       = '<div>' + sRawHTML + '</div>'; // This is for the 'From URL' tab. Without the wrapper element. the below attr() method don't catch attributes.
    var src         = jQuery( 'img', sHTML ).attr( 'src' );
    var alt         = jQuery( 'img', sHTML ).attr( 'alt' );
    var title       = jQuery( 'img', sHTML ).attr( 'title' );
    var width       = jQuery( 'img', sHTML ).attr( 'width' );
    var height      = jQuery( 'img', sHTML ).attr( 'height' );
    var classes     = jQuery( 'img', sHTML ).attr( 'class' );
    var id          = ( classes ) ? classes.replace( /(.*?)wp-image-/, '' ) : ''; // attachment ID    
    var sCaption    = sRawHTML.replace( /\[(\w+).*?\](.*?)\[\/(\w+)\]/m, '$2' )
        .replace( /<a.*?>(.*?)<\/a>/m, '' );
    var align       = sRawHTML.replace( /^.*?\[\w+.*?\salign=([\'\"])(.*?)[\'\"]\s.+$/mg, '$2' ); //\'\" syntax fixer
    var link        = jQuery( sHTML ).find( 'a:first' ).attr( 'href' );

    // Escape the strings of some of the attributes.
    var sCaption    = jQuery( '<div/>' ).text( sCaption ).html();
    var sAlt        = jQuery( '<div/>' ).text( alt ).html();
    var title       = jQuery( '<div/>' ).text( title ).html();     

    // If the user wants to save relevant attributes, set them.
    var sInputID    = window.sInputID; // window.sInputID should be assigned when the thickbox is opened.

    jQuery( '#' + sInputID ).val( src ); // sets the image url in the main text field. The url field is mandatory so it does not have the suffix.
    jQuery( '#' + sInputID + '_id' ).val( id );
    jQuery( '#' + sInputID + '_width' ).val( width );
    jQuery( '#' + sInputID + '_height' ).val( height );
    jQuery( '#' + sInputID + '_caption' ).val( sCaption );
    jQuery( '#' + sInputID + '_alt' ).val( sAlt );
    jQuery( '#' + sInputID + '_title' ).val( title );     
    jQuery( '#' + sInputID + '_align' ).val( align );     
    jQuery( '#' + sInputID + '_link' ).val( link );     
    
    // Update the preview
    jQuery( '#image_preview_' + sInputID ).attr( 'alt', alt );
    jQuery( '#image_preview_' + sInputID ).attr( 'title', title );
    jQuery( '#image_preview_' + sInputID ).attr( 'data-classes', classes );
    jQuery( '#image_preview_' + sInputID ).attr( 'data-id', id );
    jQuery( '#image_preview_' + sInputID ).attr( 'src', src ); // updates the preview image
    jQuery( '#image_preview_container_' + sInputID ).css( 'display', '' ); // updates the visibility
    jQuery( '#image_preview_' + sInputID ).show() // updates the visibility
    
    // restore the original send_to_editor
    window.send_to_editor = window.original_send_to_editor;

    // close the thickbox
    tb_remove();    

}
JAVASCRIPTS;

        }
        return <<<JAVASCRIPTS
// Global Function Literal 
/**
 * Binds/rebinds the uploader button script to the specified element with the given ID.
 */
setAdminPageFrameworkImageUploader = function( sInputID, fMultiple, fExternalSource ) {

    var _bEscaped = false; // indicates whether the frame is escaped/cancelled.
    var _oCustomImageUploader;

    // The input element.
    jQuery( '#' + sInputID + '[data-show_preview=\"1\"]' ).unbind( 'change' ); // for repeatable fields
    jQuery( '#' + sInputID + '[data-show_preview=\"1\"]' ).change( function( e ) {
        
        var _sImageURL = jQuery( this ).val();
        
        // Check if it is a valid image url.
        jQuery( '<img>', {
            src: _sImageURL,
            error: function() {},
            load: function() { 
                // if valid,  set the preview.
                setImagePreviewElement( 
                    sInputID, 
                    { 
                        url: _sImageURL 
                    } 
                );
            }
        });
        
        
    } );
    
    // The Select button element.
    jQuery( '#select_image_' + sInputID ).unbind( 'click' ); // for repeatable fields
    jQuery( '#select_image_' + sInputID ).click( function( e ) {
     
        // Reassign the input id from the pressed element ( do not use the passed parameter value to the caller function ) for repeatable sections.
        var sInputID = jQuery( this ).attr( 'id' ).substring( 13 ); // remove the select_image_ prefix and set a property to pass it to the editor callback method.
        
        window.wpActiveEditor = null;     
        e.preventDefault();
        
        // If the uploader object has already been created, reopen the dialog
        if ( 'object' === typeof _oCustomImageUploader ) {
            _oCustomImageUploader.open();
            return;
        }     

        // Store the original select object in a global variable
        oAdminPageFrameworkOriginalImageUploaderSelectObject = wp.media.view.MediaFrame.Select;
        
        // Assign a custom select object
        wp.media.view.MediaFrame.Select = fExternalSource ? getAdminPageFrameworkCustomMediaUploaderSelectObject() : oAdminPageFrameworkOriginalImageUploaderSelectObject;
        _oCustomImageUploader = wp.media({
            id:         sInputID,
            title:      fExternalSource ? '{$_sInsertFromURL}' : '{$_sThickBoxTitle}',
            button:     {
                text: '{$_sThickBoxButtonUseThis}'
            },       
            type:       'image', 
            library:    { type : 'image' },                             
            multiple:   fMultiple,  // Set this to true to allow multiple files to be selected
            metadata:   {},
        });
        
        
        // When the uploader window closes, 
        _oCustomImageUploader.on( 'escape', function() {
            _bEscaped = true;
            return false;
        });
        _oCustomImageUploader.on( 'close', function() {
 
            var state = _oCustomImageUploader.state();     
            // Check if it's an external URL
            if ( typeof( state.props ) != 'undefined' && typeof( state.props.attributes ) != 'undefined' ) {
                
                // 3.4.2+ Somehow the image object breaks when it is passed to a function or cloned or enclosed in an object so recreateing it manually.
                var _oImage = {}, _sKey;
                for ( _sKey in state.props.attributes ) {
                    _oImage[ _sKey ] = state.props.attributes[ _sKey ];
                }      
                
            }
            
            // If the _oImage variable is not defined at this point, it's an attachment, not an external URL.
            if ( typeof( _oImage ) !== 'undefined'  ) {
                setImagePreviewElementWithDelay( sInputID, _oImage );
          
            } else {
                
                var _oNewField;
                _oCustomImageUploader.state().get( 'selection' ).each( function( oAttachment, iIndex ) {

                    var _oAttributes = oAttachment.hasOwnProperty( 'attributes' )
                        ? oAttachment.attributes
                        : {};
                    
                    if ( 0 === iIndex ){    
                        // place first attachment in the field
                        setImagePreviewElementWithDelay( sInputID, _oAttributes );
                        return true;
                    } 

                    var _oFieldContainer    = 'undefined' === typeof _oNewField 
                        ? jQuery( '#' + sInputID ).closest( '.admin-page-framework-field' ) 
                        : _oNewField;
                    _oNewField              = jQuery( this ).addAdminPageFrameworkRepeatableField( _oFieldContainer.attr( 'id' ) );
                    var sInputIDOfNewField  = _oNewField.find( 'input' ).attr( 'id' );
                    setImagePreviewElementWithDelay( sInputIDOfNewField, _oAttributes );
                    
                });     
                
            }
            
            // Restore the original select object.
            wp.media.view.MediaFrame.Select = oAdminPageFrameworkOriginalImageUploaderSelectObject;
                            
        });
      
        // Open the uploader dialog
        _oCustomImageUploader.open();
        return false;
        
    });    

    var setImagePreviewElementWithDelay = function( sInputID, oImage, iMilliSeconds ) {
 
        iMilliSeconds = 'undefined' === typeof iMilliSeconds ? 100 : iMilliSeconds;
           
        setTimeout( function (){
            if ( ! _bEscaped ) {
                setImagePreviewElement( sInputID, oImage );
            }
            _bEscaped = false;
        }, iMilliSeconds );
        
    }
        
}    
/**
 * Removes the set values to the input tags.
 * 
 * @since   3.2.0
 */
removeInputValuesForImage = function( oElem ) {

    var _oImageInput = jQuery( oElem ).closest( '.admin-page-framework-field' ).find( '.image-field input' );                  
    if ( _oImageInput.length <= 0 )  {
        return;
    }
    
    // Find the input tag.
    var _sInputID = _oImageInput.first().attr( 'id' );
    
    // Remove the associated values.
    setImagePreviewElement( _sInputID, {} );
    
}

/**
 * Sets the preview element.
 * 
 * @since   3.2.0   Changed the scope to global.
 */
setImagePreviewElement = function( sInputID, oImage ) {

    var oImage      = jQuery.extend( 
        true,   // recursive
        { 
            caption:    '',  
            alt:        '',
            title:      '',
            url:        '',
            id:         '',
            width:      '',
            height:     '',
            align:      '',
            link:       '',
        },
        oImage
    );    

    // Escape the strings of some of the attributes.
    var _sCaption   = jQuery( '<div/>' ).text( oImage.caption ).html();
    var _sAlt       = jQuery( '<div/>' ).text( oImage.alt ).html();
    var _sTitle     = jQuery( '<div/>' ).text( oImage.title ).html();

    // If the user wants the attributes to be saved, set them in the input tags.
    jQuery( 'input#' + sInputID ).val( oImage.url ); // the url field is mandatory so it does not have the suffix.
    jQuery( 'input#' + sInputID + '_id' ).val( oImage.id );
    jQuery( 'input#' + sInputID + '_width' ).val( oImage.width );
    jQuery( 'input#' + sInputID + '_height' ).val( oImage.height );
    jQuery( 'input#' + sInputID + '_caption' ).val( _sCaption );
    jQuery( 'input#' + sInputID + '_alt' ).val( _sAlt );
    jQuery( 'input#' + sInputID + '_title' ).val( _sTitle );
    jQuery( 'input#' + sInputID + '_align' ).val( oImage.align );
    jQuery( 'input#' + sInputID + '_link' ).val( oImage.link );
    
    // Update up the preview
    jQuery( '#image_preview_' + sInputID ).attr( 'data-id', oImage.id );
    jQuery( '#image_preview_' + sInputID ).attr( 'data-width', oImage.width );
    jQuery( '#image_preview_' + sInputID ).attr( 'data-height', oImage.height );
    jQuery( '#image_preview_' + sInputID ).attr( 'data-caption', _sCaption );
    jQuery( '#image_preview_' + sInputID ).attr( 'alt', _sAlt );
    jQuery( '#image_preview_' + sInputID ).attr( 'title', _sTitle );
    jQuery( '#image_preview_' + sInputID ).attr( 'src', oImage.url );
    if ( oImage.url ) {
        jQuery( '#image_preview_container_' + sInputID ).show();     
    } else {
        jQuery( '#image_preview_container_' + sInputID ).hide();     
    }
    
}                
JAVASCRIPTS;

    }

    protected function getStyles()
    {
        return ".admin-page-framework-field .image_preview {border: none; clear: both; margin-top: 0.4em;margin-bottom: 0.8em;display: block; max-width: 100%;height: auto; width: inherit;} .admin-page-framework-field .image_preview img { display: block;height: auto; max-width: 100%;}.widget .admin-page-framework-field .image_preview {max-width: 100%;}@media only screen and ( max-width: 1200px ) {.admin-page-framework-field .image_preview {max-width: 600px;} } @media only screen and ( max-width: 900px ) {.admin-page-framework-field .image_preview {max-width: 440px;}}@media only screen and ( max-width: 600px ) {.admin-page-framework-field .image_preview {max-width: 300px;}} @media only screen and ( max-width: 480px ) {.admin-page-framework-field .image_preview {max-width: 240px;}}@media only screen and ( min-width: 1200px ) {.admin-page-framework-field .image_preview {max-width: 600px;}}.admin-page-framework-field-image input {margin-right: 0.5em;vertical-align: middle;}.select_image.button.button-small,.remove_image.button.button-small{ vertical-align: middle;}.remove_image.button.button-small {margin-left: 0.2em;}@media screen and (max-width: 782px) {.admin-page-framework-field-image input {margin: 0.5em 0.5em 0.5em 0;}} ";
    }

    protected function getField($aField)
    {
        $_iCountAttributes = count($this->getElementAsArray($aField, 'attributes_to_store'));
        $_sImageURL = $this->_getTheSetImageURL($aField, $_iCountAttributes);
        $_aBaseAttributes = $this->_getBaseAttributes($aField);
        return $aField['before_label'] . "<div class='admin-page-framework-input-label-container admin-page-framework-input-container {$aField['type']}-field'>" . "<label for='{$aField['input_id']}'>" . $aField['before_input'] . $this->getAOrB($aField['label'] && !$aField['repeatable'], "<span class='admin-page-framework-input-label-string' style='min-width:" . $this->sanitizeLength($aField['label_min_width']) . ";'>" . $aField['label'] . "</span>", '') . "<input " . $this->getAttributes($this->_getImageInputAttributes($aField, $_iCountAttributes, $_sImageURL, $_aBaseAttributes)) . " />" . $aField['after_input'] . "<div class='repeatable-field-buttons'></div>" . $this->getExtraInputFields($aField) . "</label>" . "</div>" . $aField['after_label'] . $this->_getPreviewContainer($aField, $_sImageURL, $this->getElementAsArray($aField, array('attributes', 'preview')) + $_aBaseAttributes) . $this->_getRemoveButtonScript($aField['input_id'], $this->getElementAsArray($aField, array('attributes', 'remove_button')) + $_aBaseAttributes, $aField['type']) . $this->_getUploaderButtonScript($aField['input_id'], $aField['repeatable'], $aField['allow_external_source'], $this->getElementAsArray($aField, array('attributes', 'button')) + $_aBaseAttributes);
    }

    private function _getBaseAttributes(array $aField)
    {
        $_aBaseAttributes = $aField['attributes'] + array('class' => null);
        unset($_aBaseAttributes['input'], $_aBaseAttributes['button'], $_aBaseAttributes['preview'], $_aBaseAttributes['name'], $_aBaseAttributes['value'], $_aBaseAttributes['type'], $_aBaseAttributes['remove_button']);
        return $_aBaseAttributes;
    }

    private function _getTheSetImageURL(array $aField, $iCountAttributes)
    {
        $_sCaptureAttribute = $this->getAOrB($iCountAttributes, 'url', '');
        return $_sCaptureAttribute ? $this->getElement($aField, array('attributes', 'value', $_sCaptureAttribute), '') : $aField['attributes']['value'];
    }

    private function _getImageInputAttributes(array $aField, $iCountAttributes, $sImageURL, array $aBaseAttributes)
    {
        return array('name' => $aField['attributes']['name'] . $this->getAOrB($iCountAttributes, '[url]', ''), 'value' => $sImageURL, 'type' => 'text', 'data-show_preview' => $aField['show_preview'],) + $aField['attributes']['input'] + $aBaseAttributes;
    }

    protected function getExtraInputFields(array $aField)
    {
        $_aOutputs = array();
        foreach ($this->getElementAsArray($aField, 'attributes_to_store') as $sAttribute) {
            $_aOutputs[] = "<input " . $this->getAttributes(array('id' => "{$aField['input_id']}_{$sAttribute}", 'type' => 'hidden', 'name' => "{$aField['_input_name']}[{$sAttribute}]", 'disabled' => $this->getAOrB(isset($aField['attributes']['disabled']) && $aField['attributes']['disabled'], 'disabled', null), 'value' => $this->getElement($aField, array('attributes', 'value', $sAttribute), ''),)) . "/>";
        }
        return implode(PHP_EOL, $_aOutputs);
    }

    protected function _getPreviewContainer($aField, $sImageURL, $aPreviewAtrributes)
    {
        if (!$aField['show_preview']) {
            return '';
        }
        $sImageURL = esc_url($this->getResolvedSRC($sImageURL, true));
        return "<div " . $this->getAttributes(array('id' => "image_preview_container_{$aField['input_id']}", 'class' => 'image_preview ' . $this->getElement($aPreviewAtrributes, 'class', ''), 'style' => $this->getAOrB($sImageURL, '', "display: none; ") . $this->getElement($aPreviewAtrributes, 'style', ''),) + $aPreviewAtrributes) . ">" . "<img src='{$sImageURL}' " . "id='image_preview_{$aField['input_id']}' " . "/>" . "</div>";
    }

    protected function _getUploaderButtonScript($sInputID, $abRepeatable, $bExternalSource, array $aButtonAttributes)
    {
        $_bRepeatable = !empty($abRepeatable);
        $_sButtonHTML = '"' . $this->_getUploaderButtonHTML($sInputID, $aButtonAttributes, $_bRepeatable, $bExternalSource) . '"';
        $_sRepeatable = $this->getAOrB($_bRepeatable, 'true', 'false');
        $_bExternalSource = $this->getAOrB($bExternalSource, 'true', 'false');
        $_sScript = <<<JAVASCRIPTS
if ( 0 === jQuery( 'a#select_image_{$sInputID}' ).length ) {
    jQuery( 'input#{$sInputID}' ).after( $_sButtonHTML );
}
jQuery( document ).ready( function(){     
    setAdminPageFrameworkImageUploader( '{$sInputID}', 'true' === '{$_sRepeatable}', 'true' === '{$_bExternalSource}' );
});
JAVASCRIPTS;
        return "<script type='text/javascript' class='admin-page-framework-image-uploader-button'>" . '/* <![CDATA[ */' . $_sScript . '/* ]]> */' . "</script>" . PHP_EOL;
    }

    private function _getUploaderButtonHTML($sInputID, array $aButtonAttributes, $bRepeatable, $bExternalSource)
    {
        $_bIsLabelSet = isset($aButtonAttributes['data-label']) && $aButtonAttributes['data-label'];
        $_aAttributes = $this->_getFormattedUploadButtonAttributes($sInputID, $aButtonAttributes, $_bIsLabelSet, $bRepeatable, $bExternalSource);
        return "<a " . $this->getAttributes($_aAttributes) . ">" . ($_bIsLabelSet ? $_aAttributes['data-label'] : (strrpos($_aAttributes['class'], 'dashicons') ? '' : $this->oMsg->get('select_image'))) . "</a>";
    }

    private function _getFormattedUploadButtonAttributes($sInputID, array $aButtonAttributes, $_bIsLabelSet, $bRepeatable, $bExternalSource)
    {
        $_aAttributes = array('id' => "select_image_{$sInputID}", 'href' => '#', 'data-uploader_type' => ( string )function_exists('wp_enqueue_media'), 'data-enable_external_source' => ( string )( bool )$bExternalSource,) + $aButtonAttributes + array('title' => $_bIsLabelSet ? $aButtonAttributes['data-label'] : $this->oMsg->get('select_image'), 'data-label' => null,);
        $_aAttributes['class'] = $this->getClassAttribute('select_image button button-small ', $this->getAOrB(trim($aButtonAttributes['class']), $aButtonAttributes['class'], $this->getAOrB($_bIsLabelSet, '', $this->getAOrB($bRepeatable, $this->_getDashIconSelectorsBySlug('images-alt2'), $this->_getDashIconSelectorsBySlug('format-image')))));
        return $_aAttributes;
    }

    protected function _getRemoveButtonScript($sInputID, array $aButtonAttributes, $sType = 'image')
    {
        if (!function_exists('wp_enqueue_media')) {
            return '';
        }
        $_sButtonHTML = '"' . $this->_getRemoveButtonHTMLByType($sInputID, $aButtonAttributes, $sType) . '"';
        $_sScript = <<<JAVASCRIPTS
                if ( 0 === jQuery( 'a#remove_{$sType}_{$sInputID}' ).length ) {
                    jQuery( 'input#{$sInputID}' ).after( $_sButtonHTML );
                }
JAVASCRIPTS;
        return "<script type='text/javascript' class='admin-page-framework-{$sType}-remove-button'>" . '/* <![CDATA[ */' . $_sScript . '/* ]]> */' . "</script>" . PHP_EOL;
    }

    protected function _getRemoveButtonHTMLByType($sInputID, array $aButtonAttributes, $sType = 'image')
    {
        $_bIsLabelSet = isset($aButtonAttributes['data-label']) && $aButtonAttributes['data-label'];
        $_aAttributes = $this->_getFormattedRemoveButtonAttributesByType($sInputID, $aButtonAttributes, $_bIsLabelSet, $sType);
        return "<a " . $this->getAttributes($_aAttributes) . ">" . ($_bIsLabelSet ? $_aAttributes['data-label'] : $this->getAOrB(strrpos($_aAttributes['class'], 'dashicons'), '', 'x')) . "</a>";
    }

    protected function _getFormattedRemoveButtonAttributesByType($sInputID, array $aButtonAttributes, $_bIsLabelSet, $sType = 'image')
    {
        $_sOnClickFunctionName = 'removeInputValuesFor' . ucfirst($sType);
        $_aAttributes = array('id' => "remove_{$sType}_{$sInputID}", 'href' => '#', 'onclick' => esc_js("{$_sOnClickFunctionName}( this ); return false;"),) + $aButtonAttributes + array('title' => $_bIsLabelSet ? $aButtonAttributes['data-label'] : $this->oMsg->get('remove_value'),);
        $_aAttributes['class'] = $this->getClassAttribute("remove_value remove_{$sType} button button-small", $this->getAOrB(trim($aButtonAttributes['class']), $aButtonAttributes['class'], $this->getAOrB($_bIsLabelSet, '', $this->_getDashIconSelectorsBySlug('dismiss'))));
        return $_aAttributes;
    }

    private function _getDashIconSelectorsBySlug($sDashIconSlug)
    {
        static $_bDashIconSupported;
        $_bDashIconSupported = isset($_bDashIconSupported) ? $_bDashIconSupported : version_compare($GLOBALS['wp_version'], '3.8', '>=');
        return $this->getAOrB($_bDashIconSupported, "dashicons dashicons-{$sDashIconSlug}", '');
    }
}

class AdminPageFramework_FieldType_media extends AdminPageFramework_FieldType_image
{
    public $aFieldTypeSlugs = array('media',);
    protected $aDefaultKeys = array('attributes_to_store' => array(), 'show_preview' => true, 'allow_external_source' => true, 'attributes' => array('input' => array('size' => 40, 'maxlength' => 400,), 'button' => array(), 'remove_button' => array(), 'preview' => array(),),);

    protected function getScripts()
    {
        return $this->_getScript_MediaUploader("admin_page_framework") . PHP_EOL . $this->_getScript_RegisterCallbacks();
    }

    protected function _getScript_RegisterCallbacks()
    {
        $_aJSArray = json_encode($this->aFieldTypeSlugs);
        return <<<JAVASCRIPTS
jQuery( document ).ready( function(){
            
    jQuery().registerAdminPageFrameworkCallbacks( {    
        /**
         * The repeatable field callback for the add event.
         * 
         * @param object    node
         * @param string    the field type slug
         * @param string    the field container tag ID
         * @param integer   the caller type. 1 : repeatable sections. 0 : repeatable fields.
         */     
        added_repeatable_field: function( oCloned, sFieldType, sFieldTagID, iCallType ) {
            
            // Return if it is not the type.
            if ( oCloned.find( '.select_media' ).length <= 0 ) {
                return;
            }
            
            // Update attributes.
            
            // Repeatable Sections
            if ( 1 === iCallType ) {
                var _oSectionsContainer     = jQuery( oCloned ).closest( '.admin-page-framework-sections' );
                var _iSectionIndex          = _oSectionsContainer.attr( 'data-largest_index' );
                var _sSectionIDModel        = _oSectionsContainer.attr( 'data-section_id_model' );
                jQuery( oCloned ).find( '.select_media' ).incrementAttribute(
                    'id', // attribute name
                    _iSectionIndex, // increment from
                    _sSectionIDModel // digit model
                );                                  
            } 
            // Repeatable fields
            else {
                var _oFieldContainer    = oCloned.closest( '.admin-page-framework-field' );
                var _oFieldsContainer   = jQuery( oCloned ).closest( '.admin-page-framework-fields' );
                var _iFieldIndex        = Number( _oFieldsContainer.attr( 'data-largest_index' ) - 1 );
                var _sFieldTagIDModel   = _oFieldsContainer.attr( 'data-field_tag_id_model' );                
                jQuery( oCloned ).find( '.select_media' ).incrementAttribute(
                    'id', // attribute name
                    _iFieldIndex, // increment from
                    _sFieldTagIDModel // digit model
                );                
            }
            
            // Bind the event.
            var _oMediaInput = jQuery( oCloned ).find( '.media-field input' );
            if ( _oMediaInput.length <= 0 ) {
                return true;
            }
            setAdminPageFrameworkMediaUploader( 
                _oMediaInput.attr( 'id' ), 
                true, 
                jQuery( oCloned ).find( '.select_media' ).attr( 'data-enable_external_source' ) 
            );
       
        }

    },
    {$_aJSArray}
    );
});
JAVASCRIPTS;

    }

    private function _getScript_MediaUploader($sReferrer)
    {
        $_sThickBoxTitle = esc_js($this->oMsg->get('upload_file'));
        $_sThickBoxButtonUseThis = esc_js($this->oMsg->get('use_this_file'));
        $_sInsertFromURL = esc_js($this->oMsg->get('insert_from_url'));
        if (!function_exists('wp_enqueue_media')) {
            return <<<JAVASCRIPTS
                    /**
                     * Bind/rebinds the thickbox script the given selector element.
                     * The fMultiple parameter does not do anything. It is there to be consistent with the one for the WordPress version 3.5 or above.
                     */
                    setAdminPageFrameworkMediaUploader = function( sInputID, fMultiple, fExternalSource ) {
                        jQuery( '#select_media_' + sInputID ).unbind( 'click' ); // for repeatable fields
                        jQuery( '#select_media_' + sInputID ).click( function() {
                            var sPressedID = jQuery( this ).attr( 'id' );
                            window.sInputID = sPressedID.substring( 13 ); // remove the select_media_ prefix and set a property to pass it to the editor callback method.
                            window.original_send_to_editor = window.send_to_editor;
                            window.send_to_editor = hfAdminPageFrameworkSendToEditorMedia;
                            var fExternalSource = jQuery( this ).attr( 'data-enable_external_source' );
                            tb_show( '{$_sThickBoxTitle}', 'media-upload.php?post_id=1&amp;enable_external_source=' + fExternalSource + '&amp;referrer={$sReferrer}&amp;button_label={$_sThickBoxButtonUseThis}&amp;type=image&amp;TB_iframe=true', false );
                            return false; // do not click the button after the script by returning false.     
                        });    
                    }     
                                                    
                    var hfAdminPageFrameworkSendToEditorMedia = function( sRawHTML, param ) {

                        var sHTML = '<div>' + sRawHTML + '</div>'; // This is for the 'From URL' tab. Without the wrapper element. the below attr() method don't catch attributes.
                        var src = jQuery( 'a', sHTML ).attr( 'href' );
                        var classes = jQuery( 'a', sHTML ).attr( 'class' );
                        var id = ( classes ) ? classes.replace( /(.*?)wp-image-/, '' ) : ''; // attachment ID    
                    
                        // If the user wants to save relavant attributes, set them.
                        var sInputID = window.sInputID;
                        jQuery( '#' + sInputID ).val( src ); // sets the image url in the main text field. The url field is mandatory so it does not have the suffix.
                        jQuery( '#' + sInputID + '_id' ).val( id );     
                            
                        // restore the original send_to_editor
                        window.send_to_editor = window.original_send_to_editor;
                        
                        // close the thickbox
                        tb_remove();    

                    }
JAVASCRIPTS;

        }
        return <<<JAVASCRIPTS
                // Global Function Literal 
                /**
                 * Binds/rebinds the uploader button script to the specified element with the given ID.
                 */     
                setAdminPageFrameworkMediaUploader = function( sInputID, fMultiple, fExternalSource ) {

                    var _bEscaped = false;
                    var _oMediaUploader;
                    
                    jQuery( '#select_media_' + sInputID ).unbind( 'click' ); // for repeatable fields
                    jQuery( '#select_media_' + sInputID ).click( function( e ) {
                
                        // Reassign the input id from the pressed element ( do not use the passed parameter value to the caller function ) for repeatable sections.
                        var sInputID = jQuery( this ).attr( 'id' ).substring( 13 ); // remove the select_image_ prefix and set a property to pass it to the editor callback method.

                        window.wpActiveEditor = null;     
                        e.preventDefault();
                        
                        // If the uploader object has already been created, reopen the dialog
                        if ( 'object' === typeof _oMediaUploader ) {
                            _oMediaUploader.open();
                            return;
                        }     
                        
                        // Store the original select object in a global variable
                        oAdminPageFrameworkOriginalMediaUploaderSelectObject = wp.media.view.MediaFrame.Select;
                        
                        // Assign a custom select object.
                        wp.media.view.MediaFrame.Select = fExternalSource ? getAdminPageFrameworkCustomMediaUploaderSelectObject() : oAdminPageFrameworkOriginalMediaUploaderSelectObject;
                        _oMediaUploader = wp.media({
                            title:      fExternalSource
                                ? '{$_sInsertFromURL}'
                                : '{$_sThickBoxTitle}',
                            button:     {
                                text: '{$_sThickBoxButtonUseThis}'
                            },
                            multiple:   fMultiple, // Set this to true to allow multiple files to be selected
                            metadata:   {},
                        });
            
                        // When the uploader window closes, 
                        _oMediaUploader.on( 'escape', function() {
                            _bEscaped = true;
                            return false;
                        });    
                        _oMediaUploader.on( 'close', function() {

                            var state = _oMediaUploader.state();
                            
                            // Check if it's an external URL
                            if ( typeof( state.props ) != 'undefined' && typeof( state.props.attributes ) != 'undefined' ) {

                                // 3.4.2+ Somehow the image object breaks when it is passed to a function or cloned or enclosed in an object so recreateing it manually.
                                var _oMedia = {}, _sKey;
                                for ( _sKey in state.props.attributes ) {
                                    _oMedia[ _sKey ] = state.props.attributes[ _sKey ];
                                }      
                                
                            }
                            
                            // If the image variable is not defined at this point, it's an attachment, not an external URL.
                            if ( typeof( _oMedia ) !== 'undefined'  ) {
                                setMediaPreviewElementWithDelay( sInputID, _oMedia );
                            } else {
                                
                                var _oNewField;
                                _oMediaUploader.state().get( 'selection' ).each( function( oAttachment, iIndex ) {

                                    var _oAttributes = oAttachment.hasOwnProperty( 'attributes' )
                                        ? oAttachment.attributes
                                        : {};                                    
                                    
                                    if( 0 === iIndex ){    
                                        // place first attachment in field
                                        setMediaPreviewElementWithDelay( sInputID, _oAttributes );
                                        return true;
                                    } 
                                        
                                    var _oFieldContainer    = 'undefined' === typeof _oNewField 
                                        ? jQuery( '#' + sInputID ).closest( '.admin-page-framework-field' ) 
                                        : _oNewField;
                                    _oNewField              = jQuery( this ).addAdminPageFrameworkRepeatableField( _oFieldContainer.attr( 'id' ) );
                                    var sInputIDOfNewField  = _oNewField.find( 'input' ).attr( 'id' );
                                    setMediaPreviewElementWithDelay( sInputIDOfNewField, _oAttributes );
                                
                                });     
                                
                            }
                            
                            // Restore the original select object.
                            wp.media.view.MediaFrame.Select = oAdminPageFrameworkOriginalMediaUploaderSelectObject;    
                            
                        });
                        
                        // Open the uploader dialog
                        _oMediaUploader.open();     
                        return false;       
                    });    
                
                
                    var setMediaPreviewElementWithDelay = function( sInputID, oImage, iMilliSeconds ) {
                        
                        iMilliSeconds = 'undefiend' === typeof iMilliSeconds ? 100 : iMilliSeconds;
                        setTimeout( function (){
                            if ( ! _bEscaped ) {
                                setMediaPreviewElement( sInputID, oImage );
                            }
                            _bEscaped = false;
                        }, iMilliSeconds );
                        
                    }
                    
                }   

                /**
                 * Removes the set values to the input tags.
                 * 
                 * @since   3.2.0
                 */
                removeInputValuesForMedia = function( oElem ) {

                    var _oImageInput = jQuery( oElem ).closest( '.admin-page-framework-field' ).find( '.media-field input' );                  
                    if ( _oImageInput.length <= 0 )  {
                        return;
                    }
                    
                    // Find the input tag.
                    var _sInputID = _oImageInput.first().attr( 'id' );
                    
                    // Remove the associated values.
                    setMediaPreviewElement( _sInputID, {} );
                    
                }
                
                /**
                 * Sets the preview element.
                 * 
                 * @since   3.2.0   Changed the scope to global.
                 */                
                setMediaPreviewElement = function( sInputID, oSelectedFile ) {
                                
                    // If the user want the attributes to be saved, set them in the input tags.
                    jQuery( '#' + sInputID ).val( oSelectedFile.url ); // the url field is mandatory so  it does not have the suffix.
                    jQuery( '#' + sInputID + '_id' ).val( oSelectedFile.id );     
                    jQuery( '#' + sInputID + '_caption' ).val( jQuery( '<div/>' ).text( oSelectedFile.caption ).html() );     
                    jQuery( '#' + sInputID + '_description' ).val( jQuery( '<div/>' ).text( oSelectedFile.description ).html() );     
                    
                }                 
JAVASCRIPTS;

    }

    protected function getStyles()
    {
        return ".admin-page-framework-field-media input {margin-right: 0.5em;vertical-align: middle;}@media screen and (max-width: 782px) {.admin-page-framework-field-media input {margin: 0.5em 0.5em 0.5em 0;}} .select_media.button.button-small,.remove_media.button.button-small{ vertical-align: middle;}.remove_media.button.button-small {margin-left: 0.2em;}";
    }

    protected function _getPreviewContainer($aField, $sImageURL, $aPreviewAtrributes)
    {
        return "";
    }

    protected function _getUploaderButtonScript($sInputID, $abRepeatable, $bExternalSource, array $aButtonAttributes)
    {
        $_sButtonHTML = '"' . $this->_getUploaderButtonHTML_Media($sInputID, $aButtonAttributes, $bExternalSource) . '"';
        $_sRpeatable = $this->getAOrB(!empty($abRepeatable), 'true', 'false');
        $_sExternalSource = $this->getAOrB($bExternalSource, 'true', 'false');
        $_sScript = <<<JAVASCRIPTS
if ( jQuery( 'a#select_media_{$sInputID}' ).length == 0 ) {
    jQuery( 'input#{$sInputID}' ).after( $_sButtonHTML );
}
jQuery( document ).ready( function(){   
    setAdminPageFrameworkMediaUploader( '{$sInputID}', 'true' === '{$_sRpeatable}', 'true' === '{$_sExternalSource}' );
});
JAVASCRIPTS;
        return "<script type='text/javascript' class='admin-page-framework-media-uploader-button'>" . '/* <![CDATA[ */' . $_sScript . '/* ]]> */' . "</script>" . PHP_EOL;
    }

    private function _getUploaderButtonHTML_Media($sInputID, array $aButtonAttributes, $bExternalSource)
    {
        $_bIsLabelSet = isset($aButtonAttributes['data-label']) && $aButtonAttributes['data-label'];
        $_aAttributes = $this->_getFormattedUploadButtonAttributes_Media($sInputID, $aButtonAttributes, $_bIsLabelSet, $bExternalSource);
        return "<a " . $this->getAttributes($_aAttributes) . ">" . $this->getAOrB($_bIsLabelSet, $_aAttributes['data-label'], $this->getAOrB(strrpos($_aAttributes['class'], 'dashicons'), '', $this->oMsg->get('select_file'))) . "</a>";
    }

    private function _getFormattedUploadButtonAttributes_Media($sInputID, array $aButtonAttributes, $_bIsLabelSet, $bExternalSource)
    {
        $_aAttributes = array('id' => "select_media_{$sInputID}", 'href' => '#', 'data-uploader_type' => ( string )function_exists('wp_enqueue_media'), 'data-enable_external_source' => ( string )( bool )$bExternalSource,) + $aButtonAttributes + array('title' => $_bIsLabelSet ? $aButtonAttributes['data-label'] : $this->oMsg->get('select_file'), 'data-label' => null,);
        $_aAttributes['class'] = $this->getClassAttribute('select_media button button-small ', $this->getAOrB(trim($aButtonAttributes['class']), $aButtonAttributes['class'], $this->getAOrB(!$_bIsLabelSet && version_compare($GLOBALS['wp_version'], '3.8', '>='), 'dashicons dashicons-portfolio', '')));
        return $_aAttributes;
    }
}
