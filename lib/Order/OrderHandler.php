<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Functions\UtilityFunctions;
use AvangateSmartApiClient\Module\AbstractSubject;
use AvangateSmartApiClient\Module\ObserverInterface;

class OrderHandler extends AbstractSubject implements ObserverInterface
{
    protected $orderApiObj;
    protected $orderFactory;
    protected $functions;

    public function __construct(Obj\Order $orderApiObj)
    {
        $this->orderApiObj = $orderApiObj;
        $this->orderFactory = new OrderFactory();
        $this->functions = new UtilityFunctions();
    }

    /**
     * Returns the basic object instance.
     * @return Obj\Order
     */
    public function getOriginalInstance()
    {
        return $this->orderApiObj;
    }

    public function destroy()
    {
        $this->orderApiObj = null;
    }

    /**
     * Will return the basic instance after erasing the PaymentMethod data
     *
     * @return Obj\Order
     */
    public function getAnonymizedInstance()
    {
        $paymentType = $this->getPaymentDetails()->getType();

        if (!in_array($paymentType, array("CC", "TEST"))) {
            return $this->orderApiObj;
        }

        $instance = clone $this->orderApiObj;

        if (isset($instance->PaymentDetails->PaymentMethod)) {
            $instancePaymentDetails = clone $instance->PaymentDetails;

            $newPaymentDetails = $this->orderFactory->createPaymentDetailsObj();
            $newPaymentDetails->Currency = $instancePaymentDetails->Currency;
            $newPaymentDetails->Type = $instancePaymentDetails->Type;
            $newPaymentDetails->CustomerIP = $instancePaymentDetails->CustomerIP;

            if (isset($instancePaymentDetails->PaymentMethod->FirstDigits) && !is_null($instancePaymentDetails->PaymentMethod->FirstDigits)) {
                $newPaymentDetails->PaymentMethod = $this->orderFactory->createPaymentMethodObj('CC');
	            	$newPaymentDetails->PaymentMethod->FirstDigits = $instancePaymentDetails->PaymentMethod->FirstDigits;
	            	$newPaymentDetails->PaymentMethod->LastDigits =  $instancePaymentDetails->PaymentMethod->LastDigits;
	            } else {
                $newPaymentDetails->PaymentMethod = null;
            }

            $instance->PaymentDetails = $newPaymentDetails;
        }

        return $instance;
    }

    /**
     * Generates and sets the Cart Unique ID
     * @todo Generate truly random seed.
     */
    public function generateCartId()
    {
        $this->setCartId(time());
    }

    /**
     * Sets the Cart Unique ID
     * @param string|integer $CartId
     */
    public function setCartId($CartId)
    {
        $this->orderApiObj->CartId = $CartId;
    }

    /**
     * Gets the Cart Unique ID
     * @return int
     */
    public function getCartId()
    {
        return $this->orderApiObj->CartId;
    }

    /**
     * Return the current Country Code
     * @return string
     */
    public function getCountry()
    {
        return strtoupper($this->orderApiObj->Country);
    }

    /**
     * Store the current Country Code.
     * This method is for internal use only.
     * This method is overridden by setBillingCountry() when
     * dealing with the API request/response.
     *
     * @internal
     * @param string $countryCode
     */
    public function setCountry($countryCode)
    {
        $this->orderApiObj->Country = strtoupper($countryCode);
        $this->notify();
    }

    /**
     * Gets the Currency Code set to the cart instance
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->orderApiObj->Currency);
    }

    /**
     * Sets the Currency Code set for the cart instance.
     * @param $CurrencyCode
     */
    public function setCurrency($CurrencyCode)
    {
        $this->orderApiObj->Currency = strtoupper($CurrencyCode);
        $this->notify();
    }

    /**
     * Gets the Language Code set to the cart instance.
     * @return string
     */
    public function getLanguage()
    {
        return strtoupper($this->orderApiObj->Language);
    }

    /**
     * Sets the Language Code set for the cart instance.
     * @param $LanguageCode
     */
    public function setLanguage($LanguageCode)
    {
        $this->orderApiObj->Language = strtoupper($LanguageCode);
    }

    /**
     * Gets the Customer IP.
     * @return string
     */
    public function getCustomerIP()
    {
        return $this->orderApiObj->CustomerIP;
    }

    /**
     * This method is for internal use only.
     * This method is overridden by setPaymentCustomerIP() when
     * dealing with the API request/response.
     *
     * @param [type] $CustomerIP [description]
     */
    public function setCustomerIP($CustomerIP)
    {
        $this->orderApiObj->CustomerIP = $CustomerIP;
    }

    /**
     * The time that the user (that places the order) has on his machine.
     * The format must be YYYY-mm-dd HH:ii:ss
     * @param string $LocalTime
     */
    public function setLocalTime($LocalTime)
    {
        $this->orderApiObj->LocalTime = $LocalTime;
    }

    /**
     * Gets the Source set to the cart instance
     * @return string
     */
    public function getSource()
    {
        return $this->orderApiObj->Source;
    }

    /**
     * Sets the Source set for the cart instance
     * @param string $Source
     */
    public function setSource($Source)
    {
        $this->orderApiObj->Source = $Source;
    }

    /**
     * Append or update an Cart Item to the Cart
     * @param Item\OrderItemHandler $itemHandler
     */
    public function addItem($itemHandler)
    {
        $check = $this->checkItemByCode($itemHandler->getCode());
        if ($check !== false) {
            $ItemIndex = $check;
            $this->orderApiObj->Items[$ItemIndex] = $itemHandler->getOriginalInstance();
        } else {
            $this->orderApiObj->Items[] = $itemHandler->getOriginalInstance();
        }
    }

    public function deleteItemByCode($Code)
    {
        $Items = $this->getItems();

        if ($Items && count($Items)) {
            foreach ($Items as $ItemIndex => $ItemHandler) {
                if ($ItemHandler->getCode() == $Code) {
                    unset($this->getOriginalInstance()->Items[$ItemIndex]);

                    // reindex
                    $this->getOriginalInstance()->Items = array_values($this->getOriginalInstance()->Items);
                    $this->notify();

                    return true;
                }
            }
        }

        return false;
    }

    public function checkItemByCode($Code)
    {
        $Items = $this->getItems();

        if ($Items && count($Items)) {

            foreach ($Items as $ItemIndex => $ItemHandler) {
                if ($ItemHandler->getCode() == $Code) {
                    return (int)$ItemIndex;
                }
            }
        }
        return false;
    }

    public function getItem($Code)
    {
        $Items = $this->getItems();

        if ($Items && count($Items)) {
            foreach ($Items as $ItemHandler) {
                if ($ItemHandler->getCode() == $Code) {
                    return $ItemHandler;
                }
            }
        }

        throw new Exception\RuntimeException(
            sprintf('No product found by the code [%s].', $Code)
        );
    }

    /**
     * @return Item\OrderItemHandler[]|bool
     */
    public function getItems()
    {
        if (!$this->getOriginalInstance()->Items || !count($this->getOriginalInstance()->Items)) {
            return false;
        }

        $handlers = array();
        foreach ($this->getOriginalInstance()->Items as $ItemObj) {
            $handlers[] = $this->orderFactory->createOrderItemHandler($ItemObj);
        }

        return $handlers;
    }

    /**
     * @return array
     */
    public function getPromotions()
    {
        $orderPromotions = (array)$this->orderApiObj->Promotions;

        // copy promotions from cartItems
        if (count($this->orderApiObj->Items)) {
            foreach ($this->orderApiObj->Items as $cartItem) {
                $orderPromotions[] = $cartItem->Promotion;
            }
        }

        return array_values(array_unique(array_filter($orderPromotions)));
    }

    public function setPromotions($Promotions)
    {
        $Promotions = array_values(array_unique(array_filter((array)$Promotions)));
        $this->orderApiObj->Promotions = $Promotions;
        $this->notify();
    }

    public function addPromotion($CouponCode)
    {
        $Promotions = (array)$this->getPromotions();
        $Promotions[] = $CouponCode;
        $Promotions = array_unique($Promotions);

        $this->setPromotions($Promotions);
    }

    /**
     * @param Totals\Obj\Order $Totals
     */
    public function setTotals(Totals\Obj\Order $Totals)
    {
        $this->getOriginalInstance()->Totals = $Totals;

        // Make redundant copy due to incompatibility
        // with the API original object.
        foreach ($Totals as $key => $value) {
            $this->getOriginalInstance()->{$key} = $value;
        }
    }

    /**
     * @return Totals\TotalsHandler
     */
    public function getTotals()
    {
        return $this->orderFactory->createOrderTotalsHandler($this->getOriginalInstance()->Totals);
    }

    public function getDiscount()
    {
        return $this->getTotals()->getDiscount();
    }

    public function setDiscount($Discount)
    {
        $Totals = $this->getTotals()->getOriginalInstance();
        $Totals->Discount = (float)$Discount;

        $this->setTotals($Totals);
    }

    /**
     * Alias shortcut method.
     * @return \stdClass
     */
    public function getCommissions()
    {
        $Totals = $this->getTotals();

        $result = new \stdClass;
        $result->AffiliateCommission = $Totals->getAffiliateCommission();
        $result->AvangateCommission  = $Totals->getAvangateCommission();

        return $result;
    }

    /**
     * Alias shortcut method.
     * @param \stdClass $Commissions
     */
    public function setCommissions(\stdClass $Commissions)
    {
        $Totals = $this->getTotals()->getOriginalInstance();
        $Totals->AffiliateCommission = (float)$Commissions->AffiliateCommission;
        $Totals->AvangateCommission = (float)$Commissions->AvangateCommission;

        $this->setTotals($Totals);
    }

    /**
     * @param Obj\BillingDetails $BillingDetails
     */
    public function setBillingDetails(Obj\BillingDetails $BillingDetails)
    {
        $this->orderApiObj->BillingDetails = $BillingDetails;
    }

    /**
     * Factory method.
     * @return BillingDetailsHandler
     */
    public function getBillingDetails()
    {
        if (!isset($this->getOriginalInstance()->BillingDetails) || $this->functions->count($this->getOriginalInstance()->BillingDetails) == 0) {
            $billingDetailsObj = $this->orderFactory->createBillingDetailsObj();
        } else {
            $billingDetailsObj = $this->getOriginalInstance()->BillingDetails;
        }

        return $this->orderFactory->createBillingDetailsHandler($billingDetailsObj);
    }

    /**
     * @param Obj\DeliveryDetails $DeliveryDetails
     */
    public function setDeliveryDetails(Obj\DeliveryDetails $DeliveryDetails)
    {
        $this->orderApiObj->DeliveryDetails = $DeliveryDetails;
    }

    /**
     * Factory method.
     * @return DeliveryDetailsHandler
     */
    public function getDeliveryDetails()
    {
        if (!isset($this->getOriginalInstance()->DeliveryDetails) || $this->functions->count($this->getOriginalInstance()->DeliveryDetails) == 0) {
            $deliveryDetailsObj = $this->orderFactory->createDeliveryDetailsObj();
        } else {
            $deliveryDetailsObj = $this->getOriginalInstance()->DeliveryDetails;
        }

        return $this->orderFactory->createDeliveryDetailsHandler($deliveryDetailsObj);
    }

    /**
     * This is a smart and linked object, setters for this object
     * and will trigger the cart to update.
     */
    public function getPaymentDetails()
    {
        if (!isset($this->getOriginalInstance()->PaymentDetails) || $this->functions->count($this->getOriginalInstance()->PaymentDetails) == 0) {
            $paymentDetails = $this->orderFactory->createPaymentDetailsObj();
        } else {
            $paymentDetails = $this->getOriginalInstance()->PaymentDetails;
        }

        $handler = $this->orderFactory->createPaymentDetailsHandler($paymentDetails);
        $handler->attach($this);

        return $handler;
    }

    /**
     * @param Obj\CustomerDetails $customerDetailsObj
     */
    public function setCustomerDetails(Obj\CustomerDetails $customerDetailsObj)
    {
        $this->getOriginalInstance()->CustomerDetails = $customerDetailsObj;
    }

    /**
     * @return CustomerDetailsHandler
     */
    public function getCustomerDetails()
    {
        if (!isset($this->getOriginalInstance()->CustomerDetails) || $this->functions->count($this->getOriginalInstance()->CustomerDetails) == 0) {
            $customerDetailsObj = $this->orderFactory->createCustomerDetailsObj();
        } else {
            $customerDetailsObj = $this->getOriginalInstance()->CustomerDetails;
        }

        $handler = $this->orderFactory->createCustomerDetailsHandler($customerDetailsObj);
        $handler->attach($this);

        return $handler;
    }

    /**
     * @return Obj\AdditionalField[]|bool
     */
    public function getAdditionalFields()
    {
        if (isset($this->orderApiObj->AdditionalFields) && count($this->orderApiObj->AdditionalFields)) {
            return $this->orderApiObj->AdditionalFields;
        }

        return false;
    }

    /**
     * Set selected fields to Cart object.
     * Not using Models/Handlers or full AdditionalField object. This is similar to the ProductOptions.
     *
     * Input is associative array of AdditionalField Code => AdditionalField => Value/Values
     *
     * @param array $fields
     */
    public function setAdditionalFields($fields)
    {
        $AdditionalFields = array();

        if ($fields && count($fields)) {
            foreach ($fields as $additionalFieldCode => $additionalFieldValue) {
                if ($additionalFieldValue) {
                    $AdditionalFieldObj        = new Obj\AdditionalFieldSet;
                    $AdditionalFieldObj->Code  = $additionalFieldCode;
                    $AdditionalFieldObj->Value = $additionalFieldValue;

                    $AdditionalFields[] = $AdditionalFieldObj;
                }
            }
        }

        $this->orderApiObj->AdditionalFields = $AdditionalFields;
    }

    /**
     * @param string $RefNo
     */
    public function setRefNo($RefNo)
    {
        $this->getOriginalInstance()->RefNo = $RefNo;
    }

    /**
     * @return string|null
     */
    public function getRefNo()
    {
        return isset($this->getOriginalInstance()->RefNo) ? $this->getOriginalInstance()->RefNo : null;
    }

    /**
     * @param string $OrderNo
     */
    public function setOrderNo($OrderNo)
    {
        $this->getOriginalInstance()->OrderNo = $OrderNo;
    }

    /**
     * @return string|null
     */
    public function getOrderNo()
    {
        return isset($this->getOriginalInstance()->OrderNo) ? $this->getOriginalInstance()->OrderNo : null;
    }

    /**
     * @param string $ExternalReference
     */
    public function setExternalReference($ExternalReference)
    {
        $this->getOriginalInstance()->ExternalReference = $ExternalReference;
    }

    /**
     * @return null|string
     */
    public function getExternalReference()
    {
        return isset($this->getOriginalInstance()->ExternalReference) ? $this->getOriginalInstance()->ExternalReference : null;
    }

    /**
     * @param string $CustomerReference
     */
    public function setCustomerReference($CustomerReference)
    {
        $this->getOriginalInstance()->CustomerReference = $CustomerReference;
    }

    /**
     * @return null|string
     */
    public function getCustomerReference()
    {
        return isset($this->getOriginalInstance()->CustomerReference) ? $this->getOriginalInstance()->CustomerReference : null;
    }

    /**
     * @param string $ShopperRefNo
     */
    public function setShopperRefNo($ShopperRefNo)
    {
        $this->getOriginalInstance()->ShopperRefNo = $ShopperRefNo;
    }

    /**
     * @return null|string
     */
    public function getShopperRefNo()
    {
        return isset($this->getOriginalInstance()->ShopperRefNo) ? $this->getOriginalInstance()->ShopperRefNo : null;
    }

    /**
     * @param string $Status
     */
    public function setStatus($Status)
    {
        $this->getOriginalInstance()->Status = $Status;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return isset($this->getOriginalInstance()->Status) ? $this->getOriginalInstance()->Status : null;
    }

    /**
     * @param string $ApproveStatus
     */
    public function setApproveStatus($ApproveStatus)
    {
        $this->getOriginalInstance()->ApproveStatus = $ApproveStatus;
    }

    /**
     * @return string|null
     */
    public function getApproveStatus()
    {
        return isset($this->getOriginalInstance()->ApproveStatus) ? $this->getOriginalInstance()->ApproveStatus : null;
    }

    /**
     * @param string $OrderDate
     */
    public function setOrderDate($OrderDate)
    {
        $this->getOriginalInstance()->OrderDate = $OrderDate;
    }

    /**
     * @return string|null
     */
    public function getOrderDate()
    {
        return isset($this->getOriginalInstance()->OrderDate) ? $this->getOriginalInstance()->OrderDate : null;
    }

    /**
     * @param string $FinishDate
     */
    public function setFinishDate($FinishDate)
    {
        $this->getOriginalInstance()->FinishDate = $FinishDate;
    }

    /**
     * @return string|null
     */
    public function getFinishDate()
    {
        return isset($this->getOriginalInstance()->FinishDate) ? $this->getOriginalInstance()->FinishDate : null;
    }

    /**
     * @param string $HasShipping
     */
    public function setHasShipping($HasShipping)
    {
        $this->getOriginalInstance()->HasShipping = $HasShipping;
    }

    /**
     * @return null|string
     */
    public function getHasShipping()
    {
        return isset($this->getOriginalInstance()->HasShipping) ? $this->getOriginalInstance()->HasShipping : null;
    }

    /**
     * Will clear items from cart.
     * Must use CartFacade->save() to save in storage and CartFacade->push() to update prices.
     */
    public function clearItems()
    {
        $this->getOriginalInstance()->Items = array();
    }

    /**
     * Set errors object received from API response.
     *
     * @param object $Errors
     * @return  boolean
     */
    public function setErrors($Errors)
    {
        if (!isset($Errors) || is_null($Errors) || !is_object($Errors)) {
            return false;
        }

        $this->orderApiObj->Errors = $Errors;

        return true;
    }

    /**
     * Returns the raw errors object.
     * 'Errors' object is usually populated by an API response.
     */
    public function getErrors()
    {
        if(isset($this->getOriginalInstance()->Errors) && is_object($this->getOriginalInstance()->Errors)) {
            return $this->getOriginalInstance()->Errors;
        } else {
            return false;
        }
    }

    /**
     * @todo: Refactor this in API.
     * @param string $errorCode
     * @param string $errorMsg
     */
    public function setError($errorCode, $errorMsg)
    {
        if(empty($this->orderApiObj->Errors))
        {
            $this->orderApiObj->Errors = new \stdClass;
        }

        $this->orderApiObj->Errors->$errorCode = $errorMsg;
    }

    /**
     * @param string $errorCode
     * @return bool
     */
    public function getError($errorCode)
    {
        $errors = $this->getErrors();

        if (!$errors) {
            return false;
        }

        if (isset($errors->$errorCode)) {
            return $errors->$errorCode;
        } else {
            return false;
        }
    }

    public function clearErrors()
    {
        $this->getOriginalInstance()->Errors = null;
    }

    public function update(AbstractSubject $subject)
    {
        $instance = $subject->getOriginalInstance();

        if ($instance instanceof Item\Obj\OrderItem) {
            $this->notify();
            return true;
        }

        if ($instance instanceof Totals\Obj\Order) {
            $this->notify();
            return true;
        }

        if ($instance instanceof Obj\PaymentDetails) {
            $this->getOriginalInstance()->PaymentDetails = $instance;
            return true;
        }

        if ($instance instanceof Obj\CustomerDetails) {
            $this->getOriginalInstance()->CustomerDetails = $instance;
            return true;
        }

        return false;
    }
}
