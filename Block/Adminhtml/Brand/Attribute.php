<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magecom\Brand\Block\Adminhtml\Brand;

/**
 * Adminhtml catalog product attributes block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Attribute extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_brand_attribute';
        $this->_blockGroup = 'Magecom_Brand';
        $this->_headerText = __('Brand Attributes');
        $this->_addButtonLabel = __('Add New Attribute');
        parent::_construct();
    }
}
