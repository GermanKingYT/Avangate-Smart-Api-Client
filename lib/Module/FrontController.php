<?php
namespace AvangateSmartApiClient\Module;

use AvangateSmartApiClient\ApiClient;
use AvangateSmartApiClient\Order;
use AvangateSmartApiClient\Storage;

class FrontController
{
    protected $orderConfig;
    protected $storageManager;
    protected $orderHandler;

    public function __construct(Order\OrderConfig $orderConfig, Storage\StorageManager $storageManager)
    {
        $this->orderConfig = $orderConfig;
        $this->storageManager = $storageManager;

        /**
         * Config
         */
        if (is_null($this->orderConfig->getDefaultCurrency())) {
            throw new Exception\InvalidArgumentException(
                'No default currency set.',
                Exception\InvalidArgumentException::NO_DEFAULT_CURRENCY
            );
        }

        if (is_null($this->orderConfig->getDefaultLanguage())) {
            throw new Exception\InvalidArgumentException(
                'No default language set.',
                Exception\InvalidArgumentException::NO_DEFAULT_LANGUAGE
            );
        }
    }

    /**
     * @return Order\OrderConfig
     */
    public function getOrderConfig()
    {
        return $this->orderConfig;
    }

    /**
     * @return Storage\StorageManager
     */
    public function getStorageManager()
    {
        return $this->storageManager;
    }

    /**
     * @param $name
     * @param $arguments
     * @return Order\OrderHandler
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->orderHandler, $name)) {
            throw new \BadMethodCallException(
                sprintf('Method [%s] does not exist.', $name)
            );
        }

        return call_user_func_array(array($this->orderHandler, $name), $arguments);
    }

    /**
     * @param $orderInstance
     * @return bool
     */
    public function prepareOrder($orderInstance)
    {
        if ($orderInstance instanceof \stdClass) {
            // @todo: Move to factory.
            $prepare = new ApiClient\ApiObjectsPrepareOrder($orderInstance);
            $this->orderHandler = $prepare->getHandlerInstance();
            return true;
        } else if ($orderInstance instanceof Order\OrderHandler) {
            $this->orderHandler = $orderInstance;
            return true;
        }  else {
            throw new Exception\InvalidArgumentException(
                'No valid order instance given.',
                Exception\InvalidArgumentException::NO_VALID_ORDER_INSTANCE
            );
        }
    }

    /**
     * @return Order\OrderHandler
     */
    public function order()
    {
        if (!($this->orderHandler instanceof Order\OrderHandler)) {
            throw new Exception\RuntimeException('No order was prepared yet.');
        } else {
            return $this->orderHandler;
        }
    }

    public function addItemByCode($Code, $Qty, $Options = array(), $Coupon = null)
    {

    }

    public function save()
    {

    }

    public function push()
    {
        $this->storageManager->pushOrder($this->orderHandler);
    }

    public function finish()
    {
        $this->storageManager->finishOrder($this->orderHandler);
    }
}