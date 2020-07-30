<?php

namespace Suscripciones\Classes;
use WP_Query;

class Functions
{
    static private $initialized = false;
    static public $post;

    static public function init()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        add_action('init', [self::class, 'get_post_private']);
        return true;
    }

    //replace content in private post

    static public function get_post_private()
    {
        global $wp_query;
        $wp_query = new WP_Query();
    }
}
