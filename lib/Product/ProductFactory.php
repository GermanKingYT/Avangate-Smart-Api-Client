<?php
namespace AvangateSmartApiClient\Product;

use AvangateSmartApiClient\Product\PricingConfiguration;
use AvangateSmartApiClient\Product\PricingOptionsGroup;

class ProductFactory
{
    public function createProductImageHandler(Image\Obj\ProductImage $imageObj)
    {
        return new Image\ProductImageHandler($imageObj);
    }

    public function createProductObj()
    {
        return new Obj\Product();
    }

    public function createPricingConfigurationObj()
    {
        return new PricingConfiguration\Obj\PricingConfiguration();
    }

    public function createPricingOptionsOption(PricingOptionsGroup\PricingOption\Obj\PricingOption $pricingOptionObj)
    {

    }
}