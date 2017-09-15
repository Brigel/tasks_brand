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

namespace Magecom\Brand\Controller;

use Magento\Framework\Url;

/**
 * Inchoo Custom router Controller Router
 *
 * @author      Zoran Salamun <zoran.salamun@inchoo.net>
 */
class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magecom\Brand\Model\Brand
     */
    protected $brands;

    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magecom\Brand\Model\Brand $brands
    ) {
        $this->brands = $brands;
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        if ($request->getModuleName() === 'brand') {
            return;
        }
        $mainPath = addcslashes($request->getDistroBaseUrl(), '/');
        $pathToBrand = 'brand\/([^\/]*).html$';
        $pattern = '/' . $mainPath . $pathToBrand . '/';
        $allPath = $request->getUriString();

        if (preg_match($pattern, $allPath) === 1) {
            $urlKey = $request->getPathInfo();
            $urlKey = str_replace('/brand/', '', $urlKey);
            $urlKey = str_replace('.html', '', $urlKey);

            if (!empty($urlKey)) {
                $brandId = $this->brands->getBrandIdByUrlKey($urlKey);
            }

            $request->setModuleName('brand')
                ->setControllerName('brand')
                ->setActionName('view')
                ->setParam('brand', $brandId);

            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $urlKey);
        } else {
            return;
        }

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}