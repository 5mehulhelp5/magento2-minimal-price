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
 - [Settings](#settings)
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

### Minimal Price

Define the minimal price availability for a product. The price is capped to the minimal value if any special price, 
tier price or catalog rule tries to price down the limit.

## Settings

- Set the minimal price on products.

### Product Attributes

- minimal_price, available in the "Prices" group.

## Support

Raise a new [request](https://github.com/opengento/magento2-minimal-price/issues) to the issue tracker.

## Authors

- **Opengento Community** - *Lead* - [![Twitter Follow](https://img.shields.io/twitter/follow/opengento.svg?style=social)](https://twitter.com/opengento)
- **Thomas Klein** - *Maintainer* - [![GitHub followers](https://img.shields.io/github/followers/thomas-kl1.svg?style=social)](https://github.com/thomas-kl1)
- **Contributors** - *Contributor* - [![GitHub contributors](https://img.shields.io/github/contributors/opengento/magento2-minimal-price.svg?style=flat-square)](https://github.com/opengento/magento2-minimal-price/graphs/contributors)

## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) details.

***That's all folks!***
