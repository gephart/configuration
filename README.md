Gephart Configuration
===

[![php](https://github.com/gephart/configuration/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/gephart/configuration/actions)

Dependencies
---
 - PHP >= 7.1

Instalation
---

```bash
composer require gephart/configuration
```

Basic using
---

/config/my.json

/index.php

```php
$configuration = new \Gephart\Configuration\Configuration();
$configuration->setDirectory(__DIR__ . "/config");
$my_configuration = $configuration->get("my");
// Array data from my.json
```

Usign with gephart/dependency-injection
---

```php
$container = new \Gephart\DependencyInjection\Container();
$configuration = $container->get(\Gephart\Configuration\Configuration::class);
$configuration->setDirectory(__DIR__ . "/config");
// Next code (routing etc...)
```