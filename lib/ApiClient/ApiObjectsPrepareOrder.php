<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Functions\SystemFunctions;
use AvangateSmartApiClient\Functions\UtilityFunctions;
use AvangateSmartApiClient\Order;

class ApiObjectsPrepareOrder
{
    protected $remoteOrderApiObj;
    protected $preparedOrderApiObj;

    protected $system;
    protected $functions;
    protected $orderFactory;

    public function __construct(\stdClass $remoteOrderApiObj)
    {
        $this->system = new SystemFunctions();
        $this->functions = new UtilityFunctions();
        $this->orderFactory = new Order\OrderFactory();

        $this->remoteOrderApiObj = $remoteOrderApiObj;
        $this->preparedOrderApiObj = $this->orderFactory->createOrderObj();

        $this->prepare();
    }

    protected function prepareGeneralDetails()
    {
        /**
         * General order details.
         */
        if (isset($this->remoteOrderApiObj->CartId) && !empty($this->remoteOrderApiObj->CartId)) {
            $this->preparedOrderApiObj->CartId = $this->remoteOrderApiObj->CartId;
        }
        if (isset($this->remoteOrderApiObj->Currency)) {
            $this->preparedOrderApiObj->Currency = $this->remoteOrderApiObj->Currency;
        }
        if (isset($this->remoteOrderApiObj->Language) && !empty($this->remoteOrderApiObj->Language)) {
            $this->preparedOrderApiObj->Language = $this->remoteOrderApiObj->Language;
        }
        if (isset($this->remoteOrderApiObj->Country) && !empty($this->remoteOrderApiObj->Country)) {
            $this->preparedOrderApiObj->Country = $this->remoteOrderApiObj->Country;
        }
        if (isset($this->remoteOrderApiObj->LocalTime) && !empty($this->remoteOrderApiObj->LocalTime)) {
            $this->preparedOrderApiObj->LocalTime = $this->remoteOrderApiObj->LocalTime;
        }
        if (isset($this->remoteOrderApiObj->Source) && !empty($this->remoteOrderApiObj->Source)) {
            $this->preparedOrderApiObj->Source = $this->remoteOrderApiObj->Source;
        }
        if (isset($this->remoteOrderApiObj->AffiliateSource) && !empty($this->remoteOrderApiObj->AffiliateSource)) {
            $this->preparedOrderApiObj->AffiliateSource = $this->remoteOrderApiObj->AffiliateSource;
        }
        if (isset($this->remoteOrderApiObj->ExternalReference) && !empty($this->remoteOrderApiObj->ExternalReference)) {
            $this->preparedOrderApiObj->ExternalReference = $this->remoteOrderApiObj->ExternalReference;
        }
        if (isset($this->remoteOrderApiObj->CustomerReference) && !empty($this->remoteOrderApiObj->CustomerReference)) {
            $this->preparedOrderApiObj->CustomerReference = $this->remoteOrderApiObj->CustomerReference;
        }
        if (isset($this->remoteOrderApiObj->Promotions)) {
            $this->preparedOrderApiObj->Promotions      = $this->remoteOrderApiObj->Promotions;
        }
        if (isset($this->remoteOrderApiObj->Origin) && !empty($this->remoteOrderApiObj->Origin)) {
            $this->preparedOrderApiObj->Origin = (float)$this->remoteOrderApiObj->Origin;
        }
        if (isset($this->remoteOrderApiObj->Errors)) {
            $this->preparedOrderApiObj->Errors = $this->remoteOrderApiObj->Errors;
        }
    }

    /**
     * Billing details.
     */
    public function prepareBillingDetails()
    {
        if (!isset($this->remoteOrderApiObj->BillingDetails) || $this->functions->count($this->remoteOrderApiObj->BillingDetails) == 0) {
            return false;
        }

        $newBillingDetails = $this->orderFactory->createBillingDetailsObj();
        foreach ($this->remoteOrderApiObj->BillingDetails as $key => $value) {
            $newBillingDetails->{$key} = $value;
        }

        $this->preparedOrderApiObj->BillingDetails = $newBillingDetails;
    }

    /*
     * Delivery details.
     */
    public function prepareDeliveryDetails()
    {
        if (isset($this->remoteOrderApiObj->DeliveryDetails) && !empty($this->remoteOrderApiObj->DeliveryDetails)) {
            $this->preparedOrderApiObj->DeliveryDetails = $this->remoteOrderApiObj->DeliveryDetails;
        }
    }

    /**
     * Payment details.
     */
    public function preparePaymentDetails()
    {
        if ($this->functions->count($this->remoteOrderApiObj->PaymentDetails) == 0) {
            return false;
        }

        $newPaymentDetailsObj = $this->orderFactory->createPaymentDetailsObj();

        foreach ($this->remoteOrderApiObj->PaymentDetails as $key => $value) {
            $newPaymentDetailsObj->{$key} = $value;
        }

        $newPaymentDetailsObj->PaymentMethod = null;

        if (isset($this->remoteOrderApiObj->PaymentDetails->PaymentMethod)) {
            switch ($this->remoteOrderApiObj->PaymentDetails->Type) {
                case 'TEST':
                case 'CC':
                    $newPaymentDetailsObj->PaymentMethod = $this->orderFactory->createPaymentMethodObj('CC');
                    foreach ($this->remoteOrderApiObj->PaymentDetails->PaymentMethod as $key => $value) {
                        $newPaymentDetailsObj->PaymentMethod->{$key} = $value;
                    }
                    break;

                case 'CCNOPCI':
                    $newPaymentDetailsObj->PaymentMethod = $this->orderFactory->createPaymentMethodObj('CCNOPCI');
                    foreach ($this->remoteOrderApiObj->PaymentDetails->PaymentMethod as $key => $value) {
                        $newPaymentDetailsObj->PaymentMethod->{$key} = $value;
                    }
                    break;

                case 'PAYPAL':
                    $newPaymentDetailsObj->PaymentMethod = $this->orderFactory->createPaymentMethodObj('Paypal');
                    foreach ($this->remoteOrderApiObj->PaymentDetails->PaymentMethod as $key => $value) {
                        $newPaymentDetailsObj->PaymentMethod->{$key} = $value;
                    }
                    break;
            }
        }

        $this->preparedOrderApiObj->PaymentDetails = $newPaymentDetailsObj;
    }

    /**
     * Customer details.
     */
    public function prepareCustomerDetails()
    {
        if (!isset($this->remoteOrderApiObj->CustomerDetails) || empty($this->remoteOrderApiObj->CustomerDetails)) {
            return false;
        }

        $newCustomerDetailsObj = $this->orderFactory->createCustomerDetailsObj();

        if ($this->functions->count($this->remoteOrderApiObj->CustomerDetails) > 0) {
            foreach ($this->remoteOrderApiObj->CustomerDetails as $key => $value) {
                $newCustomerDetailsObj->{$key} = $value;
            }
        }

        $this->preparedOrderApiObj->CustomerDetails = $newCustomerDetailsObj;
    }

    /**
     * Order totals.
     */
    public function prepareTotals()
    {
        $newTotals = $this->orderFactory->createOrderTotalsObj();

        if (isset($this->remoteOrderApiObj->Shipping)) {
            $newTotals->Shipping = (float)$this->remoteOrderApiObj->Shipping;
        }
        if (isset($this->remoteOrderApiObj->ShippingVAT)) {
            $newTotals->ShippingVAT = (float)$this->remoteOrderApiObj->ShippingVAT;
        }
        // Returned on 'push', not on 'finish'.
        if (isset($this->remoteOrderApiObj->NetPrice)) {
            $newTotals->NetPrice = (float)$this->remoteOrderApiObj->NetPrice;
        }
        // Returned on 'push', not on 'finish'.
        if (isset($this->remoteOrderApiObj->GrossPrice)) {
            $newTotals->GrossPrice = (float)$this->remoteOrderApiObj->GrossPrice;
        }
        // Returned on 'push', not on 'finish'.
        if (isset($this->remoteOrderApiObj->VAT)) {
            $newTotals->VAT = (float)$this->remoteOrderApiObj->VAT;
        }
        // Returned on 'push', not on 'finish'.
        if (isset($this->remoteOrderApiObj->AffiliateCommission)) {
            $newTotals->AffiliateCommission = (float)$this->remoteOrderApiObj->AffiliateCommission;
        }
        // returned on Update, not on Finish
        if (isset($this->remoteOrderApiObj->AvangateCommission)) {
            $newTotals->AvangateCommission  = (float)$this->remoteOrderApiObj->AvangateCommission;
        }
        // Returned on 'push', not on 'finish'.
        if (isset($this->remoteOrderApiObj->Discount)) {
            $newTotals->Discount = (float)$this->remoteOrderApiObj->Discount;
        }
        // Returned on 'push', not on 'finish'.
        if (isset($this->remoteOrderApiObj->NetDiscountedPrice)) {
            $newTotals->NetDiscountedPrice = (float)$this->remoteOrderApiObj->NetDiscountedPrice;
        }
        // Returned on 'push', not on 'finish'.
        if (isset($this->remoteOrderApiObj->GrossDiscountedPrice)) {
            $newTotals->GrossDiscountedPrice = (float)$this->remoteOrderApiObj->GrossDiscountedPrice;
        }

        // API doesn't have a Order->Totals key, but we
        // fake it inside our prepared object.
        $this->preparedOrderApiObj->Totals = $newTotals;

        // We need to copy the original values redundantly
        // in order to be compliant with a call to the original object from API.
        foreach ($newTotals as $val => $key) {
            $this->preparedOrderApiObj->{$val} = $key;
        }
    }

    public function prepareFinishSpecificDetails()
    {
        if (isset($this->remoteOrderApiObj->RefNo)) {
            $this->preparedOrderApiObj->RefNo = $this->remoteOrderApiObj->RefNo;
        }
        if (isset($this->remoteOrderApiObj->OrderNo)) {
            $this->preparedOrderApiObj->OrderNo = $this->remoteOrderApiObj->OrderNo;
        }
        if (isset($this->remoteOrderApiObj->ShopperRefNo)) {
            $this->preparedOrderApiObj->ShopperRefNo = $this->remoteOrderApiObj->ShopperRefNo;
        }
        if (isset($this->remoteOrderApiObj->Status)) {
            $this->preparedOrderApiObj->Status = $this->remoteOrderApiObj->Status;
        }
        if (isset($this->remoteOrderApiObj->ApproveStatus)) {
            $this->preparedOrderApiObj->ApproveStatus = $this->remoteOrderApiObj->ApproveStatus;
        }
        if (isset($this->remoteOrderApiObj->OrderDate)) {
            $this->preparedOrderApiObj->OrderDate = $this->remoteOrderApiObj->OrderDate;
        }
        if (isset($this->remoteOrderApiObj->FinishDate)) {
            $this->preparedOrderApiObj->FinishDate = $this->remoteOrderApiObj->FinishDate;
        }
        if (isset($this->remoteOrderApiObj->HasShipping)) {
            $this->preparedOrderApiObj->HasShipping = $this->remoteOrderApiObj->HasShipping;
        }
    }

    protected function prepareOrderItemObj(\stdClass $remoteOrderItemObj)
    {
        $orderItemObj                  = $this->orderFactory->createOrderItemObj();

        // $orderItemObj->PriceOptions = array(); // Not interested in this response.
        // $orderItemObj->AvangateId   = $ItemRemoteObj->AvangateId;
        $orderItemObj->Code            = $remoteOrderItemObj->Code;
        $orderItemObj->Quantity        = $remoteOrderItemObj->Quantity;
        $orderItemObj->Price           = $remoteOrderItemObj->Price;

        if (isset($remoteOrderItemObj->Promotion) && isset($remoteOrderItemObj->Promotion->Coupon)) {
            $orderItemObj->Promotion = $remoteOrderItemObj->Promotion->Coupon;
        }

        // Returned on 'push', not on 'finish'.
        if (isset($remoteOrderItemObj->CrossSell)) {
            $orderItemObj->CrossSell = $remoteOrderItemObj->CrossSell;
        }

        // Update the Prices.
        if (isset($remoteOrderItemObj->Price)) {
            $orderItemObj->Price = $this->prepareOrderItemTotalsObj($remoteOrderItemObj->Price);
        }

        // Update the Trials.
        if (isset($remoteOrderItemObj->Trial)) {
            $orderItemObj->Trial = $this->prepareOrderItemTrialTotalsObj($remoteOrderItemObj->Trial);
        }

        $orderItemObj->AdditionalFields = $remoteOrderItemObj->AdditionalFields;

        return $orderItemObj;
    }

    protected function prepareOrderItemTotalsObj(\stdClass $originalObj)
    {
        if (!isset($originalObj) || $this->functions->count($originalObj) == 0) {
            return null;
        }

        $newObj = $this->orderFactory->createOrderItemTotalsObj();
        foreach ($originalObj as $key => $value) {
            $newObj->{$key} = $value;
        }

        return $newObj;
    }

    protected function prepareOrderItemTrialTotalsObj(\stdClass $originalObj)
    {
        if (!isset($originalObj) || $this->functions->count($originalObj) == 0) {
            return null;
        }

        $newObj = $this->orderFactory->createOrderItemTrialTotalsObj();
        foreach ($originalObj as $key => $value) {
            $newObj->{$key} = $value;
        }

        return $newObj;
    }

    public function prepareOrderItems()
    {
        if (!isset($this->remoteOrderApiObj->Items) || $this->functions->count($this->remoteOrderApiObj->Items) == 0) {
            return false;
        }

        $this->preparedOrderApiObj->Items = array();

        foreach ($this->remoteOrderApiObj->Items as $remoteOrderItemObj) {
            $orderItem = $this->prepareOrderItemObj($remoteOrderItemObj);
            $this->preparedOrderApiObj->Items[] = $orderItem;
        }
    }

    /**
     * Convert the response into a CartFacade. Ignore the Items (must be processed using mapItems())
     * Store the mapped object into a local property ($this->orderModel)
     */
    protected function prepare()
    {
        $this->prepareOrderItems();
        $this->prepareGeneralDetails();
        $this->prepareBillingDetails();
        $this->prepareDeliveryDetails();
        $this->preparePaymentDetails();
        $this->prepareCustomerDetails();
        $this->prepareTotals();
    }

    /**
     * @return \stdClass
     */
    public function getOriginalInstance()
    {
        return $this->remoteOrderApiObj;
    }

    /**
     * @return Order\Obj\Order
     */
    public function getPreparedInstance()
    {
        return $this->preparedOrderApiObj;
    }

    /**
     * @return Order\OrderHandler
     */
    public function getHandlerInstance()
    {
        return $this->orderFactory->createOrderHandler($this->preparedOrderApiObj);
    }

}
