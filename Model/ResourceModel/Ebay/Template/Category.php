<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Model\ResourceModel\Ebay\Template;

class Category extends \Ess\M2ePro\Model\ResourceModel\ActiveRecord\AbstractModel
{
    //########################################

    public function _construct()
    {
        $this->_init('m2epro_ebay_template_category', 'id');
    }

    //########################################

    public function setSynchStatusNeed($newData, $oldData, $listingsProducts)
    {
        $listingsProductsIds = array();
        foreach ($listingsProducts as $listingProduct) {
            $listingsProductsIds[] = (int)$listingProduct['id'];
        }

        if (empty($listingsProductsIds)) {
            return;
        }

        if (!$this->isDifferent($newData,$oldData)) {
            return;
        }

        $templates = array('categoryTemplate');

        $lpTable = $this->activeRecordFactory->getObject('Listing\Product')->getResource()->getMainTable();

        $this->getConnection()->update(
            $lpTable,
            array(
                'synch_status' => \Ess\M2ePro\Model\Listing\Product::SYNCH_STATUS_NEED,
                'synch_reasons' => new \Zend_Db_Expr(
                    "IF(synch_reasons IS NULL,
                        '".implode(',',$templates)."',
                        CONCAT(synch_reasons,'".','.implode(',',$templates)."')
                    )"
                )
            ),
            array('id IN ('.implode(',', $listingsProductsIds).')')
        );
    }

    // ---------------------------------------

    public function isDifferent($newData, $oldData)
    {
        $ignoreFields = array(
            $this->getIdFieldName(),
            'title',
            'create_date', 'update_date'
        );

        foreach ($ignoreFields as $ignoreField) {
            unset($newData[$ignoreField],$oldData[$ignoreField]);
        }

        !isset($newData['specifics']) && $newData['specifics'] = array();
        !isset($oldData['specifics']) && $oldData['specifics'] = array();

        foreach ($newData['specifics'] as $key => $newSpecific) {
            unset($newData['specifics'][$key]['id'], $newData['specifics'][$key]['template_category_id']);
        }
        foreach ($oldData['specifics'] as $key => $oldSpecific) {
            unset($oldData['specifics'][$key]['id'], $oldData['specifics'][$key]['template_category_id']);
        }

        ksort($newData);
        ksort($oldData);
        array_walk($newData['specifics'],'ksort');
        array_walk($oldData['specifics'],'ksort');

        return md5(json_encode($newData)) !== md5(json_encode($oldData));
    }

    //########################################
}