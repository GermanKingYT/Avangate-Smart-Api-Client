<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Storage;
use AvangateSmartApiClient\Transport;

interface ApiClientInterface
{
    function setSessionKey($sessionKey = null);
    function getSessionKey();
    function setConfig(array $config);
    function getConfig();
    function setStorageManager(Storage\StorageManager $storageManager);
    function getStorageManager();
    function setTransportAdapter(Transport\TransportAdapterInterface $transportAdapter);
    function getTransportAdapter();
    function setProxy($proxy);
    function getProxy();
    function setEndpointUrl($url);
    function getEndpointUrl();
    function setEndpointPassword($password);
    function getEndpointPassword();
    function setMerchantCode($merchantCode);
    function getMerchantCode();

    function send($method, $args);
    function read();

    function login();
    function logout();
}