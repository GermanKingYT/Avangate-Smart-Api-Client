<?php
namespace AvangateSmartApiClient\Storage;

use AvangateSmartApiClient\ApiClient;
use AvangateSmartApiClient\Functions\UtilityFunctions;
use AvangateSmartApiClient\Order;
use AvangateSmartApiClient\Product;

class StorageManager
{
    protected $storage;
    protected $apiClientManager;

    protected $functions;
    protected $productsFactory;
    protected $orderFactory;

    public function __construct(StorageAdapter $storage, ApiClient\ApiClientManager $apiClientManager)
    {
        $this->storage = $storage;
        $this->apiClientManager = $apiClientManager;

        $this->functions = new UtilityFunctions();
        $this->productFactory = new Product\ProductFactory();
        $this->orderFactory = new Order\OrderFactory();
    }

    public function getStorage()
    {
        return $this->storage;
    }

    public function getApiClientManager()
    {
        return $this->apiClientManager;
    }

    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * Process a product object that comes from API.
     *
     * @param \stdClass $product
     * @return boolean
     */
    protected function importProductObject(\stdClass $product)
    {
        // Don't include products without code.
        // This scenario appears on sandboxes where import/export scenarios were tested.
        if (!isset($product->ProductCode) || empty($product->ProductCode)) {
            return false;
        }

        // Returns an array of objects (cross sell campaigns).
        $productsCrossSell = $this->getApiClientManager()->getProductApiClient()->getProductCrossSellCampaigns($product->ProductCode);

        // Store an object with cross-sell campaigns per product.
        if ( $this->getFunctions()->count($productsCrossSell) > 0 ) {
            $this->getStorage()->set(sprintf('productCrossSell[%s]', $product->ProductCode), $productsCrossSell);
        }
        //////////////////////////////////////////////////////////////////////////////////////////

        // Store each product individually.
        $this->getStorage()->set(sprintf('product[%s]', $product->ProductCode), $product);

        // Store the default product price.
        // @todo: Remove this code and dependencies from ProductFactory or OrderConfig.
        $productModel    = $this->productFactory->createProductFacade($product);
        $productOptions  = $productModel->getDefaultPricingOptionsCodesArray();
        $productQuantity = $productModel->getMinimumQtyAllowed();

        $this->getProductPrice(
            $productModel->getCode(),
            $productQuantity,
            $productOptions,
            $this->orderConfig->getDefaultCurrency(),
            $this->orderConfig->getDefaultCountry(),
            null,
            null,
            null,
            null,
            false
        );

        return true;
    }

    /**
     * Import a single product from API.
     * This method is used on special occasions like the fallback to API object,
     * when the storage fails. In other cases you should use importProducts($filters).
     * @param $productCode
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    protected function importProduct($productCode)
    {
        if (empty($productCode)) {
            throw new Exception\InvalidArgumentException(
                'Invalid product code.',
                Exception\InvalidArgumentException::INVALID_PRODUCT_CODE
            );
        }

        // Returns an object (product).
        $product = $this->apiClientManager->getProductApiClient()->getProductByCode($productCode);

        if(is_object($product)){
            $this->importProductObject($product);
        } else {
            throw new Exception\RuntimeException(
                sprintf('Could not get product information from any of the sources. [%s]', $productCode),
                Exception\RuntimeException::NO_PRODUCT_FOUND
            );
        }
    }

    /**
     * Import products objects from the product API.
     * Note: The Avangate products without product codes will not be imported.
     *
     * Uses an optional filter array to extract the information from searchProducts.
     * If no parameters are set, the number of products will default to 10.
     *
     * Example:
     * <code>
     * <?php
     * $filters = array(
     *     'Name'               => 'Product Name',
     *     'Status'             => 'ENABLED',
     *     'NetworkCrosselling' => false,
     *     'Type'               => 'REGULAR',
     *     'Category'           => null,
     *     'Gift'               => null,
     *     'Limit'              => 10,      // limit from API
     *     'Page'               => 1        // limit from API
     * );
     * ?>
     * </code>
     *
     * @param array $filters
     * @return int
     * @throws Exception\RuntimeException
     */
    public function importProducts($filters = array())
    {
        $recordCount = 0;

        if (!isset($filters['Limit'])) {
            $filters['Limit'] = 1000;
        }

        if (!isset($filters['Page'])) {
            $filters['Page'] = 1;
        }

        // Always import enabled products.
        // @todo: Discuss this feature. For the moment it causes problems with getPrice and getProductByCode
        $filters['Enabled'] = true;

        // Docs: https://backend.avangate.com/cpanel/help.php?view=topic&topic=439#searchProducts
        // Returns an array of objects (products).
        $products = $this->apiClientManager->getProductApiClient()->searchProducts($filters);

        //echo __METHOD__ . ': ' . is_array($products) . "\n";

        if ($this->functions->count($products) == 0) {
            throw new Exception\RuntimeException(
                'No products found, check your filters or if the vendor has products.',
                Exception\RuntimeException::NO_PRODUCTS_FOUND
            );
        }

        $productCodes = array();
        foreach ($products as $product) {
            $import = $this->importProductObject($product);
            if($import){
                $productCodes[] = $product->ProductCode;
                $recordCount++;
            }
        }

        // Store an array with all the product codes.
        $this->storage->set('products', $productCodes);

        return $recordCount;
    }

    public function importProductsAdditionalFields()
    {
        $recordCount = 0;

        // Get the product list.
        $products            = $this->storage->get('products');
        $allAdditionalFields = $this->storage->get('merchantAdditionalFields');

        if (empty($products) || $this->functions->count($products) == 0) {
            throw new Exception\RuntimeException(
                'There are no products imported in the storage.',
                Exception\RuntimeException::NO_PRODUCTS_IMPORTED
            );
        }

        if ($this->functions->count($allAdditionalFields) > 0) {
            // For each product attempt to import additional fields (if found).
            foreach ($products as $productCode) {
                $productModel = $this->getProductByCode($productCode);
                //$productAdditionalFields = Module::productApiClient()->call_getAssignedAdditionalOrderFields($productCode);

                $productAdditionalFieldsModels = $productModel->getAdditionalFields();
                if ($productAdditionalFieldsModels) {
                    // Format the result (by code). To be easy to fetch from storage.
                    $result = new \stdClass;

                    foreach ($productAdditionalFieldsModels as $productAdditionalFieldsModel) {
                        $additionalFieldCode          = $productAdditionalFieldsModel->getCode();
                        $result->$additionalFieldCode = $productAdditionalFieldsModel->getInstance()->getInstanceFromApi();
                        $recordCount++;
                    }

                    $this->storage->set(sprintf('productAdditionalFields[%s]', $productCode), $result);
                }
            }
        }

        return $recordCount;
    }

    public function importPriceOptionGroups($filter = array())
    {
        $recordCount = 0;
        /**
         * @see https://backend.avangate.com/cpanel/help.php?view=topic&topic=439#searchPriceOptionGroups
         */
        $filterObj        = new \stdClass;
        $filterObj->Name  = isset($filter['Name']) ? $filter['Name'] : null;
        $filterObj->Types = isset($filter['Types']) ? $filter['Types'] : null;//RADIO, CHECKBOX, INTERVAL, COMBO, INTERVAL
        $filterObj->Limit = isset($filter['Limit']) ? $filter['Limit'] : null;
        $filterObj->Page  = isset($filter['Page']) ? $filter['Page'] : null;

        $priceOptionGroups = $this->apiClientManager->getProductApiClient()->searchPriceOptionGroups($filterObj);

        if ($this->functions->count($priceOptionGroups) > 0) {
            foreach ($priceOptionGroups as $priceOptionGroup) {
                $this->storage->set(sprintf('priceOptionGroup[%s]', $priceOptionGroup->Code), $priceOptionGroup);
                $recordCount++;
            }
            return $recordCount;
        } else {
            return 0;
            //throw new \Exception('Importing price option groups has failed: ' . Module::productApiClient()->getLastError()->getCode());
            // @todo: Log this exception.
        }
    }

    /**
     * @return int
     * @throws Exception\RuntimeException
     */
    public function importLanguages()
    {
        $recordCount = 0;
        // Returns an array of objects (languages).
        $languages = $this->getApiClientManager()->getProductApiClient()->getAvailableLanguages();

        if ($this->getFunctions()->count($languages) == 0) {
            throw new Exception\RuntimeException(
                'Could not find any languages for the current vendor.',
                Exception\RuntimeException::NO_LANGUAGES_FOUND
            );
        }

        // Store individual languages.
        foreach ($languages as $language) {
            $this->getStorage()->set(sprintf('language[%s]', strtoupper($language->code)), $language);
            $recordCount++;
        }

        // Store an array of objects with all the languages.
        $this->getStorage()->set('merchantLanguages', $languages);

        return $recordCount;
    }

    /**
     * @return int
     */
    public function importCountries()
    {
        $recordCount = 0;
        // Returns an array of objects (countries).
        $countries = $this->apiClientManager->getProductApiClient()->getAvailableCountries();

        if ($this->functions->count($countries) == 0) {
            throw new Exception\RuntimeException(
                'Could not find any countries for the current vendor.',
                Exception\RuntimeException::NO_COUNTRIES_FOUND
            );
        }

        // Store individual countries.
        foreach ($countries as $country) {
            $this->storage->set(sprintf('country[%s]', strtoupper($country->code)), $country);
            $recordCount++;
        }

        // Store an array of objects with all the countries.
        $this->storage->set('merchantCountries', $countries);

        return $recordCount;
    }

    /**
     * We already know the countries that have states.
     * This is important for API fallback in ApiHandler::getCountryStatesByCountryCode()
     *
     * @return int
     */
    public function importStates()
    {
        $recordCount = 0;
        // Countries with known states in Avangate.
        $countriesWithStates = array(
            'br',
            'ca',
            'fr',
            'mh',
            'us',
            'ro'
        );

        $result = new \stdClass;

        // For each know country to have states, get the list of states.
        foreach ($countriesWithStates as $CountryCode) {
            // Returns an array of objects (states).
            $tmpStates = $this->apiClientManager->getProductApiClient()->getCountryStates($CountryCode);
            //echo __METHOD__ . ': ' . is_array($tmpStates) . "\n";
            //print_r($tmpStates);
            //echo "\n";
            // Check if states exist.
            if ($this->functions->count($tmpStates) > 0) {
                $CountryCode = strtoupper($CountryCode);
                $result->{$CountryCode} = $tmpStates;
                $recordCount++;
            }
        }

        if ($recordCount > 0) {
            // Store an object with the country --> states relationship in storage.
            $this->storage->set('merchantStates', $result);
        }

        return $recordCount;
    }

    /**
     * @return int
     */
    public function importCurrencies()
    {
        $recordCount = 0;
        // Returns an array of objects (currencies).
        $currencies = $this->apiClientManager->getProductApiClient()->getAvailableCurrencies();

        if ($this->functions->count($currencies) == 0) {
            throw new Exception\RuntimeException(
                'Could not find any currencies for the current vendor.',
                Exception\RuntimeException::NO_CURRENCIES_FOUND
            );
        }

        // Store individual currencies.
        foreach ($currencies as $currency) {
            $this->storage->set(sprintf('currency[%s]', strtoupper($currency->code)), $currency);
            $recordCount++;
        }

        // Store an array of objects with all the currencies.
        $this->storage->set('merchantCurrencies', $currencies);

        return $recordCount;
    }

    /**
     * @return int
     */
    public function importPaymentMethods()
    {
        // Returns an array payment methods codes.
        $paymentMethods = $this->apiClientManager->getOrderApiClient()->getPaymentMethods();

        if ($this->functions->count($paymentMethods) == 0) {
            throw new Exception\RuntimeException(
                'No payment methods found.',
                Exception\RuntimeException::NO_PAYMENT_METHODS_FOUND
            );
        }

        $this->storage->set('merchantPaymentMethods', $paymentMethods);
        return (int)$this->functions->count($paymentMethods);
    }

    /**
     * @return int
     */
    public function importPaymentMethodsTypes()
    {
        // For the moment the only known payment types are for the CC payment option.
        $paymentMethodTypes = array('VISA', 'VISAELECTRON', 'MASTERCARD', 'MAESTRO', 'AMEX', 'DISCOVER', 'DANKORT', 'CARTEBLEUE');
        $this->storage->set('merchantPaymentMethodTypes[CC]', $paymentMethodTypes);
        $this->storage->set('merchantPaymentMethodTypes[CCNOPCI]', $paymentMethodTypes);

        return (int)count($paymentMethodTypes);
    }

    /**
     * @param bool $CanFallbackToAPI
     * @return int
     */
    public function importPaymentMethodsCurrencies($CanFallbackToAPI = true)
    {
        $recordCount = 0;
        $paymentMethods = $this->storage->get('merchantPaymentMethods');

        // Payment methods's currencies depend on existing payment methods.
        // We need to make sure at this point that we have $paymentMethods filled.
        if ($this->functions->count($paymentMethods) == 0 && $CanFallbackToAPI) {
            $this->importPaymentMethods();
            return $this->importPaymentMethodsCurrencies(false);
        }

        if ($this->functions->count($paymentMethods) > 0) {
            $result = new \stdClass;
            foreach ($paymentMethods as $paymentMethodCode) {
                // Returns an array with currencies codes.
                $foundCurrencies = $this->apiClientManager->getOrderApiClient()->getPaymentMethodCurrencies($paymentMethodCode);
                //echo __METHOD__ . ': ' . is_array($foundCurrencies) . "\n";
                //print_r($foundCurrencies);
                //echo "\n";
                $foundCurrencies = array_map('strtoupper', $foundCurrencies);
                $result->{$paymentMethodCode} = $foundCurrencies;
                $recordCount++;
            }

            // Store an object with payment method --> currencies relationship.
            $this->storage->set('merchantPaymentMethodsCurrencies', $result);
        }

        return $recordCount;
    }

    /**
     * @return int
     */
    public function importPaymentMethodsCountries()
    {
        $recordCount = 0;
        $paymentMethods = $this->storage->get('merchantPaymentMethods');

        if ($this->functions->count($paymentMethods) > 0) {
            $result = new \stdClass;
            foreach($paymentMethods as $paymentMethodCode){
                // Returns an array with countries codes.
                $foundCountries = $this->apiClientManager->getOrderApiClient()->getPaymentMethodCountries($paymentMethodCode);
                //echo __METHOD__ . ': ' . is_array($foundCountries) . "\n";
                //print_r($foundCountries);
                //echo "\n";
                $foundCountries = array_map('strtoupper', $foundCountries);
                $result->{$paymentMethodCode} = $foundCountries;
                $recordCount++;
            }

            // Store an object with the payment methods --> countries relationship.
            $this->storage->set('merchantPaymentMethodsCountries', $result);
        }

        return $recordCount;
    }

    /**
     * @return int
     */
    public function importAdditionalFields()
    {
        $recordCount = 0;
        // Returns an array with order additional fields.
        $fields = $this->apiClientManager->getProductApiClient()->getAdditionalOrderFields();

        if ($this->functions->count($fields) > 0) {
            // Store all additional fields by code.
            $result = new \stdClass;
            foreach ($fields as $field) {
                $result->{$field->Code} = $field;
                $recordCount++;
            }
            unset($fields);

            // Store an object with order additional fields.
            $this->storage->set('merchantAdditionalFields', $result);
        }
        return $recordCount;
    }

    /**
     * @param $languageCode
     * @param bool $CanFallbackOverAPI
     * @return \stdClass
     */
    public function getLanguageByCode($languageCode, $CanFallbackOverAPI = true)
    {
        $merchantLanguages = $this->getLanguages();

        if ($merchantLanguages && $this->functions->count($merchantLanguages) > 0) {
            foreach ($merchantLanguages as $language) {
                if (strtoupper($language->code) == strtoupper($languageCode)) {
                    return $language;
                }
            }
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importLanguages();
            return $this->getLanguageByCode($languageCode, false);
        }

        throw new Exception\RuntimeException(
            sprintf('Could not get language information for code [%s].', $languageCode),
            Exception\RuntimeException::NO_LANGUAGE_FOUND
        );
    }

    /**
     * @param bool $CanFallbackOverAPI
     * @return \stdClass[]
     */
    public function getLanguages($CanFallbackOverAPI = true)
    {
        // Local static cache.
        //if (!empty(self::$merchantLanguages)) {
        //    return self::$merchantLanguages;
        //}

        // Local storage cache.
        $merchantLanguages = $this->storage->get('merchantLanguages');

        if ($merchantLanguages) {
            // initialize
            //self::$merchantLanguages = $merchantLanguages;
            return $merchantLanguages;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importLanguages();
            return $this->getLanguages(false);
        }

        throw new Exception\RuntimeException(
            'Could not get available languages from any of the sources.',
            Exception\RuntimeException::NO_LANGUAGES_FOUND
        );
    }

    /**
     * @param $currencyCode
     * @param bool $CanFallbackOverAPI
     * @return \stdClass
     */
    public function getCurrencyByCode($currencyCode, $CanFallbackOverAPI = true)
    {
        $merchantCurrencies = $this->getCurrencies();

        foreach ($merchantCurrencies as $Currency) {
            if (strtoupper($Currency->code) == strtoupper($currencyCode)) {
                return $Currency;
            }
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importCurrencies();
            return $this->getCurrencyByCode($currencyCode, false);
        }

        throw new Exception\RuntimeException(
            sprintf('Could not get currency information from code [%s].', $currencyCode),
            Exception\RuntimeException::NO_CURRENCY_FOUND
        );
    }

    /**
     * @param bool $CanFallbackOverAPI
     * @return \stdClass[]
     */
    public function getCurrencies($CanFallbackOverAPI = true)
    {
        // Local static cache.
        //if (!empty(self::$merchantCurrencies)) {
        //    return self::$merchantCurrencies;
        //}

        // Local storage cache
        $merchantCurrencies = $this->storage->get('merchantCurrencies');
        if ($merchantCurrencies) {
            // initialize
            //self::$merchantCurrencies = $merchantCurrencies;
            return $merchantCurrencies;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importCurrencies();
            return $this->getCurrencies(false);
        }

        throw new Exception\RuntimeException(
            'Could not get available currencies from any of the sources.',
            Exception\RuntimeException::NO_CURRENCIES_FOUND
        );
    }

    /**
     * @param $countryCode
     * @param bool $CanFallbackOverAPI
     * @return \stdClass
     */
    public function getCountryByCode($countryCode, $CanFallbackOverAPI = true)
    {
        $merchantCountries = $this->getCountries();
        foreach ($merchantCountries as $Country) {
            if (strtoupper($Country->code) == strtoupper($countryCode)) {
                $Country->states = $this->getCountryStatesByCountryCode($Country->code);
                return $Country;
            }
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importCountries();
            return $this->getCountryByCode($countryCode, false);
        }

        throw new Exception\RuntimeException(
            sprintf('Could not get country information from country code [%s].', $countryCode),
            Exception\RuntimeException::NO_COUNTRY_FOUND
        );
    }

    /**
     * @param bool $CanFallbackOverAPI
     * @return \stdClass[]
     */
    public function getCountries($CanFallbackOverAPI = true)
    {
        // Local static cache.
        //if (!empty(self::$merchantCountries)) {
        //    return self::$merchantCountries;
        //}

        // Local storage cache
        $merchantCountries = $this->storage->get('merchantCountries');
        if ($merchantCountries) {
            if (count($merchantCountries)) {
                foreach ($merchantCountries as $key => $Country) {
                    $merchantCountries[$key]->states = $this->getCountryStatesByCountryCode($Country->code);
                }
            }
            // initialize
            //self::$merchantCountries = $merchantCountries;
            return $merchantCountries;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importCountries();
            return $this->getCountries(false);
        }

        throw new Exception\RuntimeException(
            'Could not get available countries from any of the sources.',
            Exception\RuntimeException::NO_COUNTRIES_FOUND
        );
    }

    /**
     * @param $countryCode
     * @param bool $CanFallbackOverAPI
     * @return bool|\stdClass[]
     */
    public function getCountryStatesByCountryCode($countryCode, $CanFallbackOverAPI = true)
    {
        if (empty($countryCode)) {
            throw new Exception\InvalidArgumentException(
                'Please provide a valid country code.',
                Exception\InvalidArgumentException::INVALID_COUNTRY_CODE
            );
        }

        $countryCode = strtoupper($countryCode);

        // Local static cache.
        $states = $this->storage->get('merchantStates');

        if (is_object($states) && isset($states->{$countryCode})) {
            return $states->{$countryCode};
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI == true && !$states) {
            $this->importStates();
            return $this->getCountryStatesByCountryCode($countryCode, false);
        }

        // This is not critical, don't need exception here.
        return false;
    }

    /**
     * @param $productId
     * @return bool|\stdClass
     */
    public function getProductById($productId)
    {
        $products = $this->getProducts();

        if ($products && count($products)) {
            foreach ($products as $product) {
                if (isset($product->AvangateId) && $product->AvangateId == $productId) {
                    return $product;
                }
            }
        }

        return false;
    }

    /**
     * Gets product's raw API object.
     * @param $productCode
     * @param bool $CanFallbackOverAPI
     * @return \stdClass
     */
    public function getProductByCode($productCode, $CanFallbackOverAPI = true)
    {
        if (empty($productCode)) {
            throw new Exception\InvalidArgumentException(
                'Please provide a valid product code.',
                Exception\InvalidArgumentException::INVALID_PRODUCT_CODE
            );
        }

        // Local static cache.
        //if (!empty(self::$products[$productCode])) {
        //    return self::$products[$productCode];
        //}

        // Local storage cache.
        $product = $this->storage->get(sprintf('product[%s]', $productCode));
        if (!empty($product)) {
            //self::$products[$productCode] = $product;
            return $product;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importProduct($productCode);
            return $this->getProductByCode($productCode, false);
        }

        throw new Exception\RuntimeException(
            sprintf('Could not get product [%s] information from any of the sources.', $productCode),
            Exception\RuntimeException::NO_PRODUCT_FOUND
        );
    }

    /**
     * @return \stdClass[]
     */
    public function getProducts()
    {
        $results = array();

        // Local storage cache.
        $products = $this->getProductCodes();

        if ($products && is_array($products) && !empty($products)) {
            foreach ($products as $productCode) {
                $product = $this->getProductByCode($productCode);
                $results[$productCode] = $product;
            }

            return $results;
        }

        return $results;
    }

    /**
     * @param bool $CanFallbackOverAPI
     * @return array|bool
     */
    public function getProductCodes($CanFallbackOverAPI = true)
    {
        $products = $this->storage->get('products');
        if (is_array($products) && !empty($products)) {
            return $products;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importProducts(array(/* ? */));
            return $this->getProductCodes(false);
        }

        return false;
    }

    /**
     * @param $pricingOptionsGroupCode
     * @return bool|\stdClass
     */
    public function getPricingOptionsGroupByCode($pricingOptionsGroupCode)
    {
        $pricingOptionsGroupCode = trim($pricingOptionsGroupCode);

        if (empty($pricingOptionsGroupCode)) {
            return false;
        }

        // Local static cache.
        //if (!empty($pricingOptionsGroupCode) && !empty(self::$pricingOptionsGroups[$pricingOptionsGroupCode])) {
        //    return self::$pricingOptionsGroups[$pricingOptionsGroupCode];
        //}

        // Local storage cache
        $PricingOptionGroupDetails = $this->storage->get(sprintf('priceOptionGroup[%s]', $pricingOptionsGroupCode));
        if ($PricingOptionGroupDetails) {
            // initialize
            //self::$pricingOptionsGroups[$pricingOptionsGroupCode] = $PricingOptionGroupDetails;
            return $PricingOptionGroupDetails;
        }

        // Fallback. Check the remote storage (API).
        $this->importPriceOptionGroups();

        $PricingOptionGroupDetails = $this->storage->get(sprintf('priceOptionGroup[%s]', $pricingOptionsGroupCode));
        if ($PricingOptionGroupDetails) {
            // initialize
            //self::$pricingOptionsGroups[$pricingOptionsGroupCode] = $PricingOptionGroupDetails;
            return $PricingOptionGroupDetails;
        }

        throw new Exception\RuntimeException(
            sprintf('Could not get PricingOptionGroupDetails information from any of the sources. [%s]', $pricingOptionsGroupCode),
            Exception\RuntimeException::NO_PRICING_OPTION_GROUP_FOUND
        );
    }

    /**
     * @param $productCode
     * @param int $ProductQty
     * @param array $PriceOptions
     * @param string $CurrencyCode
     * @param string $CountryCode
     * @param null $StateLabel
     * @param null $CouponCode
     * @param null $CrossSellCampaignCode
     * @param null $CrossSellParentCode
     * @param bool $SearchInStorageFirst
     * @return \stdClass
     */
    public function getProductPrice($productCode, $ProductQty = 1, $PriceOptions = array(), $CurrencyCode = "", $CountryCode = "", $StateLabel = null, $CouponCode = null, $CrossSellCampaignCode = null, $CrossSellParentCode = null, $SearchInStorageFirst = true)
    {
        $hash = $this->functions->generateHash($productCode, $ProductQty, $PriceOptions, $CurrencyCode, $CountryCode, $StateLabel, $CouponCode, $CrossSellCampaignCode, $CrossSellParentCode);

        // Search in local Storage, if not found call API.
        if ($SearchInStorageFirst) {
            $result = $this->storage->get(sprintf('productPrices[%s]', $hash));

            if ($this->functions->count($result) > 0) {
                //$ProductTotalsObj = $this->apiObjectsMapHandler->mapProductTotals($result);
                //return $this->totalsFactory->createTotalsProductModel($ProductTotalsObj);
                return $result;
            }
        }

        //$cartItem               = $this->orderFactory->createCartItemObj();
        $cartItem               = new \stdClass();
        $cartItem->Code         = $productCode;
        $cartItem->Quantity     = $ProductQty;
        $cartItem->PriceOptions = $PriceOptions;

        if (!is_null($CrossSellCampaignCode) && !is_null($CrossSellParentCode)) {
            $cartItem->CrossSell = new \stdClass;
            $cartItem->CrossSell->CampaignCode = $CrossSellCampaignCode;
            $cartItem->CrossSell->ParentCode   = $CrossSellParentCode;
        }

        $BillingDetails          = new \stdClass;
        $BillingDetails->Country = $CountryCode;
        $BillingDetails->State   = $StateLabel;

        // @todo: Throw an exception here!
        $result = $this->apiClientManager->getOrderApiClient()->getPrice($cartItem, $BillingDetails, $CurrencyCode, $CouponCode);

        if (!empty($result)) {
            $this->storage->set(sprintf('productPrices[%s]', $hash), $result);
        }

        //$ProductTotalsObj = $this->apiObjectsMapHandler->mapProductTotals($result);
        //return $this->totalsFactory->createTotalsProductModel($ProductTotalsObj);
        return $result;
    }

    /**
     * @param $additionalFieldCode
     * @return \stdClass
     */
    public function getAdditionalFieldByCode($additionalFieldCode)
    {
        $merchantAdditionalFields = $this->getAdditionalFields();

        if ($merchantAdditionalFields && count($merchantAdditionalFields)) {
            foreach ($merchantAdditionalFields as $AdditionalFieldStdObj) {
                if (strtoupper($AdditionalFieldStdObj->Code) == strtoupper($additionalFieldCode)) {
                    //$AdditionalField = $this->apiObjectsMapHandler->mapAdditionalField($AdditionalFieldStdObj);
                    return $AdditionalFieldStdObj;
                }
            }
        }

        throw new Exception\RuntimeException(
            sprintf('Could not get additional field information from code.', $additionalFieldCode),
            Exception\RuntimeException::NO_ADDITIONAL_FIELD_FOUND
        );
    }

    public function getAdditionalFields($CanFallbackOverAPI = true)
    {
        // Local static cache.
        //if (!empty(self::$merchantAdditionalFields)) {
        //    return self::$merchantAdditionalFields;
        //}

        // Local storage cache
        $merchantAdditionalFields = $this->storage->get('merchantAdditionalFields');
        if ($merchantAdditionalFields) {
            // initialize
            //self::$merchantAdditionalFields = $merchantAdditionalFields;
            return $merchantAdditionalFields;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importAdditionalFields();
            return $this->getAdditionalFields(false);
        }

        return array();
    }

    /**
     * @return \stdClass[]
     */
    public function getOrderAdditionalFields()
    {
        $result = array();

        $merchantAdditionalFields = $this->getAdditionalFields();
        if (count($merchantAdditionalFields)) {
            foreach ($merchantAdditionalFields as $AdditionalFieldStdObj) {
                if ($AdditionalFieldStdObj->ApplyTo == 'ORDER') {
                    //$result[] = $this->apiObjectsMapHandler->mapAdditionalField($AdditionalFieldStdObj);
                    $result[] = $AdditionalFieldStdObj;
                }
            }
        }

        return $result;
    }

    /**
     * @param $productCode
     * @return bool|int
     */
    public function hasProductCrossSellCampaigns($productCode)
    {
        if (empty($productCode)) {
            throw new Exception\InvalidArgumentException(
                'Invalid product code provided.',
                Exception\InvalidArgumentException::INVALID_PRODUCT_CODE
            );
        }

        $productCrossSellCampaigns = $this->storage->get(sprintf('productCrossSell[%s]', $productCode));

        if (!$productCrossSellCampaigns) {
            $product = $this->storage->get(sprintf('product[%s]', $productCode));

            // Fallback. Check the remote storage (API).
            // Note: we import all products.
            if (!$product) {
                $this->importProduct($productCode);
                $productCrossSellCampaigns = $this->storage->get(sprintf('productCrossSell[%s]', $productCode));
            }
        }

        return ($productCrossSellCampaigns ? count((array)$productCrossSellCampaigns) : false);
    }

    /**
     * @param $productCode
     * @return bool|\stdClass[]
     */
    public function getProductCrossSellCampaignsByCode($productCode)
    {
        if (empty($productCode)) {
            throw new Exception\InvalidArgumentException(
                'Invalid product code provided.',
                Exception\InvalidArgumentException::INVALID_PRODUCT_CODE
            );
        }

        $productCrossSellCampaigns = $this->storage->get(sprintf('productCrossSell[%s]', $productCode));

        if (!$productCrossSellCampaigns) {
            $product = $this->storage->get(sprintf('product[%s]', $productCode));

            // Fallback. Check the remote storage (API).
            if (!$product) {
                $this->importProduct($productCode);
                $productCrossSellCampaigns = $this->storage->get(sprintf('productCrossSell[%s]', $productCode));
            }
        }

        if ($this->functions->count($productCrossSellCampaigns) > 0) {
            return $productCrossSellCampaigns;
            //foreach ($productCrossSellCampaigns as $key => $productCrossSellCampaign) {
                //$return[] = $this->apiObjectsMapHandler->mapCampaignForProduct($productCrossSellCampaign, $productCode);
            //}
        } else {
            return false;
        }
    }

    /**
     * @param bool $CanFallbackOverAPI
     * @return bool|mixed
     */
    public function getPaymentMethods($CanFallbackOverAPI = true)
    {
        $paymentMethods = $this->storage->get('merchantPaymentMethods');

        if ($paymentMethods && count($paymentMethods)) {
            return $paymentMethods;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI) {
            $this->importPaymentMethods();
            return $this->getPaymentMethods(false);
        }

        return false;
    }

    /**
     * @param $paymentMethodTypeCode
     * @param bool $CanFallbackOverAPI
     * @return bool|mixed
     */
    public function getPaymentMethodTypes($paymentMethodTypeCode, $CanFallbackOverAPI = true)
    {
        $paymentMethodTypes = $this->storage->get(sprintf('merchantPaymentMethodTypes[%s]', $paymentMethodTypeCode));

        if ($paymentMethodTypes && count($paymentMethodTypes)) {
            return $paymentMethodTypes;
        }

        // Fallback. Check the remote storage (API).
        if ($CanFallbackOverAPI == true && !$paymentMethodTypes) {
            $this->importPaymentMethodsTypes();
            return $this->getPaymentMethodTypes($paymentMethodTypeCode, false);
        }

        return false;
    }

    /**
     * @param Order\OrderHandler $cartHandler
     * @return \stdClass
     */
    public function pushOrder(Order\OrderHandler $cartHandler)
    {
        if (!($cartHandler instanceof Order\OrderHandler)) {
            throw new Exception\InvalidArgumentException(
                'Invalid object passed.',
                Exception\InvalidArgumentException::INVALID_CART_HANDLER_PASSED
            );
        }

        $cartId = $cartHandler->getCartId();

        if (empty($cartId)) {
            throw new Exception\InvalidArgumentException(
                'Empty cart id passed.',
                Exception\InvalidArgumentException::EMPTY_CART_ID_PASSED
            );
        }

        $cartApiObj = $this->storage->get(sprintf('cartInstance[%s]', $cartId));

        if (!$cartApiObj) {
            throw new Exception\RuntimeException(
                'Cart instance not found in the storage.',
                Exception\RuntimeException::CART_INSTANCE_NOT_FOUND
            );
        }

        $cartInstance = $cartHandler->getInstanceFromApi();

        // @todo: Move this to ApiObjectsMapHandler
        if (isset($cartInstance->PaymentDetails->PaymentMethod)) {
            $cartApiObj->PaymentDetails->PaymentMethod = $cartInstance->PaymentDetails->PaymentMethod;
        }

        $result = $this->apiClientManager->getOrderApiClient()->getContents($cartApiObj);
        return $result;
    }

    /**
     * @param Order\OrderHandler $cartHandler
     * @return \stdClass
     */
    public function finishOrder(Order\OrderHandler $cartHandler)
    {
        if (!($cartHandler instanceof Order\OrderHandler)) {
            throw new Exception\InvalidArgumentException(
                'Invalid object passed.',
                Exception\InvalidArgumentException::INVALID_CART_HANDLER_PASSED
            );
        }

        $cartId = $cartHandler->getCartId();

        if (empty($cartId)) {
            throw new Exception\InvalidArgumentException(
                'Empty cart id passed.',
                Exception\InvalidArgumentException::EMPTY_CART_ID_PASSED
            );
        }

        $cartApiObj = $this->storage->get(sprintf('cartInstance[%s]', $cartId));

        if (!$cartApiObj) {
            throw new Exception\RuntimeException(
                'Cart instance not found in the storage.',
                Exception\RuntimeException::CART_INSTANCE_NOT_FOUND
            );
        }

        $cartInstance = $cartHandler->getInstanceFromApi();

        // @todo: Move this to ApiObjectsMapHandler
        if (isset($cartInstance->PaymentDetails->PaymentMethod)) {
            $cartApiObj->PaymentDetails->PaymentMethod = $cartInstance->PaymentDetails->PaymentMethod;
        }

        $result = $this->apiClientManager->getOrderApiClient()->placeOrder($cartApiObj);
        return $result;
    }


    public function destroyOrder($cartId)
    {
        if (empty($cartId) || (int)$cartId <= 0) {
            throw new Exception\InvalidArgumentException(
                'Cannot destroy the cart, invalid cart id provided.',
                Exception\InvalidArgumentException::EMPTY_CART_ID_PASSED
            );
        }

        return $this->storage->delete(sprintf('cartInstance[%s]', $cartId));
    }
}