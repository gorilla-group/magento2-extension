<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Block\Adminhtml\ControlPanel\Info;

use Ess\M2ePro\Block\Adminhtml\Magento\AbstractBlock;

class Installation extends AbstractBlock
{
    //########################################

    public function _construct()
    {
        parent::_construct();

        // Initialization block
        // ---------------------------------------
        $this->setId('controlPanelInfoInstallation');
        // ---------------------------------------

        $this->setTemplate('control_panel/info/installation.phtml');
    }

    //########################################

    protected function _beforeToHtml()
    {
        $this->setupData = $this->activeRecordFactory->getObject('Setup')->getCollection()->toArray()['items'];

        return parent::_beforeToHtml();
    }

    //########################################
}