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

> Planos
```php
// Create a plan
$plan = $moip->plan()
    ->setCode("P99")
    ->setName("R$99")
    ->setDescription("Plano R$99")
    ->setAmount(99.00)
    ->create();

// List Plans
$moip->plan()->getList();
```

> Assinatura
```php
// Create a subscription
$customer = $moip->customer()
        ->setCode("01")
        ->setFullname("Your Awesome Name")
        ->setTaxDocument("999.999.999-99")
        ->setEmail("mail@example.com")
        ->setPhone(31, 99999999)
        ->setBirthDate("1980-06-02")
        ->addAddress("AV", "Larga", null, "Vila Cristina", "Belo Horizonte", "MG", "33333-333")
        ->setBillingInfo("Your Awesome Name", "5209 9026 0329 5762", 12, 21, 522)
        ;
try {
    $subscription = $moip->subscription()
        ->setCode("01")
        ->setCustomer($customer)
        ->setPlan("P99")
        ->setPaymentMethod("CREDIT_CARD")
        ->create();
}
catch (Exception $e) {
    var_dump($e->getMessage());
}
```
