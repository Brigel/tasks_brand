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

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class UpgradeData
 * @package Magecom\TestEav\Setup
 */
class UpgradeData implements UpgradeDataInterface
{

    /**
     * EAV setup factory
     *
     * @var  \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var \Magecom\Brand\Model\BrandFactory
     */
    protected $brandFactory;

    /**
     * UpgradeData constructor.
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        \Magecom\Brand\Model\BrandFactory $brandFactory,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    ) {
        $this->brandFactory = $brandFactory;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        /**
         * Upgrading schema before upgrade Data
         */
        $this->upgradeSchema($setup);
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            /** @var \Magecom\Brand\Model\Brand $brand */
            $brand = $this->brandFactory->create();
            $data = $this->getDefaultData();

            foreach ($data as $item) {
                foreach ($item as $fieldName => $value) {
                    $brand->setData($fieldName, $value);
                }
                $brand->save();
                $brand->unsetData();
            }
        }

        $setup->endSetup();
    }

    /**
     * @return array
     */
    private function getDefaultData()
    {
        $defaultPicture = 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/256/file-picture-icon.png';
        $data = [
            [
                'name' => 'Guchini',
                'status' => \Magecom\Brand\Model\Config\Status::STATUS_ENABLED,
                'description' => 'Super guchini brand!',
                'logo' => $defaultPicture,
                'url_key' => 'gucha'
            ],
            [
                'name' => 'Armanini',
                'status' => \Magecom\Brand\Model\Config\Status::STATUS_ENABLED,
                'description' => 'Super armanini brand!',
                'logo' => $defaultPicture,
                'url_key' => 'arma'
            ],
        ];
        return $data;
    }

    /**
     * @param $setup
     */
    private function upgradeSchema($setup)
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /**
         * Add new attribute Brand to product
         */
        $eavSetup->addAttribute(
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

        $eavSetup->addAttribute(
            \Magecom\Brand\Model\Brand::ENTITY,
            'meta_title',
            [
                'type' => 'varchar',
                'label' => 'Meta title',
                'input' => 'text',
                'default' => '',
            ]
        );

        $eavSetup->addAttribute(
            \Magecom\Brand\Model\Brand::ENTITY,
            'meta_keywords',
            [
                'type' => 'varchar',
                'label' => 'Meta keywords',
                'input' => 'text',
                'default' => '',
            ]
        );

        $eavSetup->addAttribute(
            \Magecom\Brand\Model\Brand::ENTITY,
            'url_key',
            [
                'type' => 'varchar',
                'label' => 'Url key for url rewriter',
                'input' => 'text',
                'default' => '',
                'required' => true,
                'unique' => true,
            ]
        );

        $eavSetup->addAttribute(
            \Magecom\Brand\Model\Brand::ENTITY,
            'meta_description',
            [
                'type' => 'varchar',
                'label' => 'Meta description',
                'input' => 'text',
                'default' => '',
            ]
        );

    }

}