<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Config;

class OrderConfig extends Config\AbstractConfig implements Config\ConfigInterface
{
    protected $defaultCurrency;
    protected $defaultLanguage;
    protected $defaultCountry;

    public function setDefaultCurrency($defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    public function setDefaultLanguage($defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;
    }

    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    public function setDefaultCountry($defaultCountry)
    {
        $this->defaultCountry = $defaultCountry;
    }

    public function getDefaultCountry()
    {
        return $this->defaultCountry;
    }
}
