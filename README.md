Gephart Configuration
===

[![Build Status](https://travis-ci.org/gephart/configuration.svg?branch=master)](https://travis-ci.org/gephart/configuration)

Dependencies
---
 - PHP >= 7.0

Instalation
---

```
composer require gephart/configuration
```

Using
---

/config/my.json

/index.php

```
$configuration = new \Gephart\Configuration\Configuration();
$configuration->setDirectory(__DIR__ . "/config");
$my_configuration = $configuration->get("my");
// Array data from my.json
```