# Minimal Price Module for Magento 2

[![Latest Stable Version](https://img.shields.io/packagist/v/opengento/module-minimal-price.svg?style=flat-square)](https://packagist.org/packages/opengento/module-minimal-price)
[![License: MIT](https://img.shields.io/github/license/opengento/magento2-minimal-price.svg?style=flat-square)](./LICENSE) 
[![Packagist](https://img.shields.io/packagist/dt/opengento/module-minimal-price.svg?style=flat-square)](https://packagist.org/packages/opengento/module-minimal-price/stats)
[![Packagist](https://img.shields.io/packagist/dm/opengento/module-minimal-price.svg?style=flat-square)](https://packagist.org/packages/opengento/module-minimal-price/stats)

This extension allows to set a minimal price to a product.

 - [Setup](#setup)
   - [Composer installation](#composer-installation)
   - [Setup the module](#setup-the-module)
 - [Features](#features)
 - [Did You Know](#did-you-know)
 - [Support](#support)
 - [Authors](#authors)
 - [License](#license)

## Setup

Magento 2 Open Source or Commerce edition is required.

### Composer installation

Run the following composer command:

```
composer require opengento/module-minimal-price
```

### Setup the module

Run the following magento command:

```
bin/magento setup:upgrade
```

**If you are in production mode, do not forget to recompile and redeploy the static resources.**

## Features

Define the minimal price availability for a product. The price is capped to the minimal value if any special price, 
tier price or catalog rule tries to price down the limit.

### Product Attributes

- minimal_price, available in the "Prices" group.

## Did You Know

While working on this project, it appears that Magento already has an attribute with code "minimal_price".  
This attribute exists in Magento since forever. It's actually a system attribute which is not visible through the admin panel.  
There is also a few method that refers to this attribute, such as:  

- \Magento\Catalog\Model\Product::getMinimalPrice (Called in \Magento\Catalog\Pricing\Price\FinalPrice::getMinimalPrice)
- \Magento\Catalog\Model\ResourceModel\Product\Collection::joinMinimalPrice (Never called)

This attribute and methods are not used in the Commerce edition neither.  
This module updates and reuse this existing attribute in order to give it a true usage.  

Also, while investigating a bug where the minimal price value was not handled in the PDP nor PLP.
It seems that the catalog_product_index_price is not used to render and display the final prices.  
When inspecting the query logs, it seems that even if the indexer is loaded and applied to the product list, 
when the template render the prices, the following method is used `\Magento\Catalog\Block\Product\ListProduct::getProductPrice`.
This method calls `Magento\Framework\Pricing\Render::render` which render a price by code. The engine will proceed with 
`Magento\Catalog\Pricing\Price\FinalPrice` and `Magento\Catalog\Pricing\Price\BasePrice`. The rendering is finally delegated 
to `Magento\CatalogRule\Pricing\Price\CatalogRulePrice` which loads any active catalog rules.  
  
The performance struggles comes when you have a lot of active catalog rule loaded every team for each items on the page.

## Support

Raise a new [request](https://github.com/opengento/magento2-minimal-price/issues) to the issue tracker.

## Authors

- **Opengento Community** - *Lead* - [![Twitter Follow](https://img.shields.io/twitter/follow/opengento.svg?style=social)](https://twitter.com/opengento)
- **Thomas Klein** - *Maintainer* - [![GitHub followers](https://img.shields.io/github/followers/thomas-kl1.svg?style=social)](https://github.com/thomas-kl1)
- **Contributors** - *Contributor* - [![GitHub contributors](https://img.shields.io/github/contributors/opengento/magento2-minimal-price.svg?style=flat-square)](https://github.com/opengento/magento2-minimal-price/graphs/contributors)

## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) details.

***That's all folks!***
