<?php
namespace AvangateSmartApiClient\Order\Item\Obj;

use AvangateSmartApiClient\Order\Item\Totals;

/**
 * v2_5\CAPINewOrderItem
 */
class OrderItem
{
    /**
     * @var integer
     */
    public $AvangateId;

    /**
     * @var string
     */
    public $Code;

    /**
     * @var int
     */
    public $Quantity;

    /**
     * @var string[]
     */
    public $PriceOptions;

    /**
     * @var Totals\Obj\TotalsObj
     */
    public $Price;

    public $CrossSell;

    /**
     * @var Totals\Obj\TrialTotalsObj
     */
    public $Trial;

    public $AdditionalFields;

    public $Promotion;
    public $AdditionalInfo;
}
