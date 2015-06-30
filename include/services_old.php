<?php
use AvangateSmartApiClient\System;
use AvangateSmartApiClient\Config;
use AvangateSmartApiClient\Transport;
use AvangateSmartApiClient\Storage;
use AvangateSmartApiClient\ApiClient;
use AvangateSmartApiClient\Order;
use AvangateSmartApiClient\Module;

$c->bindShared('config', function($c) {
  return include 'config.php';
});


$c->bindShared('system', function($c) {
    return new System();
});

$c->bindShared('functions', function($c) {
    return new Module\Functions();
});

/**
 * Cart API object instance.
 */
$c->bindShared('order.obj.cart.instance',  function($c) {
    return new Order\Obj\Cart;
});

/**
 * Order default config instance.
 * @param $c Illuminate\Container\Container
 * @return Config\OrderConfig
 */
$c->bindShared('order.config.instance', function($c) {
    /**
     * Order config instance.
     */
    $orderConfig = new Config\OrderConfig();
    $orderConfig->setDefaultCountry($c['config']['order']['default.country']);
    $orderConfig->setDefaultCurrency($c['config']['order']['default.currency']);
    $orderConfig->setDefaultLanguage($c['config']['order']['default.language']);
    return $orderConfig;
});

/**
 * Transport instance.
 * @param $c Illuminate\Container\Container
 * @return Transport\HttpTransport
 */
$c->bindShared('transport', function($c) {
    $httpClient = new AvangateSmartApiClient\Transport\HttpTransport();
    return $httpClient;
});

/**
 * Storage config instance.
 * @param $c Illuminate\Container\Container
 * @return Config\FileStorageConfig
 */
$c->bindShared('storage.config.instance', function($c) {
    $storageConfig = new AvangateSmartApiClient\Config\FileStorageConfig();
    $storageConfig->setPath($c['config']['storage.file']['path']);
    return $storageConfig;
});

/**
 * Storage instance.
 * @param $c Illuminate\Container\Container
 * @return Storage\FileStorage
 */
$c->bindShared('storage', function($c) {
    $storage = new AvangateSmartApiClient\Storage\FileStorage(
        $c['storage.config.instance'],
        $c['system']
    );
    return $storage;
});

/**
 * Order API client config instance.
 * @param $c Illuminate\Container\Container
 * @return Config\ApiClientConfig
 */
$c->bindShared('product.api.client.config.instance', function($c) {
    $productApiClientConfig = new AvangateSmartApiClient\Config\ApiClientConfig();
    $productApiClientConfig->setMerchantCode($c['config']['api.client']['merchant.code']);
    $productApiClientConfig->setEndpointPassword($c['config']['api.client']['password']);
    $productApiClientConfig->setEndpointUrl($c['config']['api.client']['product.url']);
    return $productApiClientConfig;
});

/**
 * Product API client config instance.
 * @param $c Illuminate\Container\Container
 * @return ApiClient\JsonRPC
 */
$c->bindShared('product.api.client', function($c) {
    /**
     * Product API client instance.
     */
    $productApiClient = new AvangateSmartApiClient\ApiClient\JsonRPC(
        $c['product.api.client.config.instance'],
        $c['transport'],
        $c['storage']
    );
    return $productApiClient;
});

/**
 * Order API client config instance.
 * @param $c Illuminate\Container\Container
 * @return Config\ApiClientConfig
 */
$c->bindShared('order.api.client.config.instance', function($c) {
    $orderApiClientConfig = new AvangateSmartApiClient\Config\ApiClientConfig();
    $orderApiClientConfig->setMerchantCode($c['config']['api.client']['merchant.code']);
    $orderApiClientConfig->setEndpointPassword($c['config']['api.client']['password']);
    $orderApiClientConfig->setEndpointUrl($c['config']['api.client']['order.url']);
    return $orderApiClientConfig;
});

/**
 * Order API client instance.
 * @param $c Illuminate\Container\Container
 * @return ApiClient\JsonRPC
 */
$c->bindShared('order.api.client', function($c) {
    $orderApiClient = new AvangateSmartApiClient\ApiClient\JsonRPC(
        $c['order.api.client.config.instance'],
        $c['transport'],
        $c['storage']
    );
    return $orderApiClient;
});