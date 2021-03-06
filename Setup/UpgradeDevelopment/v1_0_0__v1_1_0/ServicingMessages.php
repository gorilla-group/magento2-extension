<?php

namespace Ess\M2ePro\Setup\UpgradeDevelopment\v1_0_0__v1_1_0;

use Ess\M2ePro\Model\Setup\Upgrade\Entity\AbstractFeature;

class ServicingMessages extends AbstractFeature
{
    //########################################
    
    public function execute()
    {
        $this->getConfigModifier('primary')->getEntity('/M2ePro/server/', 'messages')->delete();
    }

    //########################################
}