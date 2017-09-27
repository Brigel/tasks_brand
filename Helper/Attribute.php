<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magecom\Brand\Helper;

/**
 * Class Attribute
 * @package Magecom\Brand\Helper
 */
class Attribute extends \Magento\Framework\Url\Helper\Data
{
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Return information array of product attribute input types
     * Only a small number of settings returned, so we won't break anything in current data flow
     * As soon as development process goes on we need to add there all possible settings
     *
     * @param string $inputType
     * @return array
     */
    public function getAttributeInputTypes($inputType = null)
    {
        /**
         * @todo specify there all relations for properties depending on input type
         */
        $inputTypes = [
            'multiselect' => [
                'source_model'=>'Magento\Eav\Model\Entity\Attribute\Source\Table',
                'backend_model' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend'
            ],
            'boolean' => ['source_model' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean'],
        ];

        if ($inputType === null) {
            return $inputTypes;
        } else {
            if (isset($inputTypes[$inputType])) {
                return $inputTypes[$inputType];
            }
        }
        return [];
    }

    /**
     * Return default attribute backend model by input type
     *
     * @param string $inputType
     * @return string|null
     */
    public function getAttributeBackendModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['backend_model'])) {
            return $inputTypes[$inputType]['backend_model'];
        }
        return null;
    }

    /**
     * Return default attribute source model by input type
     *
     * @param string $inputType
     * @return string|null
     */
    public function getAttributeSourceModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['source_model'])) {
            return $inputTypes[$inputType]['source_model'];
        }
        return null;
    }

}
