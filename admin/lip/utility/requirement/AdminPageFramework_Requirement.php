<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_Requirement
{
    private $_aRequirements = array();
    public $aWarnings = array();
    private $_aDefaultRequirements = array('php' => array('version' => '5.2.4', 'error' => 'The plugin requires the PHP version %1$s or higher.',), 'wordpress' => array('version' => '3.3', 'error' => 'The plugin requires the WordPress version %1$s or higher.',), 'mysql' => array('version' => '5.0', 'error' => 'The plugin requires the MySQL version %1$s or higher.',), 'functions' => array(), 'classes' => array(), 'constants' => array(), 'files' => array(),);

    public function __construct(array $aRequirements = array(), $sScriptName = '')
    {
        $aRequirements = $aRequirements + $this->_aDefaultRequirements;
        $aRequirements = array_filter($aRequirements, 'is_array');
        foreach (array('php', 'mysql', 'wordpress') as $_iIndex => $_sName) {
            if (isset($aRequirements[$_sName])) {
                $aRequirements[$_sName] = $aRequirements[$_sName] + $this->_aDefaultRequirements[$_sName];
            }
        }
        $this->_aRequirements = $aRequirements;
        $this->_sScriptName = $sScriptName;
    }

    public function check()
    {
        $_aWarnings = array();
        $_aWarnings[] = $this->_getWarningByType('php');
        $_aWarnings[] = $this->_getWarningByType('wordpress');
        $_aWarnings[] = $this->_getWarningByType('mysql');
        $this->_aRequirements = $this->_aRequirements + array('functions' => array(), 'classes' => array(), 'constants' => array(), 'files' => array(),);
        $_aWarnings = array_merge($_aWarnings, $this->_checkFunctions($this->_aRequirements['functions']), $this->_checkClasses($this->_aRequirements['classes']), $this->_checkConstants($this->_aRequirements['constants']), $this->_checkFiles($this->_aRequirements['files']));
        $this->aWarnings = array_filter($_aWarnings);
        return count($this->aWarnings);
    }

    private function _getWarningByType($sType)
    {
        if (!isset($this->_aRequirements[$sType]['version'])) {
            return '';
        }
        if ($this->_checkPHPVersion($this->_aRequirements[$sType]['version'])) {
            return '';
        }
        return sprintf($this->_aRequirements[$sType]['error'], $this->_aRequirements[$sType]['version']);
    }

    private function _checkPHPVersion($sPHPVersion)
    {
        return version_compare(phpversion(), $sPHPVersion, ">=");
    }

    private function _checkWordPressVersion($sWordPressVersion)
    {
        return version_compare($GLOBALS['wp_version'], $sWordPressVersion, ">=");
    }

    private function _checkMySQLVersion($sMySQLVersion)
    {
        global $wpdb;
        $_sInstalledMySQLVersion = isset($wpdb->use_mysqli) && $wpdb->use_mysqli ? @mysqli_get_server_info($wpdb->dbh) : @mysql_get_server_info();
        return $_sInstalledMySQLVersion ? version_compare($_sInstalledMySQLVersion, $sMySQLVersion, ">=") : true;
    }

    private function _checkClasses($aClasses)
    {
        return empty($aClasses) ? array() : $this->_getWarningsByFunctionName('class_exists', $aClasses);
    }

    private function _checkFunctions($aFunctions)
    {
        return empty($aFunctions) ? array() : $this->_getWarningsByFunctionName('function_exists', $aFunctions);
    }

    private function _checkConstants($aConstants)
    {
        return empty($aConstants) ? array() : $this->_getWarningsByFunctionName('defined', $aConstants);
    }

    private function _checkFiles($aFilePaths)
    {
        return empty($aFilePaths) ? array() : $this->_getWarningsByFunctionName('file_exists', $aFilePaths);
    }

    private function _getWarningsByFunctionName($sFuncName, $aSubjects)
    {
        $_aWarnings = array();
        foreach ($aSubjects as $_sSubject => $_sWarning) {
            if (!call_user_func_array($sFuncName, array($_sSubject))) {
                $_aWarnings[] = sprintf($_sWarning, $_sSubject);
            }
        }
        return $_aWarnings;
    }

    public function setAdminNotices()
    {
        add_action('admin_notices', array($this, '_replyToPrintAdminNotices'));
    }

    public function _replyToPrintAdminNotices()
    {
        $_aWarnings = array_unique($this->aWarnings);
        if (empty($_aWarnings)) {
            return;
        }
        echo "<div class='error notice is-dismissible'>" . "<p>" . $this->_getWarnings() . "</p>" . "</div>";
    }

    private function _getWarnings()
    {
        $_aWarnings = array_unique($this->aWarnings);
        if (empty($_aWarnings)) {
            return '';
        }
        $_sScripTitle = $this->_sScriptName ? "<strong>" . $this->_sScriptName . "</strong>:&nbsp;" : '';
        return $_sScripTitle . implode('<br />', $_aWarnings);
    }

    public function deactivatePlugin($sPluginFilePath, $sMessage = '', $bIsOnActivation = false)
    {
        add_action('admin_notices', array($this, '_replyToPrintAdminNotices'));
        $this->aWarnings[] = '<strong>' . $sMessage . '</strong>';
        if (!function_exists('deactivate_plugins')) {
            if (!@include(ABSPATH . '/wp-admin/includes/plugin.php')) {
                return;
            }
        }
        deactivate_plugins($sPluginFilePath);
        if ($bIsOnActivation) {
            $_sPluginListingPage = add_query_arg(array(), $GLOBALS['pagenow']);
            wp_die($this->_getWarnings() . "<p><a href='$_sPluginListingPage'>Go back</a>.</p>");
        }
    }
}
