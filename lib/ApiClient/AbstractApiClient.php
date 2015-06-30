<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Storage;
use AvangateSmartApiClient\Transport;

abstract class AbstractApiClient implements ApiClientInterface
{
    protected $sessionKey;
    protected $config;
    protected $httpClient;
    protected $storage;
    protected $proxy;
    protected $endpointUrl;
    protected $endpointPassword;
    protected $merchantCode;

    protected $storageManager;
    protected $transportAdapter;

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setStorageManager(Storage\StorageManager $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    public function getStorageManager()
    {
        return $this->storageManager;
    }

    public function setTransportAdapter(Transport\TransportAdapterInterface $transportAdapter)
    {
        $this->transportAdapter = $transportAdapter;
    }

    public function getTransportAdapter()
    {
        return $this->transportAdapter;
    }

    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    public function getProxy()
    {
        return $this->proxy;
    }

    public function setEndpointUrl($url)
    {
        $this->endpointUrl = $url;
    }

    public function getEndpointUrl()
    {
        return $this->endpointUrl;
    }

    public function setEndpointPassword($password)
    {
        $this->endpointPassword = $password;
    }

    public function getEndpointPassword()
    {
        return $this->endpointPassword;
    }

    public function setMerchantCode($merchantCode)
    {
        $this->merchantCode = $merchantCode;
    }

    public function getMerchantCode()
    {
        return $this->merchantCode;
    }

    public function setSessionKey($sessionKey = null)
    {
        if (is_null($sessionKey)) {
            $this->sessionKey = sha1($this->getEndpointUrl() . $this->getEndpointPassword() . $this->getMerchantCode());
        } else {
            $this->sessionKey = $sessionKey;
        }

        return $this->sessionKey;
    }

    public function getSessionKey()
    {
        if (!isset($this->sessionKey)) {
            return $this->setSessionKey();
        } else {
            return $this->sessionKey;
        }
    }

    abstract public function send($method, $args);
    abstract public function read();

    abstract public function login();
    abstract public function logout();

}
