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
class Status implements OptionSourceInterface
{
    /**
     * @var integer constant status disabled
     */
    const STATUS_DISABLED = 0;

    /**
     * @var integer constant status enabled
     */
    const STATUS_ENABLED = 1;

    /**
     * @var integer constant status archive
     */
    const STATUS_ARCHIVE = 2;

    /**
     * Retrieve option array
     *
     * @return string[]
     */
    public function getOptionArray()
    {
        return [
            self::STATUS_DISABLED => __('Disabled'),
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_ARCHIVE => __('Archive')
        ];
    }

    /**
     * Retrieve option array with empty value
     *
     * @return string[]
     */
    public function toOptionArray()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    public function getAllOptions(){
        return $this->toOptionArray();
    }

    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }

    public function setAttribute($_this){
        return $this;
    }
}