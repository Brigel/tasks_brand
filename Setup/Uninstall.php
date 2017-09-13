<?php

namespace Tasks\Brand\Setup;

class Uninstall implements \Magento\Framework\Setup\UninstallInterface
{


    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resource;

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection
     */
    private $attrCollection;

    /**
     * Brand setup factory
     *
     * @var BrandSetupFactory
     */
    private $brandSetupFactory;

    /**
     * @var \Tasks\Brand\Model\BrandFactory
     */
    protected $brandFactory;

    /**
     * Recurring constructor.
     * @param \Tasks\Brand\Model\BrandFactory $brandFactory
     * @param BrandSetupFactory $brandSetupFactory
     */
    public function __construct(
        \Tasks\Brand\Model\BrandFactory $brandFactory,
        BrandSetupFactory $brandSetupFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory $attrCollectionFactory,
        \Magento\Framework\App\ResourceConnection $resource
    )
    {
        $this->resource = $resource;
        $this->attrCollection = $attrCollectionFactory->create();
        $this->brandFactory = $brandFactory;
        $this->brandSetupFactory = $brandSetupFactory;
    }

    /**
     * Module uninstall code
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @return void
     */
    public function uninstall(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        $setup->startSetup();

        /**
         * @var \Tasks\Brand\Setup\BrandSetup $brandSetup
         */
        $brandSetup = $this->brandSetupFactory->create();

        $brandEntityType = \Tasks\Brand\Model\Brand::ENTITY;
        $brandEntityId = $brandSetup->getEntityTypeId($brandEntityType);

        $this->attrCollection->addFieldToFilter(\Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID, ['eq'=>(int)$brandEntityId]);
        $this->attrCollection->addFieldToSelect('attribute_id');

        $attributes = $this->attrCollection->load()->getItems();

        foreach ($attributes as $attr) {
            $brandSetup->removeAttribute($brandEntityId, $attr->getId());
        }

        $brandSetup->removeEntityType($brandEntityId);

        $productEntityId = $brandSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $brandSetup->removeAttribute($productEntityId,'brand');

        $this->resource->getConnection()->dropTable($brandEntityType.'_entity_datetime');
        $this->resource->getConnection()->dropTable($brandEntityType.'_entity_decimal');
        $this->resource->getConnection()->dropTable($brandEntityType.'_entity_int');
        $this->resource->getConnection()->dropTable($brandEntityType.'_entity_text');
        $this->resource->getConnection()->dropTable($brandEntityType.'_entity_varchar');
        $this->resource->getConnection()->dropTable($brandEntityType.'_entity');


        $setup->endSetup();
    }
}