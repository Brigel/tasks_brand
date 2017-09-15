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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

/**
 * Class Recurring
 * @package Magecom\Brand\Setup
 */
class Recurring implements InstallSchemaInterface {

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
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $collection
    )
    {
        $this->collection = $collection;
        $this->brandFactory = $brandFactory;
        $this->brandSetupFactory = $brandSetupFactory;
    }


    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $brandSetup = $this->brandSetupFactory->create();
        $attrBrand = $brandSetup->getAttribute(\Magento\Catalog\Model\Product::ENTITY, 'brand');

        if(empty($attrBrand))
        {
            $brandSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'brand',
                [
                    'type' => 'int',
                    'label' => 'Brand',
                    'input' => 'select',
                    'source' => 'Magecom\Brand\Model\Config\BrandSource',
                    'default' => 1,
                ]
            );
        }

    }
}