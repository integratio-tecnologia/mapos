<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LogContext 
{
    protected static $context = array();
    protected static $CI;

    public function __construct() 
    {
        self::$CI = &get_instance();
    }

    public static function set($key, $value) 
    {
        self::$context[$key] = $value;
        return true;
    }

    public static function get($key) 
    {
        return isset(self::$context[$key]) ? self::$context[$key] : null;
    }

    public static function clear() 
    {
        self::$context = array();
        return true;
    }

    public static function all() 
    {
        return self::$context;
    }

    public static function toJson() 
    {
        return json_encode(self::$context);
    }
}