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
 * Class Delete
 * @package Tasks\Brand\Controller\Adminhtml\Brand
 */
class Delete extends \Tasks\Brand\Controller\Adminhtml\Brand
{
    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->_resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            $name = "";
            try {
                /** @var \Tasks\Brand\Model\Brand $brand */
                $brand = $this->_brandFactory->create();
                $brand->load($id);
                $name = $brand->getName();
                $brand->delete();
                $this->messageManager->addSuccess(__('The Item has been deleted.'));
                $this->_eventManager->dispatch(
                    'adminhtml_tasks_brand_brand_on_delete',
                    ['name' => $name, 'status' => 'success']
                );
                $resultRedirect->setPath('brand/*/');
                return $resultRedirect;
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_tasks_brand_brand_on_delete',
                    ['name' => $name, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                $resultRedirect->setPath('brand/*/edit', ['entity_id' => $id]);
                return $resultRedirect;
            }
        }
        // display error message
        $this->messageManager->addError(__('Item to delete was not found.'));
        // go to grid
        $resultRedirect->setPath('brand/*/');
        return $resultRedirect;
    }
}
