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

namespace Tasks\Brand\Controller\Brand;

use Braintree\Exception;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Index
 * @package Tasks\Brand\Controller\Products
 */
class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Tasks\Brand\Helper\Data
     */
    protected $_brandConfig;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Tasks\Brand\Model\ResourceModel\Brand\CollectionFactory
     */
    protected $_brandFactory;


    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        \Tasks\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Tasks\Brand\Model\ResourceModel\Brand $bb
    ) {
        $this->bb = $bb;
        $this->_brandFactory = $brandFactory;
        $this->_coreRegistry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_initBrand();
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;

    }

    protected function _initBrand()
    {
        $brandId = $this->_request->getParam('brand');

        if (!is_numeric($brandId) && !($brandId > 0)) {
            throw new \Exception('Param "brand" not correct value');
        }

        $brand = $this->_brandFactory->create();
        $brand->load($brandId);
        $this->_coreRegistry->register('current_brand', $brand);
    }

}