<?php
namespace AvangateSmartApiClient\Order\Item\Totals\Obj;

class TotalsObj {

    /**
     * Total NetPrice per Item.
     * @var double
     */
    public $NetPrice = null;

    /**
     * Total GrossPrice per Item.
     * @var double
     */
    public $GrossPrice = null;

    /**
     * Total VAT per Item.
     * @var double
     */
    public $VAT = null;

    /**
     * Total Discount per Item.
     * @var double
     */
    public $Discount = null;

    /**
     * @var double
     */
    public $UnitPrice = null;

    /**
     * @var double
     */
    public $UnitVAT = null;

    /**
     * @var double
     */
    public $UnitNetPrice = null;

    /**
     * @var double
     */
    public $UnitGrossPrice = null;

    /**
     * @var double
     */
    public $UnitAffiliateCommission = null;

    /**
     * @var double
     */
    public $UnitDiscount = null;

    /**
     * @var float
     */
    public $UnitNetDiscountedPrice = null;

    /**
     * @var float
     */
    public $UnitGrossDiscountedPrice = null;

    /**
     * @var float
     */
    public $NetDiscountedPrice = null;

    /**
     * @var float
     */
    public $GrossDiscountedPrice = null;

}
