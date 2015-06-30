<?php
namespace AvangateSmartApiClient\Product\PricingOptionsGroup\PricingOption\Obj;

class PricingOption
{
    /**
     * @var string
     */
    var $Code;
    /**
     * @var string
     */
    var $Name;
    /**
     * @var string
     */
    var $Description;
    /**
     * @var integer
     */
    var $ScaleMin;
    /**
     * @var integer
     */
    var $ScaleMax;

    var $SubscriptionImpact;
    /**
     * @var \stdClass
     */
    var $PriceImpact;
    /**
     * @var boolean
     */
    var $Default;
    /**
     * @var \stdClass[]
     */
    var $Translations;
}