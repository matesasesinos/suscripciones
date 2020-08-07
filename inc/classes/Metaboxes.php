<?php

namespace Suscripciones\Classes;



class Metaboxes {
    static private $initialized = false;
    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
       // add_action( 'add_meta_boxes', [self::class, 'add_metabox'] );
       // add_action( 'save_post', [self::class,'save_suscripciones_meta_box_data'] );
        return true;
    }

    // static public function add_metabox() {
    //     $screens = get_post_types();
    //     add_meta_box(
    //         'private-post',
    //         __( 'Contenido para suscriptores', 'genosha' ),
    //         [self::class,'suscripciones_meta_box_callback'],
    //         ['post','page'],
    //         'side',
    //         'high'
    //     );
    // }

    // static function suscripciones_meta_box_callback( $post ) {
        
    //     wp_nonce_field( 'suscripciones_nonce', 'suscripciones_nonce' );
        
    //     $values    = get_post_custom($post->ID);
    //     $private     = isset($values['suscripcion_private']) ? esc_attr($values['suscripcion_private'][0]) : '';

    //     $roles = UserRole::chekboxes();

        
    //      $field = '<label> ¿Es contenido solo para suscriptores? <input type="checkbox" id="suscripcion_private" value="on" name="suscripcion_private" '.checked($private, 'on', false) .' /></label>';

    //      $field .= '<p>Suscriptores autorizados</p>';
    //     $rol_meta = maybe_unserialize( get_post_meta( $post->ID, '_roles', true ) );
    //     foreach($roles as $id => $rol) {
    //         //echo $rol;
    //         $slug = sanitize_title($rol);
    //         if ( is_array( $rol_meta ) && in_array( $slug, $rol_meta ) ) {
    //             $checked = 'checked="checked"';
    //         } else {
    //             $checked = null;
    //         }
    //         $field .= '<label><input type="checkbox" value="' . $slug . '" name="rol[]" '. $checked .' /> ' .$rol. '</label><br />';

    //     }

    //    echo $field;

    // }

    // static public function save_suscripciones_meta_box_data( $post_id ) {
        
    //     // Check if our nonce is set.
    //     if ( !isset( $_POST['suscripciones_nonce'] ) ) {
    //         return $post_id;
    //     }
    
    //     // Verify that the nonce is valid.
    //     if ( !wp_verify_nonce( $_POST['suscripciones_nonce'], 'suscripciones_nonce' ) ) {
    //         return $post_id;
    //     }
    
    //     if ( ! current_user_can( 'edit_post' ) ) {
    //         return $post_id;
    //     }
    
    //     $check = isset($_POST['suscripcion_private']) && $_POST['suscripcion_private'] ? 'on' : 'off';
    //     $roles = $_POST['rol'];

    //     update_post_meta($post_id, 'suscripcion_private', $check);
    //     if(!empty($roles)) {
    //         update_post_meta( $post_id, '_roles', $_POST['rol'] );
    //     } else {
    //         delete_post_meta( $post_id, '_roles' );
    //     }
        
    // }
}