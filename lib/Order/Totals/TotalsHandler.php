<?php
namespace AvangateSmartApiClient\Order\Totals;

use AvangateSmartApiClient\Functions\UtilityFunctions;

class TotalsHandler
{
    private $orderTotalsObj;
    protected $functions;

    public function __construct(Obj\Order $orderTotalsObj)
    {
        $this->orderTotalsObj = $orderTotalsObj;
        $this->functions = new UtilityFunctions();
    }

    /**
     * Returns the basic object instance.
    */
    public function getOriginalInstance()
    {
        return $this->orderTotalsObj;
    }

    /**
     * Return the Cart price's Shipping value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getShipping()
    {
        return (float)$this->getOriginalInstance()->Shipping;
    }

    /**
     * Return the Cart price's ShippingVAT value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getShippingVAT()
    {
        return (float)$this->getOriginalInstance()->ShippingVAT;
    }

    /**
     * Return the Cart price's NetPrice value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getNetPrice()
    {
        return (float)$this->getOriginalInstance()->NetPrice;
    }

    /**
     * Return the Cart price's GrossPrice value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getGrossPrice()
    {
        return (float)$this->getOriginalInstance()->GrossPrice;
    }

    /**
     * Return the Cart price's VAT value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getVAT()
    {
        return (float)$this->getOriginalInstance()->VAT;
    }

    /**
     * Return the Cart price's AffiliateCommission value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getAffiliateCommission()
    {
        return (float)$this->getOriginalInstance()->AffiliateCommission;
    }

    /**
     * Return the Cart price's AvangateCommission value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getAvangateCommission()
    {
        return (float)$this->getOriginalInstance()->AvangateCommission;
    }

    /**
     * Return the Cart price's Discount value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getDiscount()
    {
        return (float)$this->getOriginalInstance()->Discount;
    }

    public function getNetDiscountedPrice()
    {
        return (float)$this->getOriginalInstance()->NetDiscountedPrice;
    }

    public function getGrossDiscountedPrice()
    {
        return (float)$this->getOriginalInstance()->GrossDiscountedPrice;
    }

    /**
     * Checks if the instance is reset.
     * All prices are NULL.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        if ($this->functions->count($this->getOriginalInstance()) == 0) {
            return true;
        }

        foreach($this->getOriginalInstance() as $key => $value){
            if (!is_null($value)) {
                return false;
            }
        }

        return true;
    }
}
