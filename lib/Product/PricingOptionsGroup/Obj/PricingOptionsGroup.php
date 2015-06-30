<?php
namespace AvangateSmartApiClient\Product\PricingOptionsGroup\Obj;

use AvangateSmartApiClient\Product\PricingOptionsGroup\PricingOption;

class PricingOptionsGroup
{
    /**
     * @var string
     */
    var $Type;
    /**
     * @var string
     */
    var $Code;
    /**
     * @var boolean
     */
    var $Required;
    /**
     * @var string
     */
    var $Name;
    /**
     * @var string
     */
    var $Description;
    /**
     * @var \stdClass[]
     */
    var $Translations;
    /**
     * @var PricingOption\Obj\PricingOption[]
     */
    var $Options;
}