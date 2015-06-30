<?php
namespace AvangateSmartApiClient\ApiClient;

interface ProductApiClientResponseInterface
{
    public function getAvailableLanguages();
    public function getAvailableCurrencies();
    public function getAvailableCountries();
    public function getProductCrossSellCampaigns($productCode);
    public function getProductByCode($productCode);
    public function searchProducts(array $filters);
    public function searchPriceOptionGroups(\stdClass $filterObj);
    public function getCountryStates();
    public function getAdditionalOrderFields();
}