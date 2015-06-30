<?php
namespace AvangateSmartApiClient\Module;

/**
 * Abstract Subject class.
 * @abstract
 */
abstract class AbstractSubject
{
    /**
     * @var ObserverInterface[]
     */
    public $observers = array();

    /**
     * Will add the observer class to the list.
     * @param  ObserverInterface $observerClass
     */
    public function attach(ObserverInterface $observerClass)
    {
        $this->observers[] = $observerClass;
    }

    /**
     * Gets all observer objects.
     * @return array
     */
    public function getObservers()
    {
        return $this->observers;
    }

    /**
     * Will remove the observerClass from the observers list.
     * Returns true if removed and false if not found.
     * @param ObserverInterface $observerClass
     * @return bool
     */
    public function detach(ObserverInterface $observerClass)
    {
        $wasDetached = false;

        if (count($this->observers)) {
            foreach ($this->observers as $key => $value) {
                if ($value == $observerClass) {
                    unset($this->observers[$key]);
                    $this->observers = array_values($this->observers);
                    $wasDetached = true;
                }
            }
        }

        return $wasDetached;
    }

    public function notify()
    {
        $wereNotified = false;

        if (count($this->observers)) {
            foreach ($this->observers as $key => $observer) {
                $observer->update($this);
                $wereNotified = true;
            }
        }

        return $wereNotified;
    }
}
