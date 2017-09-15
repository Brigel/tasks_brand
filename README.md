Magecom module for adding brands to product.
===========
This module for magento 2 

What adding?
*  brand field to product
*  data management to admin panel
*  two new pages to front 
* * list of brands
* * list products by brands

Installation
------------
This library can be found on [Packagist](https://packagist.org/packages/magecom/module-brand).


The recommended way to install
In magento admin interface: 

Off secure keys in "Stores->Configuration->Advanced->Admin->Security->Add Secret Key to URLs"


Then disable and clean cache


In console
```
In root directory of you project
$ php bin/magento cache:disable
$ php bin/magento cache:clean 
$ php bin/magento cache:flush
```
Then install module 
```
In root directory of you project
$ composer require magecom/module-brand
```
Then when install succes need upgrade data
```
In root directory of you project
$ php bin/magento setup:upgrade
```
Installation completed

Usage
-----
* If you wont manage brands, can click on BRANDS in admin menu.
* Seen brands you can on front after click on brands menu
* Brands support url rewrites by url key field and you can specify the meta: title, keywords and description 
* In product on main edit tab add select field brand. 


Uninstall
---------
If you wont uninstall you can write in console
```
In root directory of you project
$ php bin/magento module:uninstall Magecom_Brand
```

**Note: the uninstall command seems bugged and might get stuck at**
 ```
Removing code from Magento codebase
```
When this happens you should exit with ctrl+c and run


```

<public_key> and <private_key> replace to  you access key
$ config http-basic.repo.magento.com <public_key> <private_key>
```

For get <public_key> and <private_key> you need go to [Magento connect](https://www.magentocommerce.com/magento-connect/customer/account/login) -> My account -> Developers -> Secure keys -> Magento 2.
If you don't have keys. You need click to "Ceate A New Access Key" button.