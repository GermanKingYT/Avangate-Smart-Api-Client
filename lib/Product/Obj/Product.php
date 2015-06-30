<?php
namespace AvangateSmartApiClient\Product\Obj;

use AvangateSmartApiClient\Product\PricingConfiguration\Obj\PricingConfiguration;
use AvangateSmartApiClient\Product\Price\Obj\ProductPrice;

class Product
{
    /**
     * @var integer
     */
    public $AvangateId;
    /**
     * @var string
     */
    public $ProductCode;
    /**
     * @var string
     */
    public $ProductType;
    /**
     * @var string
     */
    public $ProductName;
    /**
     * @var string
     */
    public $ProductVersion;
    /**
     * @var string
     */
    public $GroupName;
    /**
     * @var string|null
     */
    public $ShippingClass;
    /**
     * @var boolean
     */
    public $GiftOption;
    /**
     * @var string
     */
    public $ShortDescription;
    /**
     * @var string
     */
    public $LongDescription;
    /**
     * @var string
     */
    public $SystemRequirements;
    /**
     * @var string
     */
    public $ProductCategory;
    /**
     * @var array
     */
    public $Platforms;
    /**
     * @var array
     */
    public $ProductImages;
    /**
     * @var string
     */
    public $TrialUrl;
    /**
     * @var string
     */
    public $TrialDescription;
    /**
     * @var boolean
     */
    public $Enabled;
    /**
     * @var array
     */
    public $AdditionalFields;
    /**
     * @var \stdClass
     */
    public $Translations;
    /**
     * @var PricingConfiguration[]
     */
    public $PricingConfigurations;
    /**
     * @var ProductPrice[]
     */
    public $Prices;
    /**
     * @var array
     */
    public $BundleProducts;
    /**
     * @var string
     */
    public $Fulfillment;
    /**
     * @var boolean
     */
    public $GeneratesSubscription;
    /**
     * @var \stdClass
     */
    public $SubscriptionInformation;
}