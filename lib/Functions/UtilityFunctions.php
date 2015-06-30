<?php
/**
 * Functions
 *
 * @note We need a namespace for our functions
 * to stay away from conflicts with other 3rd party
 * scripts's function names. (eg. Drupal, Wordpress, any CMS, etc.)
 */
namespace AvangateSmartApiClient\Functions;

class UtilityFunctions
{
    /**
     * Count the items of an object or array.
     * If the argument is an integer or string the result is 0.
     * http://stackoverflow.com/questions/1314745/php-count-an-stdclass-object
     *
     * @param  object $obj
     * @return integer      Number of items from the first level of the object.
     */
    public function count($obj)
    {
        if(is_object($obj)){
            return (int)\count(get_object_vars($obj));
        }

        if(empty($obj)){
            return 0;
        }

        if(is_array($obj)){
            return (int)\count($obj);
        }

        return 0;
    }

    /**
     * Generate a hash using the method's arguments, after JSON-encoding them.
     * Used mainly in storing the prices.
     *
     * @return string
     */
    public function generateHash()
    {
        $myArgs = \func_get_args();
        if (!count($myArgs)) {
            return false;
        }

        $myArgsString = sha1(json_encode($myArgs));
        return $myArgsString;
    }

    /**
     * Determine if the session has started.
     *
     * @return bool
     */
    public function is_session_started()
    {
        //if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? true : false;
        } else {
            return session_id() === '' ? false : true;
        }
        //}
    }

    /**
     * Get a variable's value from the static registry.
     *
     * @param  string $varName
     * @return mixed
     */
    public function get_variable($varName)
    {
        return Registry::get($varName);
    }

    /**
     * Set a variable in the static registry.
     *
     * This is useful for configuration and settings variables
     * that we need to access globally across the application.
     *
     * @param string $varName
     * @param mixed $varValue
     */
    public function set_variable($varName, $varValue)
    {
        Registry::set($varName, $varValue);
    }

    /**
     * Outputs every parameter.
     * @note: Use only in development environment.
     *
     * @param  mixed
     * @return bool
     */
    public function debug()
    {
        $myArgs = func_get_args();
        if (!count($myArgs)) {
            return false;
        }

        foreach($myArgs as $debugData){
            echo '<pre>'.print_r($debugData, 1).'</pre>';
        }

    }
}