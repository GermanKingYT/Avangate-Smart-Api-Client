<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Config\AbstractConfig;
use AvangateSmartApiClient\Config\ConfigInterface;

class ApiClientConfig extends AbstractConfig implements ConfigInterface
{
    protected $endpointUrl;
    protected $endpointPassword;
    protected $merchantCode;

    public function setEndpointUrl($endpointUrl)
    {
        $this->endpointUrl = $endpointUrl;
    }

    public function getEndpointUrl()
    {
        return $this->endpointUrl;
    }

    public function setEndpointPassword($endpointPassword)
    {
        $this->endpointPassword = $endpointPassword;
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
}