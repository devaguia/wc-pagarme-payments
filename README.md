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

By default it configures [ORM Eloquent](https://laravel.com/docs/9.x/eloquent) to facilitate database access, creation of new tables and other database options. If you don't want or don't need to use this tool, just remove the files inside the "[Model](./app/Model/)" folder and the "Bootstrap" class calls in the "[Functions.php](./app/Hooks/Functions.php)" and "[Uninstall.php](./app/Helpers/Uninstall.php)" files.
Also don't forget to remove the dependency "[as247/wp-eloquent](https://github.com/as247/wp-eloquent)", present in the file "composer.json"

The plugin also uses Typescript to develop features for Javascript. This is also optional and if necessary the files can be exchanged for Javascript files.
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
yarn watch
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
│   │   │   └── Checkout.php
│   │   ├── Entities
│   │   ├── Gateways
│   │   │   └── Gateway.php
│   │   ├── Menus
│   │   │   └── Service.php
│   │   ├── Menus.php
│   │   ├── Render
│   │   │   ├── InterfaceRender.php
│   │   │   └── Render.php
│   │   └── Webhooks
│   │       └── Example.php
│   ├── Core
│   │   ├── Actions.php
│   │   ├── Functions.php
│   │   └── Uninstall.php
│   ├── Helpers
│   │   ├── Config.php
│   │   └── Utils.php
│   ├── index.php
│   ├── Model
│   │   ├── Database
│   │   │   ├── Bootstrap.php
│   │   │   └── Tables
│   │   │       └── Example.php
│   │   └── Example.php
│   ├── Services
│   │   └── WooCommerce
│   │       ├── Gateways
│   │       │   ├── Gateways.php
│   │       │   └── InterfaceGateways.php
│   │       ├── Logs
│   │       │   └── Logs.php
│   │       ├── Orders
│   │       │   └── Status.php
│   │       ├── Webhooks
│   │       │   ├── InterfaceWebhooks.php
│   │       │   └── Webhooks.php
│   │       └── WooCommerce.php
│   └── Views
│       ├── Admin
│       │   ├── service.php
│       │   └── template-parts
│       │       └── header.php
│       └── Pages
│           └── template-parts
│               └── index.php
├── composer.json
├── languages
├── LICENSE
├── package.json
├── README.md
├── readme.txt
├── resources
│   ├── images
│   │   └── cb-icon.png
│   ├── scripts
│   │   ├── admin
│   │   │   ├── components
│   │   │   │   └── Notification
│   │   │   │       └── index.ts
│   │   │   └── pages
│   │   │       └── service
│   │   │           └── index.ts
│   │   ├── global
│   │   │   └── components
│   │   └── theme
│   │       ├── components
│   │       └── pages
│   └── styles
│       ├── admin
│       │   ├── base
│       │   │   ├── index.scss
│       │   │   └── _vars.scss
│       │   ├── components
│       │   │   ├── _container.scss
│       │   │   ├── _notification.scss
│       │   │   └── _title.scss
│       │   ├── index.scss
│       │   └── pages
│       │       └── service
│       │           └── index.scss
│       ├── global
│       │   ├── base
│       │   │   ├── index.scss
│       │   │   └── _vars.scss
│       │   ├── components
│       │   │   └── index.scss
│       │   └── index.scss
│       └── theme
│           ├── base
│           │   ├── index.scss
│           │   └── _vars.scss
│           ├── components
│           │   └── index.scss
│           └── index.scss
├── tsconfig.json
└── wc-pagarme-payments.php

```

