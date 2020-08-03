<?php

namespace Suscripciones\Classes;

use Suscripciones\Classes\UserRole;

class Metaboxes {
    static private $initialized = false;
    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        add_action( 'add_meta_boxes', [self::class, 'add_metabox'] );
        add_action( 'save_post', [self::class,'save_suscripciones_meta_box_data'] );
        return true;
    }

    static public function add_metabox() {
        $screens = get_post_types();
        add_meta_box(
            'private-post',
            __( 'Contenido para suscriptores', 'genosha' ),
            [self::class,'suscripciones_meta_box_callback'],
            ['post','page'],
            'normal',
            'high'
        );
    }

    static function suscripciones_meta_box_callback( $post ) {
        
        wp_nonce_field( 'suscripciones_nonce', 'suscripciones_nonce' );
        
        $values    = get_post_custom($post->ID);
        $private     = isset($values['suscripcion_private']) ? esc_attr($values['suscripcion_private'][0]) : '';

        
         echo '<label> ¿Es contenido solo para suscriptores? <input type="checkbox" id="suscripcion_private" value="on" name="suscripcion_private" '.checked($private, 'on', false) .' /></label>';

    }

    static public function save_suscripciones_meta_box_data( $post_id ) {
        
        // Check if our nonce is set.
        if ( !isset( $_POST['suscripciones_nonce'] ) ) {
            return $post_id;
        }
    
        // Verify that the nonce is valid.
        if ( !wp_verify_nonce( $_POST['suscripciones_nonce'], 'suscripciones_nonce' ) ) {
            return $post_id;
        }
    
        if ( ! current_user_can( 'edit_post' ) ) {
            return $post_id;
        }
    
        $check = isset($_POST['suscripcion_private']) && $_POST['suscripcion_private'] ? 'on' : 'off';
        update_post_meta($post_id, 'suscripcion_private', $check);
    }
}