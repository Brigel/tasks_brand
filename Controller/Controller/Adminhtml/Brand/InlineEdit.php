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

namespace Tasks\Brand\Controller\Adminhtml\Brand;

/**
 * Class InlineEdit
 * @package Tasks\Brand\Controller\Adminhtml\Brand
 */
abstract class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * JSON Factory
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_jsonFactory;

    /**
     * Brand Factory
     *
     * @var \Tasks\Brand\Model\BrandFactory
     */
    protected $_brandFactory;

    /**
     * constructor
     *
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Tasks\Brand\Model\BrandFactory $brandFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Tasks\Brand\Model\BrandFactory $brandFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_jsonFactory = $jsonFactory;
        $this->_brandFactory = $brandFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];
        $brandItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($brandItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($brandItems) as $brandId) {
            /** @var \Tasks\Brand\Model\Brand $brand */
            $brand = $this->_brandFactory->create()->load($brandId);
            try {
                $brandData = $brandItems[$brandId];//todo: handle dates
                $brand->addData($brandData);
                $brand->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithbrandId($brand, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithbrandId($brand, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithbrandId(
                    $brand,
                    __('Something went wrong while saving the Item.')
                );
                $error = true;
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Item id to error message
     *
     * @param \Tasks\Brand\Model\Brand $brand
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithbrandId(\Tasks\Brand\Model\Brand $brand, $errorText)
    {
        return '[Item ID: ' . $brand->getId() . '] ' . $errorText;
    }
}
