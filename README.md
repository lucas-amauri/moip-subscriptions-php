# MoIp Subscriptions

## Instalação

Execute em seu shell:

    composer require lucasamauri/moip-subscriptions-php

> Authentication
```php
require 'vendor/autoload.php';

use Moip\Moip;

$token = '01010101010101010101010101010101';
$key = 'ABABABABABABABABABABABABABABABABABABABAB';

$moip = new Moip($token, $key, Moip::ENDPOINT_SANDBOX);
```
