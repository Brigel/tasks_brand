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

namespace Magecom\Brand\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Brand
 * @package Magecom\Brand\Model
 */
class Brand extends AbstractModel
{
    /**
     * Entity name
     */
    const ENTITY = 'magecom_brand';

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resourceConnection;

    /**
     * Brand constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * init classes
     */
    protected function _construct(
    ) {
        $this->_init('Magecom\Brand\Model\ResourceModel\Brand');
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
