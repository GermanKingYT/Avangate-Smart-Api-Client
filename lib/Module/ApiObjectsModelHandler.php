<?php
namespace AvangateSmartApiClient\Module;

class ApiObjectsModelHandler
{
    public function getLanguageByCode($languageCode){}
    public function getLanguages(){}
    public function getCurrencyByCode($languageCode){}
    public function getCurrencies(){}
    public function getCountryByCode($countryCode){}
    public function getCountries(){}
    public function getProductById($productId){}
    public function getProductByCode($productCode){}
    public function getProducts(){}
    public function getPricingOptionsGroupByCode($pricingOptionGroupCode){}
    public function getAdditionalFieldByCode($additionalFieldCode){}
    public function getOrderAdditionalFields(){}
    public function getProductCrossSellCampaigns($productCode){}
    public function getProductsWithCrossSellCampaigns(){}
    public function getCrossSellItems($masterProducts = array()){}
    public function getPaymentMethods(){}
}