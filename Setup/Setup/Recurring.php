<?php
namespace Tasks\Brand\Setup;

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
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $collection
    )
    {
        $this->collection = $collection;
        $this->brandFactory = $brandFactory;
        $this->brandSetupFactory = $brandSetupFactory;
    }


    public function install( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
//        $this->logger->debug('RECURRING IS USE  INSTALL METHOD!!!!!!!!!!');

        $asd = "123";

    }
}