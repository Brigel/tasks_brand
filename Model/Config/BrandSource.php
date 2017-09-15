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

namespace Magecom\Brand\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 * @package Magecom\Learning\Model\Config
 */
class BrandSource extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var \Magecom\Brand\Model\ResourceModel\Brand\Collection
     */
    protected $brandCollection;

    /**
     * BrandSource constructor.
     * @param \Magecom\Brand\Model\ResourceModel\Brand\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magecom\Brand\Model\ResourceModel\Brand\CollectionFactory $collectionFactory
    ) {
        $collection = $collectionFactory->create();
        $this->brandCollection = $collection;
    }

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public function getOptionArray()
    {
        $this->brandCollection->addAttributeToSelect('*');
        $items = $this->brandCollection->exportToArray();
        $result = [];
        foreach ($items as $item) {
            $result[$item["entity_id"]] = __($item['name']);
        }
        return $result;
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function toOptionArray()
    {
        $result = [];

        foreach ($this->getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = $this->getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}
