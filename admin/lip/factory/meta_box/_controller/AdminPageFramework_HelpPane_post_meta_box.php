<?php

/**
 *
 *
 *
 * Licensed under MIT <http://opensource.org/licenses/MIT> */
class AdminPageFramework_HelpPane_post_meta_box extends AdminPageFramework_HelpPane_Base
{
    public function _replyToRegisterHelpTabText()
    {
        if (!$this->_isInThePage()) {
            return false;
        }
        $this->_setHelpTab($this->oProp->sMetaBoxID, $this->oProp->sTitle, $this->oProp->aHelpTabText, $this->oProp->aHelpTabTextSide);
    }
}
