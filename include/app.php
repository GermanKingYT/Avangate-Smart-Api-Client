<?php
$c = new Illuminate\Container\Container;

include 'config.php';
include 'services.php';


use AvangateSmartApiClient\Functions;
use AvangateSmartApiClient\ApiClient;
use AvangateSmartApiClient\Module;
use AvangateSmartApiClient\Order;
use AvangateSmartApiClient\Storage;
use AvangateSmartApiClient\Transport;

try {
    $orderConfig = new Order\OrderConfig();
    $orderConfig->setDefaultCountry($c['config']['order']['default.country']);
    $orderConfig->setDefaultCurrency($c['config']['order']['default.currency']);
    $orderConfig->setDefaultLanguage($c['config']['order']['default.language']);

    $storageAdapterConfig = new Storage\FileStorageAdapterConfig();
    $storageAdapterConfig->setPath($c['config']['storage.file']['path']);

    $storageAdapter = new Storage\FileStorageAdapter($storageAdapterConfig);

    $productApiClientConfig = new ApiClient\ApiClientConfig();
    $productApiClientConfig->setMerchantCode($c['config']['api.client']['merchant.code']);
    $productApiClientConfig->setEndpointPassword($c['config']['api.client']['password']);
    $productApiClientConfig->setEndpointUrl($c['config']['api.client']['product.url']);

    $productApiClient = new ApiClient\JsonRPCClient($productApiClientConfig);

    $orderApiClientConfig = new ApiClient\ApiClientConfig();
    $orderApiClientConfig->setMerchantCode($c['config']['api.client']['merchant.code']);
    $orderApiClientConfig->setEndpointPassword($c['config']['api.client']['password']);
    $orderApiClientConfig->setEndpointUrl($c['config']['api.client']['order.url']);

    $orderApiClient = new ApiClient\JsonRPCClient($orderApiClientConfig);

    $apiClientManager = new ApiClient\ApiClientManager($productApiClient, $orderApiClient);
    $apiClientManager->setStorageAdapter($storageAdapter);
    $apiClientManager->setTransportAdapter(new Transport\HttpTransportAdapter(new GuzzleHttp\Client()));

    $app = new Module\FrontController($orderConfig, new Storage\StorageManager($storageAdapter, $apiClientManager));

    /**
     * @var Module\FrontController
     */
    return $app;

} catch(Storage\Exception\RuntimeException $e) {
    var_dump($e->getCode());
    var_dump($e->getMessage());
} catch(Order\Exception\RuntimeException $e) {
    var_dump($e->getCode());
    var_dump($e->getMessage());
} catch(Order\Item\Exception\RuntimeException $e) {
    var_dump($e->getCode());
    var_dump($e->getMessage());
} catch(Module\Exception\InvalidArgumentException $e) {
    var_dump($e->getCode());
    var_dump($e->getMessage());
}