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

//use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class Grid
 * @package Tasks\Brand\Block\Adminhtml\Brand
 */
class ListProduct extends Template
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_productCollection;

    protected $_brandConfig;

    protected $_coreRegistry;

    protected $_pageConfig;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
        \Tasks\Brand\Helper\Data $brandConfig,
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

        $meta_title = $brand->getData('meta_title')? $brand->getData('meta_title')
            :$this->_brandConfig->getGeneralConfig('meta_title');

        $meta_description = $brand->getData('meta_description')? $brand->getData('meta_description')
            :$this->_brandConfig->getGeneralConfig('meta_description');

        $meta_keywords = $brand->getData('meta_keywords')? $brand->getData('meta_keywords')
            :$this->_brandConfig->getGeneralConfig('meta_keywords');

        $this->_pageConfig->getTitle()->set($meta_title);

        $this->_pageConfig->setKeywords($meta_description);

        $this->_pageConfig->setDescription($meta_keywords);

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
        $this->_productCollection->addFieldToSelect('brand',['eq'=>$brand->getId()]);
        return $this->_productCollection->getItems();
    }

}
