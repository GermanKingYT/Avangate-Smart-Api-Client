<?php
namespace AvangateSmartApiClient\Product\PricingConfiguration\Obj;

use AvangateSmartApiClient\Product\PricingOptionsGroup\PricingOption\Obj\PricingOption;

class PricingConfiguration
{
    /**
     * @var string
     */
    var $Name;
    /**
     * @var boolean
     */
    var $Default;
    /**
     * @var array
     */
    var $BillingCountries;
    /**
     * @var string
     */
    var $PricingSchema;
    /**
     * @var string
     */
    var $PriceType;
    /**
     * @var string
     */
    var $DefaultCurrency;
    /**
     * @var \stdClass
     */
    var $Prices;
    /**
     * @var PricingOption[]
     */
    var $PriceOptions;
}