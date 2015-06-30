<?php
namespace AvangateSmartApiClient\Order\Item\Totals;

use AvangateSmartApiClient\Module\AbstractSubject;

/**
 * CartItem instance, used to query totals.
 */
class TotalsHandler extends AbstractSubject
{
    private $totalsObj;

    public function __construct(Obj\TotalsObj $totalsObj)
    {
        $this->totalsObj = $totalsObj;
    }

    /**
     * Returns the basic object instance.
     */
    public function getOriginalInstance()
    {
        return $this->totalsObj;
    }

    /**
     * @param $UnitNetPrice
     * @return float
     */
    public function setUnitNetPrice($UnitNetPrice)
    {
        $this->getOriginalInstance()->UnitNetPrice = $UnitNetPrice;
    }

    /**
     * Return the CartItem UnitNetPrice's value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getUnitNetPrice()
    {
        return (float)$this->getOriginalInstance()->UnitNetPrice;
    }

    /**
     * @param $UnitGrossPrice
     * @return float
     */
    public function setUnitGrossPrice($UnitGrossPrice)
    {
        $this->getOriginalInstance()->UnitGrossPrice = $UnitGrossPrice;
    }

    /**
     * Returns the CartItem UnitGrossPrice's value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getUnitGrossPrice()
    {
        return (float)$this->getOriginalInstance()->UnitGrossPrice;
    }

    /**
     * @param $UnitVAT
     */
    public function setUnitVAT($UnitVAT)
    {
        $this->getOriginalInstance()->UnitVAT = $UnitVAT;
    }

    /**
     * Return the CartItem price's UnitVAT value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getUnitVAT()
    {
        return (float)$this->getOriginalInstance()->UnitVAT;
    }

    /**
     * @param $NetPrice
     * @return float
     */
    public function setNetPrice($NetPrice)
    {
        $this->getOriginalInstance()->NetPrice = $NetPrice;
    }

    /**
     * Return the CartItem price's NetPrice value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getNetPrice()
    {
        return (float)$this->getOriginalInstance()->NetPrice;
    }

    /**
     * @param float $GrossPrice
     */
    public function setGrossPrice($GrossPrice)
    {
        $this->getOriginalInstance()->GrossPrice = $GrossPrice;
    }

    /**
     * Return the CartItem price's GrossPrice value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getGrossPrice()
    {
        return (float)$this->getOriginalInstance()->GrossPrice;
    }

    /**
     * @param $VAT
     * @return float
     */
    public function setVAT($VAT)
    {
        $this->getOriginalInstance()->VAT = $VAT;
    }

    /**
     * Return the CartItem price's VAT value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getVAT()
    {
        return (float)$this->getOriginalInstance()->VAT;
    }

    /**
     * @param float $UnitAffiliateCommission
     */
    public function setUnitAffiliateCommission($UnitAffiliateCommission)
    {
        $this->getOriginalInstance()->UnitAffiliateCommission = $UnitAffiliateCommission;
    }

    /**
     * Return the CartItem price's UnitAffiliateCommission value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getUnitAffiliateCommission()
    {
        return (float)$this->getOriginalInstance()->UnitAffiliateCommission;
    }

    /**
     * @param float $Discount
     */
    public function setDiscount($Discount)
    {
        $this->getOriginalInstance()->Discount = $Discount;
    }

    /**
     * Return the CartItem price's Discount value.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getDiscount()
    {
        return (float)$this->getOriginalInstance()->Discount;
    }

    /**
     * @param float $UnitDiscount
     */
    public function setUnitDiscount($UnitDiscount)
    {
        $this->getOriginalInstance()->UnitDiscount = $UnitDiscount;
    }

    /**
     * Returns the CartItem discount per unit.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getUnitDiscount()
    {
        return (float)$this->getOriginalInstance()->UnitDiscount;
    }

    /**
     * @param float $UnitNetDiscountedPrice
     */
    public function setUnitNetDiscountedPrice($UnitNetDiscountedPrice)
    {
        $this->getOriginalInstance()->UnitNetDiscountedPrice = $UnitNetDiscountedPrice;
    }

    /**
     * Returns the CartItem net discount per unit.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getUnitNetDiscountedPrice()
    {
        return (float)$this->getOriginalInstance()->UnitNetDiscountedPrice;
    }

    /**
     * @param float $UnitGrossDiscountedPrice
     */
    public function setUnitGrossDiscountedPrice($UnitGrossDiscountedPrice)
    {
        $this->getOriginalInstance()->UnitGrossDiscountedPrice = $UnitGrossDiscountedPrice;
    }

    /**
     * Returns the CartItem gross discount per unit.
     * Returns 0.0 if not found.
     *
     * @return float
     */
    public function getUnitGrossDiscountedPrice()
    {
        return (float)$this->getOriginalInstance()->UnitGrossDiscountedPrice;
    }

    /**
     * @param float $NetDiscountedPrice
     */
    public function setNetDiscountedPrice($NetDiscountedPrice)
    {
        $this->getOriginalInstance()->NetDiscountedPrice = $NetDiscountedPrice;
    }

    /**
     * @return float
     */
    public function getNetDiscountedPrice()
    {
        return (float)$this->getOriginalInstance()->NetDiscountedPrice;
    }

    /**
     * @param float $GrossDiscountedPrice
     */
    public function setGrossDiscountedPrice($GrossDiscountedPrice)
    {
        $this->getOriginalInstance()->GrossDiscountedPrice = $GrossDiscountedPrice;
    }

    /**
     * @return float
     */
    public function getGrossDiscountedPrice()
    {
        return (float)$this->getOriginalInstance()->GrossDiscountedPrice;
    }
}
