<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Property_post_meta_box extends AdminPageFramework_Property_Base
{
    public $_sPropertyType = 'post_meta_box';
    public $sMetaBoxID = '';
    public $aPostTypes = array();
    public $aPages = array();
    public $sContext = 'normal';
    public $sPriority = 'default';
    public $sClassName = '';
    public $sCapability = 'edit_posts';
    public $sThickBoxTitle = '';
    public $sThickBoxButtonUseThis = '';
    public $sStructureType = 'post_meta_box';
    public $_sFormRegistrationHook = 'admin_enqueue_scripts';

    public function __construct($oCaller, $sClassName, $sCapability = 'edit_posts', $sTextDomain = 'admin-page-framework', $sStructureType = 'post_meta_box')
    {
        parent::__construct($oCaller, null, $sClassName, $sCapability, $sTextDomain, $sStructureType);
    }

    protected function _getOptions()
    {
        return array();
    }
}
