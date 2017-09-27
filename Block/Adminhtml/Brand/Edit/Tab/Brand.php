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

namespace Magecom\Brand\Block\Adminhtml\Brand\Edit\Tab;

/**
 * Class Brand
 * @package Magecom\Brand\Block\Adminhtml\Brand\Edit\Tab
 */
class Brand extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Wysiwyg config
     *
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    protected $eavSetup;

    protected $_attributeCollection;

    /**
     * Country options
     *
     * @var \Magecom\Brand\Model\Config\Status
     */
    protected $_status;

    /**
     * constructor
     *
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magecom\Brand\Model\Config\Status $status
     * @param array $data
     */
    public function __construct(
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magecom\Brand\Model\Config\Status $status,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $attrResu,
        \Magento\Eav\Setup\EavSetup $eavSetup,
        array $data = []
    ) {
        $this->eavSetup = $eavSetup;
        $this->_attributeCollection = $attrResu;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return \Magento\Backend\Block\Widget\Form\Generic
     */
    protected function _prepareForm()
    {
        /** @var \Magecom\Brand\Model\Brand $item */
        $item = $this->_coreRegistry->registry('magecom_brand_brand');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('brand_');
        $form->setFieldNameSuffix('brand');

        $this->addEavTab($form, $item->getId());

        $itemData = $this->_session->getData('magecom_brand_brand_data', true);
        if ($itemData) {
            $item->addData($itemData);
        }

        $form->addValues($item->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Brand');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    protected function addEavTab(&$form, $itemId)
    {

        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Item Information'),
                'class' => 'fieldset-wide'
            ]
        );

        if ($itemId) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                ['name' => 'entity_id']
            );
        }

        $entityId = $this->eavSetup->getEntityTypeId(\Magecom\Brand\Model\Brand::ENTITY);

        $this->_attributeCollection->addFieldToFilter("entity_type_id", ["eq"=>$entityId]);

        $items = $this->_attributeCollection->getItems();

        foreach ($items as $item) {

            $name = $item->getAttributeCode();
            $type = $this->getAttributeType($item);

            $fieldData = [
                'name' => $item->getName(),
                'label' => __($item->getName()),
                'title' => __($item->getName()),
                'required' => (bool)$item->getIsRequired(),
            ];

            if($type=='select'||$type=='multiselect'){
                if($type=='multiselect'){
                    $options = $item->getSource()->getAllOptions(false);
                }else{
                    $options = $item->getSource()->getAllOptions();
                }
                $fieldData['values'] = $options;
            }
            if(!$itemId){
                $fieldData['value'] = $item->getDefaultValue();
            }

            $fieldset->addField($name, $type, $fieldData);
        }
    }

    protected function getAttributeType($item)
    {
        if ($item->getFrontendModel() !== null) {
            if (!class_exists($item->getFrontendModel())) {
                return'text';
            }else{
                return $item->getFrontend()->getInputType();
            }
        } else {
            return $item->getFrontend()->getInputType();
        }
        throw new \Exception("Attribute not has frontend input part");
    }

}
