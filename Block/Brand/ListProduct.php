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

namespace Magecom\Brand\Block\Brand;

//use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class Grid
 * @package Magecom\Brand\Block\Adminhtml\Brand
 */
class ListProduct extends Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected $_productCollection;

    /**
     * @var \Magecom\Brand\Helper\Data
     */
    protected $_brandConfig;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $_pageConfig;

    /**
     * ListProduct constructor.
     * @param Template\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection
     * @param \Magecom\Brand\Helper\Data $brandConfig
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\View\Page\Config $pageConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
        \Magecom\Brand\Helper\Data $brandConfig,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Page\Config $pageConfig,
        array $data = [])
    {
        $this->_pageConfig = $pageConfig;
        $this->_brandConfig = $brandConfig;
        $this->_productCollection = $productCollection;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
        $this->initial();
    }

    private function initial()
    {
        $brand = $this->_coreRegistry->registry('current_brand');

        $metaTitle = $brand->getMetaTitle() ?: $this->_brandConfig->getDefaultMetaTitle();
        $metaDescription = $brand->getMetaDescription() ?: $this->_brandConfig->getDefaultMetaDescription();
        $metaKeywords = $brand->getMetaKeywords() ?: $this->_brandConfig->getDefaultMetaKeywords() ;

        $this->_pageConfig->getTitle()->set($metaTitle);
        $this->_pageConfig->setKeywords($metaDescription);
        $this->_pageConfig->setDescription($metaKeywords);

        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($brand->getName());
        }
    }

    /**
     * @return \Magento\Catalog\Model\Product[]
     */
    public function getProductsByCurrentBrand()
    {
        $brand = $this->_coreRegistry->registry('current_brand');
        $this->_productCollection->addFieldToFilter('brand', ['eq'=>$brand->getId()]);
        return $this->_productCollection->getItems();
    }

}
