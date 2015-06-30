<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Storage\StorageAdapterInterface;
use AvangateSmartApiClient\Transport\TransportAdapterInterface;

class ApiClientManager
{
    protected $productApiClient;
    protected $orderApiClient;

    protected $storageAdapter;
    protected $transportAdapter;

    public function __construct(ApiClientInterface $productApiClient, ApiClientInterface $orderApiClient)
    {
        $this->productApiClient = $productApiClient;
        $this->orderApiClient = $orderApiClient;
    }

    public function setStorageAdapter(StorageAdapterInterface $storageAdapter)
    {
        $this->storageAdapter = $storageAdapter;
    }

    public function setTransportAdapter(TransportAdapterInterface $transportAdapter)
    {
        $this->transportAdapter = $transportAdapter;
    }

    /**
     * @return ApiClientInterface|ProductApiClientResponseInterface
     */
    public function getProductApiClient()
    {
        return $this->productApiClient;
    }

    /**
     * @return ApiClientInterface|OrderApiClientResponseInterface
     */
    public function getOrderApiClient()
    {
        return $this->orderApiClient;
    }
}