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

namespace Magecom\Brand\Controller\Adminhtml;

/**
 * Class Brand
 * @package Magecom\Brand\Controller\Adminhtml
 */
abstract class Brand extends \Magento\Backend\App\Action
{
    /**
     * Brand Factory
     *
     * @var \Magecom\Brand\Model\BrandFactory
     */
    protected $_brandFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result redirect factory
     *
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    protected $_resultRedirectFactory;

    /**
     * constructor
     *
     * @param \Magecom\Brand\Model\BrandFactory $brandFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magecom\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_brandFactory = $brandFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magecom\Brand\Model\Brand
     * @throws \Exception
     */
    protected function _initBrand()
    {
        $brandId = $this->getRequest()->getParam('entity_id');

        /** @var \Magecom\Brand\Model\Brand $brand */
        $brand = $this->_brandFactory->create();

        if (is_numeric($brandId) && $brandId > 0) {
            $brand->load( (int) $brandId);
        }
        $this->_coreRegistry->register('magecom_brand_brand', $brand);

        return $brand;
    }
}
