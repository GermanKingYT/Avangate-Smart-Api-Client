<?php
namespace AvangateSmartApiClientTest\Storage\StorageManager;

use AvangateSmartApiClient\Functions\UtilityFunctions;
use AvangateSmartApiClient\Storage\StorageManager;
use AvangateSmartApiClient\Storage\Exception;
use AvangateSmartApiClient\ApiClient\ApiClientManager;
use AvangateSmartApiClient\ApiClient\ApiClientInterface;

class ImportProductObjectTest extends \PHPUnit_Framework_TestCase
{
    static $productFixture;
    static $productCrossSellFixture;

    public static function setUpBeforeClass()
    {
        self::$productFixture = include_once dirname(__FILE__) . '/../../../../fixtures/entities/jsonProduct6000.php';
        self::$productCrossSellFixture = include_once dirname(__FILE__) . '/../../../../fixtures/entities/jsonProduct6000CrossSellCampaigns.php';
    }


    /**
     * importing a product with an empty code returns false
     */
    public function testImportingAProductWithAnEmptyCodeReturnsFalse()
    {
        /**
         * @var $mock StorageManager
         */
        $mock = $this->getMockBuilder('\AvangateSmartApiClient\Storage\StorageManager')
            ->disableOriginalConstructor()
            //->enableProxyingToOriginalMethods()
            ->getMock();

        $class = new \ReflectionClass('\AvangateSmartApiClient\Storage\StorageManager');
        $method = $class->getMethod('importProductObject');
        $method->setAccessible(true);
        $result = $method->invokeArgs($mock, array(new \stdClass()));

        $this->assertFalse($result);
    }


    /**
     * importing a product with one cross sell campaign returns true
     */
    public function testImportingAProductWithOneCrossSellCampaignReturnsTrue()
    {
        /**
         * @var $mockApiClient ApiClientInterface
         */
        $mockApiClientInterface = $this->getMockBuilder('\AvangateSmartApiClient\ApiClient\ApiClientInterface')
            ->enableProxyingToOriginalMethods()
            ->setMethods(array('getProductCrossSellCampaigns'))
            ->getMockForAbstractClass();
        $mockApiClientInterface->method('getProductCrossSellCampaigns')->willReturn(self::$productCrossSellFixture);

        /**
         * @var $mockApiClientManager ApiClientManager
         */
        $mockApiClientManager = $this->getMockBuilder('\AvangateSmartApiClient\ApiClient\ApiClientManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getProductApiClient'))
            ->getMock();
        $mockApiClientManager->method('getProductApiClient')->willReturn($mockApiClientInterface);

        /**
         * @var $mockStorageAdapterInterface StorageAdapterInterface
         */
        $mockStorageAdapterInterface = $this->getMockBuilder('\AvangateSmartApiClient\Storage\StorageAdapterInterface')
            ->enableProxyingToOriginalMethods()
            ->setMethods(array('set'))
            ->getMockForAbstractClass();
        $mockStorageAdapterInterface->expects($this->exactly(2))
                                    ->method('set')
                                    ->willReturn(true);

        /**
         * @var $mockStorageManager StorageManager
         */
        $mockStorageManager = $this->getMockBuilder('\AvangateSmartApiClient\Storage\StorageManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getFunctions','getApiClientManager', 'getStorage'))
            ->getMock();

        $mockStorageManager->method('getFunctions')->willReturn(new UtilityFunctions());
        $mockStorageManager->method('getApiClientManager')->willReturn($mockApiClientManager);
        $mockStorageManager->method('getStorage')->willReturn($mockStorageAdapterInterface);

        $this->assertTrue($mockStorageManager->importProductObj(self::$productFixture));
    }


}