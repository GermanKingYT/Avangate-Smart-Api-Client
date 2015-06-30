<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Product;
use AvangateSmartApiClient\Functions\UtilityFunctions;

class ApiObjectsPrepareProduct
{
    protected $remoteProductApiObj;
    protected $preparedProductApiObj;

    protected $productFactory;
    protected $functions;

    public function __construct(\stdClass $remoteProductApiObj)
    {
        $this->remoteProductApiObj = $remoteProductApiObj;
        $this->productFactory = new Product\ProductFactory();
        $this->functions = new UtilityFunctions();

        $this->preparedOrderApiObj = $this->productFactory->createProductObj();
    }

    protected function prepareGeneralDetails()
    {
        if (isset($this->remoteProductApiObj->AvangateId)) {
           $this->preparedProductApiObj->AvangateId = $this->remoteProductApiObj->AvangateId;
        }
        if (isset($this->remoteProductApiObj->ProductCode)) {
            $this->preparedProductApiObj->ProductCode = $this->remoteProductApiObj->ProductCode;
        }
        if (isset($this->remoteProductApiObj->ProductType)) {
            $this->preparedProductApiObj->ProductType = $this->remoteProductApiObj->ProductType;
        }
        if (isset($this->remoteProductApiObj->ProductName)) {
            $this->preparedProductApiObj->ProductName = $this->remoteProductApiObj->ProductName;
        }
        if (isset($this->remoteProductApiObj->ProductVersion)) {
            $this->preparedProductApiObj->ProductVersion = $this->remoteProductApiObj->ProductVersion;
        }
        if (isset($this->remoteProductApiObj->GroupName)) {
            $this->preparedProductApiObj->GroupName = $this->remoteProductApiObj->GroupName;
        }
        if (isset($this->remoteProductApiObj->ShippingClass)) {
            $this->preparedProductApiObj->ShippingClass = $this->remoteProductApiObj->ShippingClass;
        }
        if (isset($this->remoteProductApiObj->GiftOption)) {
            $this->preparedProductApiObj->GiftOption = $this->remoteProductApiObj->GiftOption;
        }
        if (isset($this->remoteProductApiObj->ShortDescription)) {
            $this->preparedProductApiObj->ShortDescription = $this->remoteProductApiObj->ShortDescription;
        }
        if (isset($this->remoteProductApiObj->LongDescription)) {
            $this->preparedProductApiObj->LongDescription = $this->remoteProductApiObj->LongDescription;
        }
        if (isset($this->remoteProductApiObj->SystemRequirements)) {
            $this->preparedProductApiObj->SystemRequirements = $this->remoteProductApiObj->SystemRequirements;
        }
        if (isset($this->remoteProductApiObj->ProductCategory)) {
            $this->preparedProductApiObj->ProductCategory = $this->remoteProductApiObj->ProductCategory;
        }
        if (isset($this->remoteProductApiObj->Platforms)) {
            $this->preparedProductApiObj->Platforms = $this->remoteProductApiObj->Platforms;
        }
        if (isset($this->remoteProductApiObj->ProductImages)) {
            $this->preparedProductApiObj->ProductImages = $this->remoteProductApiObj->ProductImages;
        }
        if (isset($this->remoteProductApiObj->TrialUrl)) {
            $this->preparedProductApiObj->TrialUrl = $this->remoteProductApiObj->TrialUrl;
        }
        if (isset($this->remoteProductApiObj->TrialDescription)) {
            $this->preparedProductApiObj->TrialDescription = $this->remoteProductApiObj->TrialDescription;
        }
        if (isset($this->remoteProductApiObj->Enabled)) {
            $this->preparedProductApiObj->Enabled = $this->remoteProductApiObj->Enabled;
        }
        if (isset($this->remoteProductApiObj->AdditionalFields)) {
            $this->preparedProductApiObj->AdditionalFields = $this->remoteProductApiObj->AdditionalFields;
        }
        if (isset($this->remoteProductApiObj->BundleProducts)) {
            $this->preparedProductApiObj->BundleProducts = $this->remoteProductApiObj->BundleProducts;
        }
        if (isset($this->remoteProductApiObj->Fulfillment)) {
            $this->preparedProductApiObj->Fulfillment = $this->remoteProductApiObj->Fulfillment;
        }
        if (isset($this->remoteProductApiObj->GeneratesSubscription)) {
            $this->preparedProductApiObj->GeneratesSubscription = $this->remoteProductApiObj->GeneratesSubscription;
        }
    }

    protected function prepareTranslations()
    {

    }

    protected function preparePricingConfigurations()
    {
        if (!isset($this->remoteProductApiObj->PricingConfigurations) || count($this->remoteProductApiObj->PricingConfigurations) == 0) {
            return false;
        }

        $newPricingConfigurations = [];
        foreach ($this->remoteProductApiObj->PricingConfigurations as $PricingConfigurationObj) {
            $newPricingConfigurations[] = $this->preparePricingConfigurationObj($PricingConfigurationObj);
        }
    }

    protected function preparePricingConfigurationObj(\stdClass $pricingConfiguration)
    {
        $newPricingConfiguration = $this->productFactory->createPricingConfigurationObj();
        $newPricingConfiguration->Name = $pricingConfiguration->Name;
        $newPricingConfiguration->Default = $pricingConfiguration->Default;
        $newPricingConfiguration->BillingCountries = $pricingConfiguration->BillingCountries;
        $newPricingConfiguration->PricingSchema = $pricingConfiguration->PricingSchema;
        $newPricingConfiguration->PriceType = $pricingConfiguration->PriceType;
        $newPricingConfiguration->DefaultCurrency = $pricingConfiguration->DefaultCurrency;
        $newPricingConfiguration->Prices = $pricingConfiguration->Prices;
        $newPricingConfiguration->PriceOptions = $pricingConfiguration->PriceOptions;

        return $newPricingConfiguration;
    }

}