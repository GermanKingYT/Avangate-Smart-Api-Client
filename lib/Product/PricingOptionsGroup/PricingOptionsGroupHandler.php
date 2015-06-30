<?php
namespace AvangateSmartApiClient\Product\PricingOptionsGroup;

/**
 * Used to set/get data from/to the basic PricingOptionsGroup object
 */
class PricingOptionsGroupHandler
{
    private $pricingOptionsGroupObj;

    public function __construct(Obj\PricingOptionsGroup $pricingOptionsGroupObj)
    {
        $this->pricingOptionsGroupObj = $pricingOptionsGroupObj;
    }

    /**
     * Returns the basic object instance.
     */
    public function getOriginalInstance()
    {
        return $this->pricingOptionsGroupObj;
    }

    /**
     * Returns the group's Code.
     * @return string
     */
    public function getCode()
    {
        return $this->getOriginalInstance()->Code;
    }

    /**
     * Returns the group's Type (RADIO, CHECKBOX, INTERVAL, COMBO, INTERVAL).
     * @return string
     */
    public function getType()
    {
        return $this->getOriginalInstance()->Type;
    }

    /**
     * Get PricingOptionsGroup Name.
     * Can return translated Name by passing the translation language code.
     * @param null $languageCode
     * @return string
     */
    public function getName($languageCode = null)
    {
        if (!empty($languageCode)) {
            if (count($this->getOriginalInstance()->Translations) > 0) {
                $languageCode = strtoupper($languageCode);

                foreach ($this->getOriginalInstance()->Translations as $TranslationObj) {
                    if ($TranslationObj->Language == $languageCode) {
                        return $TranslationObj->Name;
                    }
                }
            }
        } else {
            return $this->getOriginalInstance()->Name;
        }
    }

    /**
     * Get PricingOptionsGroup Description.
     * Can return translated Description by passing the translation language code.
     * @param null $languageCode
     * @return string
     */
    public function getDescription($languageCode = null)
    {
        if (!empty($languageCode)) {
            if (count($this->getOriginalInstance()->Translations)) {
                $languageCode = strtoupper($languageCode);

                foreach ($this->getOriginalInstance()->Translations as $TranslationObj) {
                    if ($TranslationObj->Language == $languageCode) {
                        return $TranslationObj->Description;
                    }
                }
            }
        } else {
            return $this->getOriginalInstance()->Description;
        }
    }

    /**
     * Returns an array of PricingOption obj.
     * Returns false if there are no PricingOptions associated to the PricingOptionsGroup.
     *
     * @return array
     */
    public function getOptions()
    {
        if (isset($this->getOriginalInstance()->Options) || count($this->getOriginalInstance()->Options) > 0) {
            $handlers = [];
            foreach ($this->getOriginalInstance()->Options as $OptionObj) {
                $handlers[] = $this->
            }
        } else {
            return array();
        }
    }
}
