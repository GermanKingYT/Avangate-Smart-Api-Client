<?php
namespace AvangateSmartApiClient\Order\Totals\Obj;

class Product
{
    /**
     * @var string ISO 4217 code
     */
    public $Currency = null;

    /**
     * @var double
     */
    public $Shipping = null;

    /**
     * @var double
     */
    public $ShippingVAT = null;

    /**
     * @var double
     */
    public $NetPrice = null;

    /**
     * @var double
     */
    public $GrossPrice = null;

    /**
     * @var double
     */
    public $VAT = null;

    /**
     * @var double
     */
    public $AffiliateCommission = null;

    /**
     * @var double
     */
    public $AvangateCommission = null;

    /**
     * @var double
     */
    public $Discount = null;

    public $UnitNetPrice = null;
    public $UnitGrossPrice = null;
    public $UnitVAT = null;
    public $UnitDiscount = null;
    public $UnitNetDiscountedPrice = null;
    public $UnitGrossDiscountedPrice = null;
    public $UnitAffiliateCommission = null;
    public $NetDiscountedPrice = null;
    public $GrossDiscountedPrice = null;

    
}
