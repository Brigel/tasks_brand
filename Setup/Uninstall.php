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

namespace Magecom\Brand\Setup;

/**
 * Class Uninstall
 * @package Magecom\Brand\Setup
 */
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
     * @var \Magecom\Brand\Model\BrandFactory
     */
    protected $brandFactory;

    /**
     * Recurring constructor.
     * @param \Magecom\Brand\Model\BrandFactory $brandFactory
     * @param BrandSetupFactory $brandSetupFactory
     */
    public function __construct(
        \Magecom\Brand\Model\BrandFactory $brandFactory,
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
         * @var \Magecom\Brand\Setup\BrandSetup $brandSetup
         */
        $brandSetup = $this->brandSetupFactory->create();

        $brandEntityType = \Magecom\Brand\Model\Brand::ENTITY;
        $brandEntityId = $brandSetup->getEntityTypeId($brandEntityType);

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