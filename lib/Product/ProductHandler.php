<?php
namespace AvangateSmartApiClient\Product;

use AvangateSmartApiClient\Functions\UtilityFunctions;
use AvangateSmartApiClient\Order\OrderConfig;

class ProductHandler
{
    protected $productObj;
    protected $orderConfig;
    protected $productFactory;
    protected $functions;

    public function __construct(Obj\Product $productObj, OrderConfig $orderConfig)
    {
        $this->productObj = $productObj;
        $this->orderConfig = $orderConfig;
        $this->productFactory = new ProductFactory();
        $this->functions = new UtilityFunctions();
    }

    public function getOriginalInstance()
    {
        return $this->productObj;
    }

    public function getOrderConfig()
    {
        return $this->orderConfig;
    }

    public function getProductFactory()
    {
        return $this->productFactory;
    }

    /**
     * Returns the Product ID
     * @deprecated
     * @return integer
     */
    public function getId()
    {
        return (int)$this->getOriginalInstance()->AvangateId;
    }

    /**
     * Returns the Product Code
     * @return string
     */
    public function getCode()
    {
        return $this->getOriginalInstance()->ProductCode;
    }

    /**
     * Returns the Product Name, based on the input language code
     * If no language code is provided, return fallback.
     * @param  string   $LanguageCode 2-letter uppercase Country code
     * @return string   Product Name
     */
    public function getName($LanguageCode = null)
    {
        if ($LanguageCode) {
            $LanguageCode = strtoupper($LanguageCode);
            if (isset($this->getOriginalInstance()->Translations->$LanguageCode->Name) && !empty($this->getOriginalInstance()->Translations->$LanguageCode->Name)) {
                return $this->getOriginalInstance()->Translations->$LanguageCode->Name;
            }
        }

        return $this->getOriginalInstance()->ProductName;
    }

    /**
     * Returns the Product Short Description, based on the input language code
     * If no language code is provided, return fallback.
     * @param  string   $LanguageCode 2-letter uppercase Country code
     * @return string   Product ShortDescription
     */
    public function getLongDescription($LanguageCode = null)
    {
        if ($LanguageCode) {
            $LanguageCode = strtoupper($LanguageCode);

            if (isset($this->getOriginalInstance()->Translations->$LanguageCode->LongDescription) && !empty($this->getOriginalInstance()->Translations->$LanguageCode->LongDescription)) {
                return $this->getOriginalInstance()->Translations->$LanguageCode->LongDescription;
            }
        }
        return $this->getOriginalInstance()->LongDescription;
    }

    /**
     * Returns the Product Long Description, based on the input language code
     * If no language code is provided, return fallback.
     * @param  string   $LanguageCode 2-letter uppercase Country code
     * @return string   Product Long Description
     */
    public function getShortDescription($LanguageCode = null)
    {
        if ($LanguageCode) {
            $LanguageCode = strtoupper($LanguageCode);

            if (isset($this->getOriginalInstance()->Translations->$LanguageCode->Description) && !empty($this->getOriginalInstance()->Translations->$LanguageCode->Description)) {
                return $this->getOriginalInstance()->Translations->$LanguageCode->Description;
            }
        }
        return $this->getOriginalInstance()->ShortDescription;
    }

    /**
     * Returns the product type (REGULAR or BUNDLE)
     *
     * @return string
     */
    public function getType()
    {
        return $this->getOriginalInstance()->ProductType;
    }

    /**
     * Returns the product version (if set)
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->getOriginalInstance()->ProductVersion;
    }

    /**
     * Return the product's images array<ProductImageHandler>
     * Will return false if no images are set.
     * @return bool|Image\ProductImageHandler[]
     */
    public function getImages()
    {
        $images = $this->getOriginalInstance()->ProductImages;
        if ($images && count($images)) {
            $result = array();

            foreach ($images as $imageObj) {
                $result[] = $this->getProductFactory()->createProductImageHandler($imageObj);
            }

            return $result;
        }

        return false;
    }

    /**
     * Return the product's default image
     * Will return false if no image is set.
     * @return bool|Image\ProductImageHandler
     */
    public function getDefaultImage()
    {
        $productImages = $this->getImages();

        if ($productImages) {
            foreach ($productImages as $productImageHandler) {
                if ($productImageHandler->isDefault()) {
                    return $productImageHandler;
                }
            }

            // If no images are set to default but there are images,
            // return first image handler.
            rsort($productImages);
            return end($productImages);
        }

        return false;
    }

    /**
     * Return the minimum allowed quantity for the product, based on the default configuration
     * @return integer
     */
    public function getMinimumQtyAllowed()
    {
        $PricingConfiguration = $this->getDefaultPricingConfiguration();
        return $PricingConfiguration->getMinQuantity();
    }

    /**
     * @return PricingConfiguration\PricingConfigurationHandler[]
     */
    public function getPricingConfigurations()
    {
        if (
            !isset($this->getOriginalInstance()->PricingConfigurations) ||
            !is_array($this->getOriginalInstance()->PricingConfigurations) ||
            count($this->getOriginalInstance()->PricingConfigurations) == 0
        ) {
            throw new Exception\RuntimeException('The item does not have any price configuration properties set on it.');
        }

        $handlers = [];
        foreach($this->getOriginalInstance()->PricingConfigurations as $PricingConfigurationObj) {
            $handlers[] = new PricingConfiguration\PricingConfigurationHandler($PricingConfigurationObj);
        }

        return $handlers;
    }


    /**
     * Returns the default or localized pricing option
     * @return PricingConfiguration\PricingConfigurationHandler|bool
     */
    public function getDefaultPricingConfiguration()
    {
        $default = false;
        $localized = false;

        $countryCode = $this->orderConfig->getDefaultCountry();

        if ($this->getPricingConfigurations()) {
            foreach ($this->getPricingConfigurations() as $PricingConfigurationHandler) {
                if ($PricingConfigurationHandler->isDefault()) {
                    $default = $PricingConfigurationHandler;
                }

                if (in_array($countryCode, $PricingConfigurationHandler->getBillingCountries())) {
                    $localized = $PricingConfigurationHandler;
                }
            }
        }

        $result = ($localized ? $localized : $default);

        if ($result && is_object($result)) {
            return $result;
        }

        throw new Exception\RuntimeException(
            sprintf('Product [%s] does not have a default pricing configuration set.', $this->getCode()),
            Exception\RuntimeException::NO_DEFAULT_PRICING_CONFIGURATION
        );
    }

    /**
     * Returns the PricingOptionsGroups for the current (default/localized) PricingConfiguration
     *
     * @return PricingOptionHandler
     */
    public function getPricingOptionsGroups()
    {
        $PriceOptionsApi = $this->getDefaultPricingConfiguration()->PriceOptions;

        if ($PriceOptionsApi) {
            $result = array();
            foreach ($PriceOptionsApi as $PriceOptionApiObj) {
                $result[] = new PricingOptionHandler($PriceOptionApiObj);
            }
            return $result;
        }

        return false;
    }

    /**
     * Generates a normalized array of pricing option codes
     *
     * @todo not mandatory, but good to know, this method
     * @todo Check/update/remove method -- for scales, the pricing option code is groupname-min-max but the selected option value should be groupname=value
     * @access public
     * return bool|array
     */
    public function getDefaultPricingOptionsCodesArray()
    {
        $PricingOptions = $this->getDefaultPricingOptions();

        $result = array();
        if ($PricingOptions && count($PricingOptions)) {
            foreach ($PricingOptions as $PricingOption) {
                $result[] = $PricingOption->getCode();
            }
            sort($result);

            return $result;
        }
        return false;
    }

    /**
     * Returns an array of PricingOptionModel set for the current pricing configuration
     * If no pricing option are set, will return false
     *
     * @return bool|\array<PricingOptionpModel>
     */
    public function getDefaultPricingOptions()
    {
        $allPricingOptions = $this->getPricingOptionsGroups();
        $result = array();

        if ($allPricingOptions && count($allPricingOptions)) {

            foreach ($allPricingOptions as $PricingOptionsGroupModel) {
                if ($PricingOptionsGroupModel->isRequired()) {

                    $PricingOptions = $PricingOptionsGroupModel->getOptions();

                    if ($PricingOptions && count($PricingOptions)) {
                        foreach ($PricingOptions as $PricingOption) {

                            if ($PricingOption->isDefault()) {
                                $result[] = $PricingOption;
                                break;
                            }
                        }
                    }

                }
            }

            return $result;
        }
        return false;
    }

    /**
     * Checks if the Product is enabled.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return ($this->instanceFromApi->Enabled == 1);
    }

    /**
     * Gets the AdditionalFields set for the Product
     *
     * @return array AdditionalFields API objects
     */
    public function getAdditionalFields()
    {
        if ($this->instanceFromApi->AdditionalFields && count($this->instanceFromApi->AdditionalFields)) {
            return $this->instanceFromApi->AdditionalFields;
        }

        return false;
    }

    /**
     * Checks if the ShippingClass is null or Electronic
     * Helper method for choosing to display trial form.
     *
     * @return boolean
     */
    public function noShippingClassForTrial()
    {
        return (is_null($this->instanceFromApi->ShippingClass) ||
            (isset($this->instanceFromApi->ShippingClass->Name) && $this->instanceFromApi->ShippingClass->Name == "Electronic"));
    }

    public function getTrialUrl($LanguageCode = null)
    {
        if ($LanguageCode) {
            $LanguageCode = strtoupper($LanguageCode);
            if (isset($this->instanceFromApi->Translations->$LanguageCode->TrialUrl) && !empty($this->instanceFromApi->Translations->$LanguageCode->TrialUrl)) {
                return $this->instanceFromApi->Translations->$LanguageCode->TrialUrl;
            }
        }

        return $this->instanceFromApi->TrialUrl;
    }

    public function getTrialDescription($LanguageCode = null)
    {
        if ($LanguageCode) {
            $LanguageCode = strtoupper($LanguageCode);
            if (isset($this->instanceFromApi->Translations->$LanguageCode->TrialDescription) && !empty($this->instanceFromApi->Translations->$LanguageCode->TrialDescription)) {
                return $this->instanceFromApi->Translations->$LanguageCode->TrialDescription;
            }
        }

        return $this->instanceFromApi->TrialDescription;
    }
}