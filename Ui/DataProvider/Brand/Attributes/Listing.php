<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magecom\Brand\Ui\DataProvider\Brand\Attributes;

use Magento\Framework\App\RequestInterface;

/**
 * DataProvider for product attributes listing
 */
class Listing extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Listing constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Magento\Eav\Model\ResourceModel\Entity\AttributeFactory $collectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory $collectionFactory,
        \Magento\Eav\Setup\EavSetup $eavSetup,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->eavSetup = $eavSetup;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->request = $request;
        /**
         * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $this->collection
         */
        $this->collection = $collectionFactory->create();
        $entityId = $this->eavSetup->getEntityTypeId(\Magecom\Brand\Model\Brand::ENTITY);
        $this->collection->addFieldToFilter('entity_type_id',['eq'=>$entityId]);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $items = [];
        foreach ($this->getCollection()->getItems() as $attribute) {
            $items[] = $attribute->toArray();
        }

        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => $items
        ];
    }
}
