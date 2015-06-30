<?php



    /**
     * Converts a stdClass with a stdClass structure into a CartItem Trial Object.
     *
     * @param Totals\Obj\CartItemTrial|\stdClass $CartItemTrialObj
     * @return Totals\Obj\CartItemTrial;
     */
    public function mapCartItemTrial($CartItemTrialObj = null)
    {
        $CartItemTrial = $this->totalsFactory->createTotalsCartItemTrialObj();

        if(isset($CartItemTrialObj->Period)){
            $CartItemTrial->Period = (int)$CartItemTrialObj->Period;
        }

        if(isset($CartItemTrialObj->Price)){
            $CartItemTrial->Price = (float)$CartItemTrialObj->Price;
        }

        if(isset($CartItemTrialObj->GrossPrice)){
            $CartItemTrial->GrossPrice = (float)$CartItemTrialObj->GrossPrice;
        }

        if(isset($CartItemTrialObj->NetPrice)){
            $CartItemTrial->NetPrice = (float)$CartItemTrialObj->NetPrice;
        }

        if(isset($CartItemTrialObj->VAT)){
            $CartItemTrial->VAT = (float)$CartItemTrialObj->VAT;
        }

        return $CartItemTrial;
    }

    /**
     * Converts a stdClass with a stdClass structure into a CartItem Totals Object.
     * Will enforce type casting (float / uppercase string).
     */
    public function mapOrderItemTotals(\stdClass $remoteOrderItemTotalsObj)
    {
        $orderItemTotals = $this->orderFactory->createOrderItemTotalsObj();

        if ($this->functions->count($remoteOrderItemTotalsObj) > 0) {
            foreach ($remoteOrderItemTotalsObj as $fieldName => $fieldValue) {
                $orderItemTotals->{$fieldName} = (float)$fieldValue;
            }
        }

        return $orderItemTotals;
    }

    /**
     * Converts a stdClass with a AdditionalField structure into an AdditionalField object
     *
     * @param  Order\Obj\AdditionalField|\stdClass $AdditionalFieldObj
     * @return Order\Obj\AdditionalField
     */
    public function mapAdditionalField($AdditionalFieldObj)
    {
        $AdditionalField = $this->orderFactory->createCartAdditionalFieldObj();

        if (isset($AdditionalFieldObj->Value)) {
            $AdditionalField->Value          = $AdditionalFieldObj->Value;
        }

        if (isset($AdditionalFieldObj->Code)) {
            $AdditionalField->Code           = $AdditionalFieldObj->Code;
        }

        if (isset($AdditionalFieldObj->Enabled)) {
            $AdditionalField->Enabled        = $AdditionalFieldObj->Enabled;
        }

        if (isset($AdditionalFieldObj->Required)) {
            $AdditionalField->Required       = $AdditionalFieldObj->Required;
        }

        if (isset($AdditionalFieldObj->URLParameter)) {
            $AdditionalField->URLParameter   = $AdditionalFieldObj->URLParameter;
        }

        if (isset($AdditionalFieldObj->Label)) {
            $AdditionalField->Label          = $AdditionalFieldObj->Label;
        }

        if (isset($AdditionalFieldObj->Type)) {
            $AdditionalField->Type           = $AdditionalFieldObj->Type;
        }

        if (isset($AdditionalFieldObj->ApplyTo)) {
            $AdditionalField->ApplyTo        = $AdditionalFieldObj->ApplyTo;
        }

        if (isset($AdditionalFieldObj->Values)) {
            $AdditionalField->Values         = $AdditionalFieldObj->Values;
        }

        if (isset($AdditionalFieldObj->ValidationRule)) {
            $AdditionalField->ValidationRule = $AdditionalFieldObj->ValidationRule;
        }

        if (isset($AdditionalFieldObj->Translations)) {
            $AdditionalField->Translations   = $AdditionalFieldObj->Translations;
        }

        return $AdditionalField;
    }

    /**
     * @todo adapt this after conversion to API 2_5 call for CrossSellCampaign
     * @todo apply Model / Handler logic (if needed)
     *
     * @param \stdClass $productCampaign
     * @param $ProductCode
     * @return Order\Obj\CrossSellCampaign
     */
    public function mapCampaignForProduct(\stdClass $productCampaign, $ProductCode)
    {
        $CrossSellCampaign = $this->orderFactory->createCartCrossSellCampaignObj();

        $CrossSellCampaign->DisplayType    = $productCampaign->DisplayType;
        $CrossSellCampaign->DisplayInEmail = (bool)$productCampaign->DisplayInEmail;
        $CrossSellCampaign->CampaignCode   = $productCampaign->CampaignCode;
        $CrossSellCampaign->Products       = array();
        $CrossSellCampaign->Name           = $productCampaign->Name;
        $CrossSellCampaign->StartDate      = $productCampaign->StartDate;
        $CrossSellCampaign->EndDate        = $productCampaign->EndDate;

        $CrossSellCampaign->ParentCode     = $ProductCode;

        $productsArray = $productCampaign->Products;
        foreach ($productsArray as $productsInCrossSell) {
            try {
                $ProductApiObj = $this->apiObjectsHandler->getProductByCode($productsInCrossSell->ProductCode);

                if ($ProductApiObj) {
                    $Item               = new Order\Obj\CrossSellItem;
                    $Item->ProductCode  = $ProductApiObj->ProductCode;
                    $Item->Discount     = $productsInCrossSell->Discount;
                    $Item->DiscountType = $productsInCrossSell->DiscountType;
                    $Item->ParentCode   = $ProductCode;
                    $Item->CampaignCode = $productCampaign->CampaignCode;

                    $CrossSellCampaign->Items[$ProductApiObj->ProductCode] = $Item;
                }
            } catch (Exception\RuntimeException $e){
                // This might be a different vendor cross sell product.
                // @todo: Log this exception.
            }

        }

        return $CrossSellCampaign;
    }

    /**
     * Converts a stdClass with a stdClass structure into a ProductTotals Object.
     * Will enforce type casting (float / uppercase string).
     */
    public function mapProductTotals($ProductTotalsObj)
    {
        $ProductTotals = $this->orderFactory->createTotalsProductObj();

        if (isset($ProductTotalsObj->Currency)) {
            $ProductTotals->Currency = strtoupper($ProductTotalsObj->Currency);
        }

        if (isset($ProductTotalsObj->Shipping)) {
            $ProductTotals->Shipping = (float)$ProductTotalsObj->Shipping;
        }

        if (isset($ProductTotalsObj->ShippingVAT)) {
            $ProductTotals->ShippingVAT = (float)$ProductTotalsObj->ShippingVAT;
        }

        if (isset($ProductTotalsObj->NetPrice)) {
            $ProductTotals->NetPrice = (float)$ProductTotalsObj->NetPrice;
        }

        if (isset($ProductTotalsObj->GrossPrice)) {
            $ProductTotals->GrossPrice = (float)$ProductTotalsObj->GrossPrice;
        }

        if (isset($ProductTotalsObj->VAT)) {
            $ProductTotals->VAT = (float)$ProductTotalsObj->VAT;
        }

        if (isset($ProductTotalsObj->AffiliateCommission)) {
            $ProductTotals->AffiliateCommission = (float)$ProductTotalsObj->AffiliateCommission;
        }

        if (isset($ProductTotalsObj->AvangateCommission)) {
            $ProductTotals->AvangateCommission = (float)$ProductTotalsObj->AvangateCommission;
        }

        if (isset($ProductTotalsObj->Discount)) {
            $ProductTotals->Discount = (float)$ProductTotalsObj->Discount;
        }

        if (isset($ProductTotalsObj->UnitNetPrice)){
            $ProductTotals->UnitNetPrice = (float)$ProductTotalsObj->UnitNetPrice;
        }

        if (isset($ProductTotalsObj->UnitGrossPrice)){
            $ProductTotals->UnitGrossPrice = (float)$ProductTotalsObj->UnitGrossPrice;
        }

        if (isset($ProductTotalsObj->UnitVAT)){
            $ProductTotals->UnitVAT = (float)$ProductTotalsObj->UnitVAT;
        }

        if (isset($ProductTotalsObj->UnitDiscount)){
            $ProductTotals->UnitDiscount = (float)$ProductTotalsObj->UnitDiscount;
        }

        if (isset($ProductTotalsObj->UnitNetDiscountedPrice)){
            $ProductTotals->UnitNetDiscountedPrice = (float)$ProductTotalsObj->UnitNetDiscountedPrice;
        }

        if (isset($ProductTotalsObj->UnitGrossDiscountedPrice)){
            $ProductTotals->UnitGrossDiscountedPrice = (float)$ProductTotalsObj->UnitGrossDiscountedPrice;
        }

        if (isset($ProductTotalsObj->UnitAffiliateCommission)){
            $ProductTotals->UnitAffiliateCommission = (float)$ProductTotalsObj->UnitAffiliateCommission;
        }

        if (isset($ProductTotalsObj->NetDiscountedPrice)){
            $ProductTotals->NetDiscountedPrice = (float)$ProductTotalsObj->NetDiscountedPrice;
        }

        if (isset($ProductTotalsObj->GrossDiscountedPrice)){
            $ProductTotals->GrossDiscountedPrice = (float)$ProductTotalsObj->GrossDiscountedPrice;
        }

        return $ProductTotals;
    }
