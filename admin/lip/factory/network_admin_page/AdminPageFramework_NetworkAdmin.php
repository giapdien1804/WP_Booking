<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
abstract class AdminPageFramework_NetworkAdmin extends AdminPageFramework
{
    protected $_sStructureType = 'network_admin_page';
    protected $_aBuiltInRootMenuSlugs = array('dashboard' => 'index.php', 'sites' => 'sites.php', 'themes' => 'themes.php', 'plugins' => 'plugins.php', 'users' => 'users.php', 'settings' => 'settings.php', 'updates' => 'update-core.php',);

    public function __construct($sOptionKey = null, $sCallerPath = null, $sCapability = 'manage_network', $sTextDomain = 'admin-page-framework')
    {
        if (!$this->_isInstantiatable()) {
            return;
        }
        $sCallerPath = $sCallerPath ? $sCallerPath : AdminPageFramework_Utility::getCallerScriptPath(__FILE__);
        parent::__construct($sOptionKey, $sCallerPath, $sCapability, $sTextDomain);
        new AdminPageFramework_Model_Menu__RegisterMenu($this, 'network_admin_menu');
    }

    protected function _getLinkObject()
    {
        $_sClassName = $this->aSubClassNames['oLink'];
        return new $_sClassName($this->oProp, $this->oMsg);
    }

    protected function _getPageLoadObject()
    {
        $_sClassName = $this->aSubClassNames['oPageLoadInfo'];
        return new $_sClassName($this->oProp, $this->oMsg);
    }

    protected function _isInstantiatable()
    {
        if (isset($GLOBALS['pagenow']) && 'admin-ajax.php' === $GLOBALS['pagenow']) {
            return false;
        }
        if (is_network_admin()) {
            return true;
        }
        return false;
    }

    static public function getOption($sOptionKey, $asKey = null, $vDefault = null)
    {
        return AdminPageFramework_WPUtility::getSiteOption($sOptionKey, $asKey, $vDefault);
    }
}
