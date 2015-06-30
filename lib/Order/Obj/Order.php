<?php
namespace AvangateSmartApiClient\Order\Obj;

use AvangateSmartApiClient\Order\Totals;

/**
 * @see v2_5\CAPIContents in Avangate API
 */
class Order
{
    /**
     * @internal
     * @var integer
     */
    public $CartId;

    /**
     * @internal
     * @var string
     */
    public $Currency = '';

    /**
     * @internal
     * @var string
     */
    public $Language = '';

    /**
     * @internal
     * @var string ISO 2-letter uppercase
     */
    public $Country;

    /**
     * @internal
     * @var string
     */
    public $CustomerIP;

    /**
     * Time of the user that places the order,
     * this is grabed with JavaScript.
     * The format is YYYY-mm-dd HH:ii:ss
     * @var string
     */
    public $LocalTime;

    public $Source;
    public $AffiliateSource;

    public $Items;
    public $Promotions;

    /**
     * @var string
     */
    public $ExternalReference;

    /**
     * @var string
     */
    public $CustomerReference;

    public $BillingDetails;
    public $DeliveryDetails;
    public $PaymentDetails;

    public $Origin;

    /**
     * @var Totals\Obj\Order
     */
    public $Totals;

    public $Shipping = null;
    public $ShippingVAT = null;
    public $NetPrice = null;
    public $GrossPrice = null;
    public $VAT = null;
    public $AffiliateCommission = null;
    public $AvangateCommission = null;
    public $Discount = null;
    public $NetDiscountedPrice = null;
    public $GrossDiscountedPrice = null;

    /**
     * @var AdditionalField[]
     */
    public $AdditionalFields;

    // Finish specific variables.
    public $RefNo;
    public $OrderNo;
    public $ShopperRefNo;
    public $Status;
    public $ApproveStatus;
    public $OrderDate;
    public $FinishDate;
    public $HasShipping;
    /**
     * @see CAPIOrderCompleteInformation in Avangate API
     *
     * @var object
     */
    public $CustomerDetails;

    // Errors object. Usually returned by the API response.
    public $Errors;
}