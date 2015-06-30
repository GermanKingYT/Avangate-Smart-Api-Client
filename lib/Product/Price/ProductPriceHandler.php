<?php
namespace AvangateSmartApiClient\Product\Price;

/**
 * ProductPrice instance, used in volume discounts.
 * Provides access to min/max quantities available for purchase.
 */
class ProductPriceHandler
{
    private $productPriceObj;

    public function __construct(Obj\ProductPrice $productPriceObj)
    {
        $this->productPriceObj = $productPriceObj;
    }

    public function getOriginalInstance()
    {
        return $this->productPriceObj;
    }

    /**
     * Returns the price amount set for
     * the ProductPrice configuration.
     * @return float
     */
    public function getAmount()
    {
        return (float)$this->getOriginalInstance()->Amount;
    }

    /**
     * Returns the Currency Code set for
     * the ProductPrice configuration.
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->getOriginalInstance()->Currency);
    }

    /**
     * Returns the Minimum quantity set for
     * the ProductPrice configuration.
     * @return integer
     */
    public function getMinQuantity()
    {
        return (int)$this->getOriginalInstance()->MinQuantity;
    }

    /**
     * Returns the Maximum quantity set for
     * the ProductPrice configuration.
     * @return integer
     */
    public function getMaxQuantity()
    {
        return (int)$this->getOriginalInstance()->MaxQuantity;
    }

    /**
     * Returns the Pricing Option Codes set
     * for the ProductPrice configuration.
     * @return array
     */
    public function getOptionCodes()
    {
        return $this->getOriginalInstance()->OptionCodes;
    }
}
