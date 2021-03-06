<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Block\Adminhtml\Ebay\Listing\Product\Category\Settings\Specific;

class Wrapper extends \Ess\M2ePro\Block\Adminhtml\Magento\AbstractContainer
{
    //########################################

    public function _construct()
    {
        parent::_construct();

        // Initialization block
        // ---------------------------------------
        $this->setId('ebayListingCategorySpecificWrapper');
        // ---------------------------------------

        $this->_headerText = $this->__('eBay Categories Specifics');

        // ---------------------------------------
        $this->addButton('back', array(
            'label'     => $this->__('Back'),
            'class'     => 'back back_category_button',
            'onclick'   => 'EbayListingProductCategorySettingsSpecificWrapperObj.renderPrevCategory();'
        ));
        // ---------------------------------------

        // ---------------------------------------
        $this->addButton('continue', array(
            'id'        => 'save_button primary forward',
            'label'     => $this->__('Continue'),
            'class'     => 'action-primary continue specifics_buttons',
            'onclick'   => "EbayListingProductCategorySettingsSpecificWrapperObj.save();"
        ));
        // ---------------------------------------

        // ---------------------------------------
        $this->addButton('next_category_header_button', array(
            'id'        => 'next_category_header_button',
            'label'     => $this->__('Next Category'),
            'class'     => 'action-primary next_category_button specifics_buttons',
            'onclick'   => "EbayListingProductCategorySettingsSpecificWrapperObj.renderNextCategory();"
        ));
        // ---------------------------------------

        $this->setTemplate('ebay/listing/product/category/settings/specific/wrapper.phtml');
    }
    
    //########################################

    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();

        // ---------------------------------------

        $listing = $this->getHelper('Data\GlobalData')->getValue('listing_for_products_category_settings');

        $viewHeaderBlock = $this->createBlock('Listing\View\Header','', [
            'data' => ['listing' => $listing]
        ]);

        $this->setChild('view_header', $viewHeaderBlock);

        // ---------------------------------------

        // ---------------------------------------
        $data = array(
            'id'      => 'next_category_button',
            'class'   => 'action primary next_category_button specifics_buttons',
            'label'   => $this->__('Next Category'),
            'onclick' => 'EbayListingProductCategorySettingsSpecificWrapperObj.renderNextCategory();'
        );
        $buttonBlock = $this->createBlock('Magento\Button')->setData($data);
        $this->setChild('next_category_button', $buttonBlock);
        // ---------------------------------------

        // ---------------------------------------
        $data = array(
            'class'   => 'action primary continue specifics_buttons forward',
            'label'   => $this->__('Continue'),
            'onclick' => 'EbayListingProductCategorySettingsSpecificWrapperObj.save();'
        );
        $buttonBlock = $this->createBlock('Magento\Button')->setData($data);
        $this->setChild('continue', $buttonBlock);
        // ---------------------------------------
    }

    //########################################
//
    protected function _toHtml()
    {
        // ---------------------------------------
        $urls = array();

        $path = 'ebay_listing_product_category_settings/stepThreeSaveCategorySpecificsToSession';
        $urls[$path] = $this->getUrl('*/' . $path, array(
            '_current' => true
        ));

        $path = 'ebay_listing_product_category_settings/stepThreeGetCategorySpecifics';
        $urls[$path] = $this->getUrl('*/' . $path, array(
            '_current' => true
        ));

        $path = 'ebay_listing_product_category_settings/save';
        $urls[$path] = $this->getUrl('*/' . $path, array(
            '_current' => true
        ));

        $path = 'ebay_listing_product_category_settings';
        $urls[$path] = $this->getUrl('*/' . $path, array(
            'step' => 2,
            '_current' => true,
            'skip_get_suggested' => true
        ));

        $path = 'ebay_listing/review';
        $urls[$path] = $this->getUrl('*/' . $path, array(
            '_current' => true,
        ));

        $this->jsUrl->addUrls($urls);
        // ---------------------------------------

        // M2ePro_TRANSLATIONS
        // Loading. Please wait
        $text = 'Loading. Please wait';
        $translations[$text] = $this->__($text);

        $this->jsTranslator->addTranslations($translations);
        $this->jsTranslator->add('Set Item Specifics', $this->__('Set Item Specifics'));
        // ---------------------------------------

        $this->js->add(<<<JS

require([
    'M2ePro/Ebay/Listing/Product/Category/Settings/Specific/Wrapper',
    'M2ePro/Plugin/AreaWrapper'
], function(){

    window.EbayListingProductCategorySettingsSpecificWrapperObj = new EbayListingProductCategorySettingsSpecificWrapper(
        '{$this->getData('current_category')}',
        new AreaWrapper('specifics_main_container_wrapper')
    );

});

JS
);

        return parent::_toHtml();
    }

    //########################################
}