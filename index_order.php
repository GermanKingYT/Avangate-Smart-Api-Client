<?php
require 'vendor/autoload.php';

/**
 * @var $app AvangateSmartApiClient\Module\FrontController
 */
$app = include 'include/app.php';

// Simulate raw object from API.
//$myOrderApiObjRaw = include 'tests/fixtures/jsonOrderInstanceOneItemTrial.php';
$orderInstance = include 'tests/fixtures/jsonOrderInstanceTwoItemsOneIsFromCrossSellFinished.php';
$app->prepareOrder($orderInstance);

echo '<h1>$orderInstance</h1>';
var_dump( $orderInstance );
echo '<hr>';

echo '<h1>$app->order()->getOriginalInstance()</h1>';
var_dump( $app->order()->getOriginalInstance() );
echo '<hr>';

echo '<h1>$app->order()</h1>';
var_dump( $app->order() );
echo '<hr>';

echo '<h1>$app->order()->getBillingDetails()</h1>';
var_dump( $app->order()->getBillingDetails() );
var_dump( $app->order()->getBillingDetails()->getFirstName() );
echo '<hr>';

echo '<h1>$app->order()->getDeliveryDetails()</h1>';
var_dump( $app->order()->getDeliveryDetails() );
echo '<hr>';

echo '<h1>$app->order()->getPaymentDetails()</h1>';
var_dump( $app->order()->getPaymentDetails() );
var_dump( $app->order()->getPaymentDetails()->getCurrency() );
echo '<hr>';

echo '<h1>$app->order()->getItems()</h1>';
var_dump( $app->order()->getItems() );
echo '<hr>';

echo '<h1>$app->order()->getTotals()</h1>';
var_dump( $app->order()->getTotals() );
echo '<hr>';

echo '<h1>$app->order()->getItem(ID)->getPrice()</h1>';
var_dump( $app->order()->getItem('6000')->getPrice() );
echo '<hr>';

echo '<h1>$app->order()->getItem(ID)->getNetPrice()</h1>';
var_dump( $app->order()->getItem('6000')->getPrice()->getNetPrice() );
echo '<hr>';

echo '<h1>$app->order()->getItem(ID)->getTrial()</h1>';
var_dump( $app->order()->getItem('6000')->getTrial() );
echo '<hr>';

echo '<h1>$app->order()->getItem(ID)->getTrial()->getPrice()</h1>';
var_dump( $app->order()->getItem('6000')->getTrial()->getPrice() );
echo '<hr>';



//var_dump($app->order()->getCartId()); // Same with: var_dump($app->getCartId());
//var_dump($app->order()->getOriginalInstance()->getOriginalInstance());
