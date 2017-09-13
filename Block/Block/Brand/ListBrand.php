<?php
/**
 * Magecom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magecom.net so we can send you a copy immediately.
 *
 * @category Magecom
 * @package Magecom_Module
 * @copyright Copyright (c) 2017 Magecom, Inc. (http://www.magecom.net)
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Tasks\Brand\Block\Brand;

/**
 * Class Grid
 * @package Tasks\Brand\Block\Adminhtml\Brand
 */
class ListBrand extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Tasks\Brand\Model\ResourceModel\Brand\CollectionFactory
     */
    protected $_brandCollection;

    /**
     * @var
     */
    protected $_brands;

    /**
     * ListBrand constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Tasks\Brand\Model\ResourceModel\Brand\Collection $_brandCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Tasks\Brand\Model\ResourceModel\Brand\Collection $_brandCollection,
        array $data = []
    ) {
        $this->_brandCollection = $_brandCollection;
        $this->_brandCollection->addAttributeToSelect('*');
        parent::__construct($context, $data);
    }


    public function getBrands()
    {
        if (!$this->_brands) {
            $this->_brands = $this->_brandCollection->getItems();
        }
        return $this->_brands;

    }


}
