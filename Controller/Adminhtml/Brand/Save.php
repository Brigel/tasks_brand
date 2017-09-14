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

namespace Magecom\Brand\Controller\Adminhtml\Brand;

/**
 * Class Save
 * @package Magecom\Brand\Controller\Adminhtml\Brand
 */
class Save extends \Magecom\Brand\Controller\Adminhtml\Brand
{
    /**
     * Backend session
     *
     * @var \Magento\Backend\Model\Session
     */
    protected $_backendSession;

    /**
     * constructor
     *
     * @param \Magento\Backend\Model\Session $backendSession
     * @param \Magecom\Brand\Model\BrandFactory $brandFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Model\Session $backendSession,
        \Magecom\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_backendSession = $backendSession;
        parent::__construct($brandFactory, $registry, $resultRedirectFactory, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('brand');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->_filterData($data);
            $brand = $this->_initBrand();
            $brand->setData($data);
            $this->_eventManager->dispatch(
                'magecom_brand_brand_prepare_save',
                [
                    'brand' => $brand,
                    'request' => $this->getRequest()
                ]
            );
            try {
                $brand->save();
                $this->messageManager->addSuccess(__('The Item has been saved.'));
                $this->_backendSession->setMagecomBrandItemData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'brand/*/edit',
                        [
                            'entity_id' => $brand->getId(),
                            '_current' => true
                        ]
                    );
                    return $resultRedirect;
                }
                $this->_eventManager->dispatch(
                    'magecom_brand_after_save',
                    [
                        'brand' => $brand,
                        'request' => $this->getRequest()
                    ]
                );
                $resultRedirect->setPath('brand/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Item.'));
            }
            $this->_getSession()->setMagecomBrandItemData($data);
            $resultRedirect->setPath(
                'brand/*/edit',
                [
                    'entity_id' => $brand->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        $resultRedirect->setPath('brand/*/');
        return $resultRedirect;
    }

    /**
     * filter values
     *
     * @param array $data
     * @return array
     */
    protected function _filterData($data)
    {
        if (isset($data['sample_multiselect'])) {
            if (is_array($data['sample_multiselect'])) {
                $data['sample_multiselect'] = implode(',', $data['sample_multiselect']);
            }
        }
        return $data;
    }
}
