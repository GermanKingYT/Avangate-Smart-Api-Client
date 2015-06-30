<?php
namespace AvangateSmartApiClient\Product\PricingConfiguration;

use AvangateSmartApiClient\Product\Price;

class PricingConfigurationHandler
{
    private $pricingConfigurationObj;

    public function __construct(Obj\PricingConfiguration $pricingConfigurationObj)
    {
        $this->pricingConfigurationObj = $pricingConfigurationObj;
    }

    public function getOriginalInstance()
    {
        return $this->pricingConfigurationObj;
    }

    /**
     * Get PricingConfiguration Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->getOriginalInstance()->Name;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return isset($this->getOriginalInstance()->Default) && $this->getOriginalInstance()->Default ? true : false;
    }

    /**
     * Returns an array of Country Codes.
     * Returns an empty array if all Countries are allowed for this PricingConfiguration
     *
     * @return array
     */
    public function getBillingCountries()
    {
        return isset($this->getOriginalInstance()->BillingCountries) ? $this->getOriginalInstance()->BillingCountries : [];
    }

    /**
     * Return the Price type (NET | GROSS)
     */
    public function getPriceType()
    {
        if (in_array($this->getOriginalInstance()->PriceType, array('GROSS', 'NET'))) {
            return $this->getOriginalInstance()->PriceType;
        }

        throw new Exception\RuntimeException(
            sprintf('Configuration has an invalid price type [%s].', $this->getOriginalInstance()->PriceType)
        );
    }

    /**
     * Return the default currency set for the PricingConfiguration
     *
     * @return string CurrencyCode
     */
    public function getDefaultCurrency()
    {
        return $this->getOriginalInstance()->DefaultCurrency;
    }

    /**
     * Returns the ProductPrices associated for the PricingConfiguration
     *
     * @param  string  $PurchaseType    Regular, Renewal, Upgrade
     * @param  string  $CurrencyCode
     * @return bool|array
     */
    public function getPrices($PurchaseType = 'Regular', $CurrencyCode = "")
    {
        if (isset($this->getOriginalInstance()->Prices->$PurchaseType)) {
            $Prices = $this->getOriginalInstance()->Prices->$PurchaseType;

            if ($Prices && count($Prices)) {
                $result = array();
                foreach ($Prices as $Price) {
                    if ($CurrencyCode == $Price->Currency) {
                        $result[] = new Price\ProductPriceHandler($Price);
                    }
                }

                if (count($result)) {
                    return $result;
                }
            }
        }

        return false;
    }

    /**
     * Returns an object containing
     * the MinQuantity and MaxQuantity for the PricingConfiguration.
     * @return stdClass
     */
    public function getAllowedQuantities()
    {
        // Scanning for MIN and MAX volume quantity.
        // The PurchaseType doesn't matter here.
        $PurchaseType = 'Regular';
        $Prices = $this->getOriginalInstance()->Prices->$PurchaseType;

        // Format the default output result.
        $result = new \stdClass;
        $result->MinQuantity = 1;
        $result->MaxQuantity = 99999;

        if ($Prices) {

            $qty = array();
            foreach ($Prices as $Price) {
                $qty['min'][] = (int)$Price->MinQuantity;
                $qty['max'][] = (int)$Price->MaxQuantity;
            }

            $result->MinQuantity = min($qty['min']);
            $result->MaxQuantity = max($qty['max']);

        }

        return $result;
    }

    /**
     * Returns the Minimum quantity set for the PricingConfiguration.
     *
     * @return integer
     */
    public function getMinQuantity()
    {
        $result = $this->getAllowedQuantities();
        return $result->MinQuantity;
    }

    /**
     * Returns the Maximum quantity set for the PricingConfiguration.
     *
     * @return integer
     */
    public function getMaxQuantity()
    {
        $result = $this->getAllowedQuantities();
        return $result->MaxQuantity;
    }
}
