<?php
namespace AvangateSmartApiClient\Order\Item;

use AvangateSmartApiClient\ApiClient\Exception\RequestException;
use AvangateSmartApiClient\Module\AbstractSubject;
use AvangateSmartApiClient\Module\ObserverInterface;
use AvangateSmartApiClient\Functions;

class OrderItemHandler extends AbstractSubject implements ObserverInterface
{
    private $orderItemObj;

    /**
     * @param Obj\OrderItem $orderItemObj
     */
    public function __construct(Obj\OrderItem $orderItemObj)
    {
        $this->orderItemObj = $orderItemObj;
    }

    /**
     * @return Obj\OrderItem
     */
    public function getOriginalInstance()
    {
        return $this->orderItemObj;
    }

    public function getId()
    {
        return $this->getOriginalInstance()->AvangateId;
    }

    public function setId($Id)
    {
        $this->getOriginalInstance()->AvangateId = $Id;
    }

    public function getCode()
    {
        return $this->getOriginalInstance()->Code;
    }

    public function setCode($Code)
    {
        $this->getOriginalInstance()->Code = $Code;
    }

    public function getQuantity()
    {
        return (int)$this->getOriginalInstance()->Quantity;
    }

    public function setQuantity($Quantity = 0)
    {
        $this->getOriginalInstance()->Quantity = $Quantity;
    }

    public function setPromotion($CouponCode = null)
    {
        $this->getOriginalInstance()->Promotion = $CouponCode;
    }

    public function getPromotion()
    {
        if (isset($this->getOriginalInstance()->Promotion) && !empty($this->getOriginalInstance()->Promotion)) {
            return $this->getOriginalInstance()->Promotion;
        }

        return false;
    }

    public function setPrice(Totals\Obj\TotalsObj $Price)
    {
        $this->getOriginalInstance()->Price = $Price;
    }

    /**
     * @return Totals\TotalsHandler
     * @throws Exception\RuntimeException
     */
    public function getPrice()
    {
        if (
            !isset($this->getOriginalInstance()->Price) ||
            !($this->getOriginalInstance()->Price instanceof Totals\Obj\TotalsObj)
        ) {
            throw new Exception\RuntimeException('The item does not have any price properties set on it.');
        }

        $handler = new Totals\TotalsHandler($this->getOriginalInstance()->Price);
        $handler->attach($this);
        return $handler;

    }

    /**
     * @return Totals\TrialTotalsHandler
     * @throws Exception\RuntimeException
     */
    public function getTrial()
    {
        if (
            !isset($this->getOriginalInstance()->Trial) ||
            !($this->getOriginalInstance()->Trial instanceof Totals\Obj\TrialTotalsObj)
        ) {
            throw new Exception\RuntimeException('The item does not have any trial properties set on it.');
        }

        $handler = new Totals\TrialTotalsHandler($this->getOriginalInstance()->Trial);
        $handler->attach($this);
        return $handler;
    }

    /**
     * Check if the Item has Trial set on it.
     * @return boolean
     */
    public function hasTrial()
    {
        return (
            isset($this->getOriginalInstance()->Trial) &&
            ($this->getOriginalInstance()->Trial instanceof Totals\Obj\TrialTotalsObj) &&
            !is_null($this->getTrial()->getPrice()) &&
            !is_null($this->getTrial()->getPeriod())
        );
    }

    /**
     * Get AdditionalFieldSet obj set to the CartItem
     * Will have typecast protection (will convert objects to AdditionalFieldSet).
     * @todo Generate a cart instance and test.
     * @return Obj\AdditionalFieldSet[]
     */
    public function getAdditionalFields()
    {
        if ($this->getOriginalInstance()->AdditionalFields && !empty($this->getOriginalInstance()->AdditionalFields)) {
            $results = $this->getOriginalInstance()->AdditionalFields;
            $resultsObj = array();

            foreach ($results as $additionalFieldObject) {

                if ($additionalFieldObject instanceof Obj\AdditionalFieldSet) {
                    $resultsObj[] = $additionalFieldObject;

                } else {

                    $additionalFieldObjectMapped        = new Obj\AdditionalFieldSet;
                    $additionalFieldObjectMapped->Code  = $additionalFieldObject->Code;
                    $additionalFieldObjectMapped->Value = $additionalFieldObject->Value;

                    $resultsObj[] = $additionalFieldObjectMapped;
                }
            }

            return $resultsObj;
        }

        return false;
    }

    /**
     * Get AdditionalFields Models set to the CartItem
     * Will set current CartItem's settings to the corresponding AdditionalField
     *
     * @return array
     */
    /*
    public function getAdditionalFields()
    {
        $AFICartItemList = $this->instanceFromApiHandler->getAdditionalFields();
        $AFProductList = $this->getProduct()->getAdditionalFields();

        $result = array();

        if ($AFICartItemList && count($AFICartItemList) && $AFProductList && count($AFProductList)) {

            // build indexer to match AF codes
            $Indexer = array();
            foreach ($AFProductList as $key => $AFProductModel) {
                $Indexer[$key] = $AFProductModel->getCode();
            }

            foreach ($AFICartItemList as $key => $value) {
                $index = array_search($value->Code, $Indexer);

                // double-check
                if ($AFProductList[$index]->getCode() == $value->Code) {
                    $AFProductList[$index]->setSelectedValues($value->Value);

                    $result[] = $AFProductList[$index];
                }
            }
        }

        return (count($result)) ? $result : false;
    }
    */

    /**
     * Set selected fields to CartItem object.
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

        $this->getOriginalInstance()->AdditionalFields = $AdditionalFields;
    }

    public function getOptions()
    {
        $OptionsCodes = $this->getOriginalInstance()->PriceOptions;

        if (count($OptionsCodes) && $OptionsCodes) {
            $result = array();
            $allProductPricingOptionsAsArray = array();
            $allProductPricingOptionsScalesAsArray = array();
            $allProductPricingOptionsGroups = $this->getProduct()->getPricingOptionsGroups();

            if ($allProductPricingOptionsGroups && count($allProductPricingOptionsGroups)) {
                foreach ($allProductPricingOptionsGroups as $PricingOptionsGroupModel) {
                    $ProductOptions = $PricingOptionsGroupModel->getOptions();
                    if ($ProductOptions && count($ProductOptions)) {
                        foreach ($ProductOptions as $ProductOption) {
                            if ($PricingOptionsGroupModel->getType() == "INTERVAL") {
                                if (!isset($allProductPricingOptionsScalesAsArray[$PricingOptionsGroupModel->getCode()])) {
                                    $allProductPricingOptionsScalesAsArray[$PricingOptionsGroupModel->getCode()] = array();
                                }
                                $allProductPricingOptionsScalesAsArray[$PricingOptionsGroupModel->getCode()][] = $ProductOption;
                            } else {
                                $allProductPricingOptionsAsArray[$ProductOption->getCode()] = $ProductOption;
                            }
                        }
                    }
                }
            }

            foreach ($OptionsCodes as $key => $OptionCode) {
                if (strpos($OptionCode, '=')) {
                    // scale
                    $OptionDetails = explode('=', $OptionCode);
                    $OptionCode = $OptionDetails[0];
                    $OptionValue = $OptionDetails[1];

                    $OptionsArray = $allProductPricingOptionsScalesAsArray[$OptionCode];
                    foreach ($OptionsArray as $key => $Option) {
                        if ($Option->getScaleMin() <= $OptionValue && $Option->getScaleMax() >= $OptionValue) {

                            // store scale value
                            $Option->setSelectedValue($OptionValue);

                            $result[] = $Option;
                            break;
                        }
                    }


                } else {
                    $result[] = $allProductPricingOptionsAsArray[$OptionCode];
                }
            }
            return $result;
        }
        return false;
    }

    public function setPricingOptions($PriceOptions)
    {
        $this->getOriginalInstance()->PriceOptions = $PriceOptions;
    }

    /**
     * Will sort options before returning joining them
     * @return string
     */
    public function getOptionsCodesArray()
    {
        $options = $this->getOriginalInstance()->PriceOptions;
        sort($options);
        return $options;
    }

    /**
     * @todo Transform to a local specific object.
     * @param $ParentCode
     * @param $CampaignCode
     */
    public function setCrossSell($ParentCode, $CampaignCode)
    {
        if ($ParentCode && $CampaignCode) {
            $this->getOriginalInstance()->CrossSell = new \stdClass;
            $this->getOriginalInstance()->CrossSell->ParentCode   = $ParentCode;
            $this->getOriginalInstance()->CrossSell->CampaignCode = $CampaignCode;

        } else {
            $this->getOriginalInstance()->CrossSell = null;
        }
    }

    public function getCrossSell()
    {
        if (!$this->getOriginalInstance()->CrossSell) {
            return false;
        }

        return $this->getOriginalInstance()->CrossSell;
    }

    public function addAdditionalInfo($key, $val)
    {
        $key = trim($key);

        if (empty($key)) {
            return false;
        }

        if (!isset($this->getOriginalInstance()->AdditionalInfo)) {
            $this->getOriginalInstance()->AdditionalInfo = array();
        }

        $this->getOriginalInstance()->AdditionalInfo[$key] = $val;

        return true;
    }

    public function getAdditionalInfo($key)
    {
        if(isset($key)){
            $key = trim($key);
        }

        if (empty($key)) {
            return false;
        }

        $AdditionalInfos = $this->getAdditionalInfos();

        if (isset($this->getOriginalInstance()->AdditionalInfo[$key])) {
            return $this->getOriginalInstance()->AdditionalInfo[$key];
        } else {
            return false;
        }
    }

    public function getAdditionalInfos()
    {
        return (array)$this->getOriginalInstance()->AdditionalInfo;
    }

    public function update(AbstractSubject $handler)
    {
        if ($handler instanceof Totals\TrialTotalsHandler) {
            $this->getOriginalInstance()->Trial = $handler->getOriginalInstance();
            $this->notify();
            return true;
        } else {
            return false;
        }
    }
}
