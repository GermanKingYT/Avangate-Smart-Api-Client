<?php
namespace AvangateSmartApiClient\Product\Image;

/**
 * ProductImage Handler, used in volume discounts.
 */
class ProductImageHandler
{
    protected $imageObj;

    /**
     * Store the ProductImage object after passing it through a ProductImageHandler.
     * @param Obj\ProductImage $imageObj
     */
    public function __construct(Obj\ProductImage $imageObj)
    {
        $this->imageObj = $imageObj;
    }

    /**
     * Returns the basic object instance.
     */
    public function getOriginalInstance()
    {
        return $this->imageObj;
    }

    /**
     * Returns the image URL
     *
     * @return string
     */
    public function getURL()
    {
        return $this->getOriginalInstance()->URL;
    }

    /**
     * Checks if the image is default
     *
     * @return bool
     */
    public function isDefault()
    {
        return ($this->getOriginalInstance()->Default);
    }
}