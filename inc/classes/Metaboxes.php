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
        add_action( 'save_post', [self::class,'save_global_notice_meta_box_data'] );
        return true;
    }

    static public function add_metabox($post) {
        $screens = get_post_types();
        add_meta_box(
            'private-post',
            __( 'Contenido para suscriptores', 'genosha' ),
            [self::class,'global_notice_meta_box_callback'],
            $screens
        );
    }

    static function global_notice_meta_box_callback( $post ) {

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'suscripciones_nonce', 'suscripciones_nonce' );
    
        $private = get_post_meta( $post->ID, '_private', true );
        //isset( $values['info_libro_stock'] ) ? esc_attr( $values['info_libro_stock'][0] ) : '';
    
        echo '<label> ¿Es contenido solo para suscriptores? <input type="checkbox" id="private" name="private"'.checked( $private, 'on', false ).'" /></label>';
       // echo '<textarea style="width:100%" id="global_notice" name="global_notice">' . esc_attr( $value ) . '</textarea>';
    }

    static public function save_global_notice_meta_box_data( $post_id ) {

        // Check if our nonce is set.
        if ( ! isset( $_POST['suscripciones_nonce'] ) ) {
            return;
        }
    
        // Verify that the nonce is valid.
        if ( !wp_verify_nonce( $_POST['suscripciones_nonce'], 'suscripciones_nonce' ) ) {
            return;
        }
    
        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post' ) ) {
            return;
        }
        /* OK, it's safe for us to save the data now. */
    
        // Make sure that it is set.
        if ( ! isset( $_POST['private'] ) ) {
            return;
        }
    
        $check = isset( $_POST['private']  ) && $_POST['private']  ? 'on' : 'off';
        update_post_meta( $post_id, '_private', $check );
    }


}