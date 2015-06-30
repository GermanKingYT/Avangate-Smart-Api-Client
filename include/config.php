<?php
$config = array(
    'api.client' => array(
        'order.url'   => 'http://sandbox19.avangate.local/api/order/2.5/rpc/',
        'product.url' => 'http://sandbox19.avangate.local/api/product/2.5/rpc/',
        'merchant.code' => 'SCSERBOE',
        'password'    => 'm^+T_4%FExA*p@iuK#[N'
    ),

    'order' => array(
        'default.currency' => 'EUR',
        'default.language' => 'EN',
        'default.country'  => 'RO'
    ),

    'storage.memcache' => array(
            'servers' => array(
                array('host' => 'mysqldev01.avangate.local', 'port' => 11211),
                array('host' => 'mysqldev02.avangate.local', 'port' => 11211)
            )
        ),
    'storage.file' => array(
            'path' => dirname(__FILE__) . '/../tmp/'
        ),

    // Expiration is in number of seconds.
    // Must not exceed 2592000 (30 days).
    'storage.expire' => array(
            'cartInstance'                     => 259200,
            'productApiClient_sessionId'       => 259200,
            'orderApiClient_sessionId'         => 259200,
            'language'                         => 259200,
            'merchantLanguages'                => 259200,
            'merchantAdditionalFields'         => 259200,
            'country'                          => 259200,
            'merchantCountries'                => 259200,
            'merchantStates'                   => 259200,
            'currency'                         => 259200,
            'merchantCurrencies'               => 259200,
            'productCrossSell'                 => 259200,
            'product'                          => 259200,
            'products'                         => 259200,
            'productAdditionalFields'          => 259200,
            'productPrices'                    => 259200,
            'priceOptionGroup'                 => 259200,
            'merchantPaymentMethods'           => 259200,
            'merchantPaymentMethodTypes'       => 259200,
            'merchantPaymentMethodsCurrencies' => 259200,
            'merchantPaymentMethodsCountries'  => 259200,
        )

    );

return $config;

