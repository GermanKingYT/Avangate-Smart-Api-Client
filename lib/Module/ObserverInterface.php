<?php
namespace AvangateSmartApiClient\Module;

/**
 * Interface ObserverInterface
 * @package AvangateSmartApiClient
 */
interface ObserverInterface
{
    /**
     * Use the update method to update the Observer.
     *
     * @param AbstractSubject $subject
     * @return mixed
     */
    function update(AbstractSubject $subject);
}