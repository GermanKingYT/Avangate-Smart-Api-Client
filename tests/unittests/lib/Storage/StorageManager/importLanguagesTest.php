<?php
namespace AvangateSmartApiClientTest\Storage\StorageManager;

use AvangateSmartApiClient\Functions\UtilityFunctions;
use AvangateSmartApiClient\Storage\StorageManager;
use AvangateSmartApiClient\Storage\Exception;
use AvangateSmartApiClient\ApiClient\ApiClientManager;
use AvangateSmartApiClient\ApiClient\ApiClientInterface;

class ImportLanguagesTest extends \PHPUnit_Framework_TestCase
{
    static $fixture;

    public static function setUpBeforeClass()
    {
        self::$fixture = include_once dirname(__FILE__) . '/../../../../fixtures/entities/jsonMerchantLanguages.php';
    }

    /**
     * all given languages are set in the storage
     */
    public function testAllGivenLanguagesAreSetInTheStorage()
    {
        /**
         * @var $mock1 StorageManager
         */
        $mock1 = $this->getMockBuilder('\AvangateSmartApiClient\Storage\StorageManager')
                    ->disableOriginalConstructor()
                    ->setMethods(array('getFunctions','getApiClientManager', 'getStorage'))
                    ->getMock();

        /**
         * @var $mock2 ApiClientInterface
         */
        $mock2 = $this->getMockBuilder('\AvangateSmartApiClient\ApiClient\ApiClientInterface')
                    ->enableProxyingToOriginalMethods()
                    ->setMethods(array('getAvailableLanguages'))
                    ->getMockForAbstractClass();
        $mock2->method('getAvailableLanguages')->willReturn(self::$fixture);

        /**
         * @var $mock3 ApiClientManager
         */
        $mock3 = $this->getMockBuilder('\AvangateSmartApiClient\ApiClient\ApiClientManager')
                    ->disableOriginalConstructor()
                    ->setMethods(array('getProductApiClient'))
                    ->getMock();
        $mock3->method('getProductApiClient')->willReturn($mock2);

        $mock4 = $this->getMockBuilder('\AvangateSmartApiClient\Storage\StorageAdapterInterface')
                        ->enableProxyingToOriginalMethods()
                        ->getMockForAbstractClass();

        $mock1->method('getFunctions')->willReturn(new UtilityFunctions());
        $mock1->method('getApiClientManager')->willReturn($mock3);
        $mock1->method('getStorage')->willReturn($mock4);

        $this->assertEquals($mock1->importLanguages(), 33);
    }



    /**
     * if no languages are given then exception is thrown
     * @expectedException \AvangateSmartApiClient\Storage\Exception\RuntimeException
     * @expectedExceptionCode \AvangateSmartApiClient\Storage\Exception\RuntimeException::NO_LANGUAGES_FOUND
     */
    public function testIfNoLanguagesAreGivenThenExceptionIsThrown()
    {
        /**
         * @var $mock1 StorageManager
         */
        $mock1 = $this->getMockBuilder('\AvangateSmartApiClient\Storage\StorageManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getFunctions','getApiClientManager', 'getStorage'))
            ->getMock();

        /**
         * @var $mock2 ApiClientInterface
         */
        $mock2 = $this->getMockBuilder('\AvangateSmartApiClient\ApiClient\ApiClientInterface')
            ->enableProxyingToOriginalMethods()
            ->setMethods(array('getAvailableLanguages'))
            ->getMockForAbstractClass();
        $mock2->method('getAvailableLanguages')->willReturn(null);

        /**
         * @var $mock3 ApiClientManager
         */
        $mock3 = $this->getMockBuilder('\AvangateSmartApiClient\ApiClient\ApiClientManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getProductApiClient'))
            ->getMock();
        $mock3->method('getProductApiClient')->willReturn($mock2);

        $mock4 = $this->getMockBuilder('\AvangateSmartApiClient\Storage\StorageAdapterInterface')
            ->enableProxyingToOriginalMethods()
            ->getMockForAbstractClass();

        $mock1->method('getFunctions')->willReturn(new UtilityFunctions());
        $mock1->method('getApiClientManager')->willReturn($mock3);
        $mock1->method('getStorage')->willReturn($mock4);

        $mock1->importLanguages();

    }



}