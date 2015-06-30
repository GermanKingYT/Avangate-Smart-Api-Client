<?php
namespace AvangateSmartApiClient\Order\Totals\Obj;

class Order {
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
    public $Discount = null;    
    
    /**
     * @var double
     */
    public $NetDiscountedPrice = null;
    
    /**
     * @var double
     */
    public $GrossDiscountedPrice = null;    
    
    /**
     * @var double
     */
    public $AffiliateCommission = null;

    /**
     * @var double
     */
    public $AvangateCommission = null;
}
