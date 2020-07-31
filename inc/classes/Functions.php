<?php

namespace Suscripciones\Classes;

class Functions
{
    static private $initialized = false;
    static public $post;

    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        add_action('loop_start', [self::class, 'get_post_private']);
        return true;
    }

    static public function get_post_private($id)
    {
        if(!is_admin()) {
            global $post; 
            $meta = get_post_meta($post->ID,'suscripcion_private',true);
            if($meta && $meta === 'on') {
                if(!is_user_logged_in()) {
                    add_filter( 'the_content', [self::class,'filter_the_content_in_the_main_loop'], 1 );
                }
            }
        }
    }

    static public function filter_the_content_in_the_main_loop( $content ) 
    {
 
        return esc_html__( 'Esta entrada es solo para suscriptores', 'genosha');
    }
}
