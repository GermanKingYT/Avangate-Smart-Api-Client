<?php
require '../vendor/autoload.php';

/**
 * @var $app AvangateSmartApiClient\Module\FrontController
 */
$app = include '../include/app.php';

// Merchant related data.
echo sprintf('Languages: [%d]', $app->getStorageManager()->importLanguages());
echo sprintf('Countries: [%d]', $app->getStorageManager()->importCountries());
echo sprintf('States:  [%d]', $app->getStorageManager()->importStates());
echo sprintf('Currencies:  [%d]', $app->getStorageManager()->importCurrencies());
echo sprintf('Payment methods:  [%d]', $app->getStorageManager()->importPaymentMethods());
echo sprintf('Payment methods currencies:  [%d]', $app->getStorageManager()->importPaymentMethodsCurrencies());
echo sprintf('Payment methods countries:  [%d]', $app->getStorageManager()->importPaymentMethodsCountries());
echo sprintf('Payment methods types:  [%d]', $app->getStorageManager()->importPaymentMethodsTypes());
echo sprintf('Additional fields: [%d]', $app->getStorageManager()->importAdditionalFields());

echo sprintf('Price Option Groups: [%d]', $app->getStorageManager()->importPriceOptionGroups());
echo sprintf('Products: [%d]', $app->getStorageManager()->importProducts($filters = array()));
echo sprintf('Products additional fields: [%d]', $app->getStorageManager()->importProductsAdditionalFields());