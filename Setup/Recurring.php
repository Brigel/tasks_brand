<?php
namespace Magecom\Brand\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;


class Recurring implements InstallSchemaInterface {

//    protected $logger;
//
//    public function __construct(
//        \Psr\Log\LoggerInterface $loggerInterface
//    ) {
//        $this->logger = $loggerInterface;
//    }
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