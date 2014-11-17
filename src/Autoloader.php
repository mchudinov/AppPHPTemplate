<?php
defined('APPROOT') or die('No direct script access.');

/**
 * @codeCoverageIgnore
 */
class Autoloader
{
    public static function Register() 
    {
        return spl_autoload_register(array('Autoloader', 'Load'));
    }


    public static function Load($strClassName)
    {
        $strFilePath = APPROOT.'src/classes/'.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        $strFilePath = APPROOT.'src'.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        $strFilePath = APPROOT.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }        
        
        $strFilePath = APPROOT.'tests/classes/'.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        $strFilePath = APPROOT.'tests/'.$strClassName.'.php'; 
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        return false;
    }
}

Autoloader::Register();
