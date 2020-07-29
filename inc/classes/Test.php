<?php

namespace Suscripciones\Classes;

class Test
{

    static private $initialized = false;
    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
  
        return true;
    }

    public static function hola()
    {
        return 'hola stoy el panel principal';
    }


    public static function submenu()
    {
        return 'soy el menu digo submenu';
    }


}
