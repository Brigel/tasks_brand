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

namespace Tasks\Brand\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Brand
 * @package Tasks\Brand\Model
 */
class Brand extends AbstractModel
{
    const ENTITY = 'tasks_brand';

    protected function _construct(
    ) {
        $this->_init('Tasks\Brand\Model\ResourceModel\Brand');
    }

    /**
     * @return string
     */
    public function getUrlPath()
    {
        $urlKey = $this->getUrlKey();
        return 'brand/' . $urlKey . '.html';
    }

    /**
     * @param $urlKey
     * @return mixed
     */
    public function getBrandIdByUrlKey($urlKey)
    {
        $brand =
            $this->getCollection()
                ->addFieldToSelect('entity_id')
                ->addFieldToFilter('url_key', ['eq' => $urlKey])
                ->getFirstItem();
        return $brand->getId();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return '/' . 'brand' . '/' . $this->getUrlKey() . '.html';
    }

}
