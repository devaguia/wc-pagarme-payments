# Pagar.me payments for WooCommerce

**Description:** Payment plugin for WooCommerce/WordPress using the Pagar.me API.

## Anchors
- [Developer notes](#notes)
- [Install dependencies](#install)
- [Build dependencies](#build)
- [Ignored folders and files](#ignore)
- [File Tree](#tree)



<h2 id="notes">Developer notes</h1>

This is a template developed to facilitate the creation of plugins for the WordPress platform. It uses an adapted MVC pattern for a better development experience within the WordPress environment.

The plugin uses Typescript to develop features for Javascript. This is also optional and if necessary the files can be exchanged for Javascript files.
</br>
**Author:** [Matheus Aguiar](https://github.com/aguiarrdev)
</br>

<h2 id="install">Installing the dependencies</h1>

**Install the plugin autoload and dependencies with the composer**
``` 
composer install
```

**Install the node dependencies with the yarn or npm**
``` 
yarn install
npm install
```

<h2 id="build">Build dependencies</h2>

**Build production and watch the resource page changes**
```
yarn dev
```

**Build production assets**
```
yarn build
```

<h2 id="ignore">Ignored folders and files</h2>

**Folders**
- vendor/
- dist/
- node_modules/
- .cache/

**Files**
- *.lock


<h2 id="tree">File Tree</h2>

```
.
├── app
│   ├── Controllers
│   │   ├── Checkout
│   │   │   ├── Billet.php
│   │   │   ├── Credit.php
│   │   │   └── Pix.php
│   │   ├── Entities
│   │   │   ├── Installments.php
│   │   │   └── Settings.php
│   │   ├── Gateways
│   │   │   ├── Billet.php
│   │   │   ├── Credit.php
│   │   │   └── Pix.php
│   │   ├── Menus
│   │   │   ├── Installments.php
│   │   │   └── Pagarme.php
│   │   ├── Menus.php
│   │   ├── Render
│   │   │   ├── InterfaceRender.php
│   │   │   └── Render.php
│   │   ├── Thankyou
│   │   │   ├── Billet.php
│   │   │   ├── Credit.php
│   │   │   └── Pix.php
│   │   └── Webhooks.php
│   ├── Core
│   │   ├── Actions.php
│   │   └── Functions.php
│   ├── Helpers
│   │   ├── Config.php
│   │   ├── Export.php
│   │   ├── Gateways.php
│   │   ├── Uninstall.php
│   │   └── Utils.php
│   ├── index.php
│   ├── Model
│   │   ├── Database
│   │   │   ├── Bootstrap.php
│   │   │   ├── Table.php
│   │   │   └── Tables
│   │   │       └── Settings.php
│   │   ├── Entity
│   │   │   └── Settings.php
│   │   ├── InterfaceRepository.php
│   │   ├── Repository
│   │   │   └── Settings.php
│   │   └── Repository.php
│   ├── Services
│   │   ├── Pagarme
│   │   │   ├── Authentication.php
│   │   │   ├── Config.php
│   │   │   ├── Requests
│   │   │   │   ├── InterfaceRequest.php
│   │   │   │   ├── Orders
│   │   │   │   │   ├── Cancel.php
│   │   │   │   │   ├── Create.php
│   │   │   │   │   └── Get.php
│   │   │   │   └── Request.php
│   │   │   └── Webhooks
│   │   │       ├── Orders.php
│   │   │       └── Webhook.php
│   │   └── WooCommerce
│   │       ├── Checkout
│   │       │   └── Discount.php
│   │       ├── Gateways
│   │       │   ├── Gateway.php
│   │       │   ├── Gateways.php
│   │       │   └── InterfaceGateways.php
│   │       ├── Logs
│   │       │   └── Logger.php
│   │       ├── Orders
│   │       │   └── Status.php
│   │       └── WooCommerce.php
│   └── Views
│       ├── Admin
│       │   ├── credit
│       │   │   └── installments.php
│       │   ├── orders
│       │   │   └── logs.php
│       │   └── settings
│       │       └── pagarme.php
│       └── Pages
│           ├── checkout
│           │   ├── billet.php
│           │   ├── credit.php
│           │   └── pix.php
│           └── thankyou
│               ├── billet.php
│               ├── credit.php
│               └── pix.php
├── composer.json
├── languages
├── LICENSE
├── package.json
├── README.md
├── readme.txt
├── resources
│   ├── images/
│   ├── scripts/
│   └── styles/
├── tsconfig.json
└── wc-pagarme-payments.php


```

