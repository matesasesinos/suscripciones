<?php

namespace Suscripciones\Entities;

use Suscripciones\Classes\UserRole;
class SuscripcionesPostType
{

    static private $initialized = false;

    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        add_action('init', [self::class, 'cpt_suscripciones'],0);
        add_action( 'add_meta_boxes', [self::class, 'add_metabox'] );
        add_action( 'save_post', [self::class,'save_suscripciones_meta_box_data'] );
        add_filter( 'manage_suscripciones_posts_columns', [self::class,'set_custom_edit_suscripciones_columns'] );
        add_action( 'manage_suscripciones_posts_custom_column' , [self::class,'custom_suscripciones_column'], 10, 2 );
        return true;
    }


    public static function cpt_suscripciones()
    {

        $labels = [
            'name' => __('Suscripciones', 'genosha'),
            'singular_name' => __('Suscripción', 'genosha'),
            'menu_name' => __('Suscripciones', 'genosha'),
            'all_items' => __('Todas las suscripciones', 'genosha'),
            'add_new' => __('Nueva Suscripción', 'genosha'),
            'add_new_item' => __('Nueva', 'genosha'),
            'edit_item' => __('Editar', 'genosha'),
            'new_item' => __('Nueva', 'genosha'),
            'view_item' => __('Ver', 'genosha'),
            'view_items' => __('Ver todas', 'genosha'),
            'search_items' => __('Buscar Suscripciones', 'genosha'),
            'not_found' => __('No hay suscripciones', 'genosha'),
            'not_found_in_trash' => __('No se encontró en la papelera', 'genosha'),
            'featured_image' => __('Imagen principal', 'genosha'),
            'set_featured_image' => __('Fijar imagen principal', 'genosha'),
            'remove_featured_image' => __('Quitar imagen principal', 'genosha'),
        ];

        $args = [
            'label' => __('Suscripciones', 'genosha'),
            'labels' => $labels,
            'description' => '',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'rest_base' => '',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'has_archive' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => true,
            'delete_with_user' => false,
            'exclude_from_search' => false,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => false,
            'rewrite' => ['slug' => 'suscripciones', 'with_front' => true],
            'query_var' => true,
            'menu_icon' => 'dashicons-feedback',
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        ];

        register_post_type('suscripciones', $args);
    }
    //columns

    
    static public function set_custom_edit_suscripciones_columns($columns) {
        $columns['_roles'] = __( 'Roles', 'genosha' );
        $columns['_price'] = __( 'Precio', 'genosha' );
     

        return $columns;
    }

    static public function custom_suscripciones_column( $column, $post_id ) {
        switch ( $column ) {
    
            case '_roles' :
                $roles = maybe_unserialize( get_post_meta( $post_id, '_roles', true ) );
                if ( $roles )
                    foreach($roles as $rol):
                        echo $rol.', ';
                    endforeach;
                else
                    _e( 'No hay roles?', 'genosha' );
                break;
    
            case '_price' :
                echo get_post_meta( $post_id , '_price' , true ); 
                break;

        }
    }


    //MetaBoxes Suscripciones
    static public function add_metabox() {
        add_meta_box(
            'suscripciones-box',
            __( 'Opciones y detalles', 'genosha' ),
            [self::class,'suscripciones_meta_box_callback'],
            'suscripciones',
            'side',
            'high'
        );
    }

    static function suscripciones_meta_box_callback( $post ) {
        
        wp_nonce_field( 'suscripciones_nonce', 'suscripciones_nonce' );
        $roles = UserRole::chekboxes();

        $price = get_post_meta($post->ID,'_price',true);
        
        
        $field = '<label class="components-base-control__label">Precio de la suscripción</label><input type="number" name="price" step="0.01" min="1" value="'.$price.'" placeholder="1.00" />';
        $field .= '<p>Suscriptores autorizados</p>';
        $rol_meta = maybe_unserialize( get_post_meta( $post->ID, '_roles', true ) );
        foreach($roles as $id => $rol) {
            //echo $rol;
            $slug = sanitize_title($rol);
            if ( is_array( $rol_meta ) && in_array( $slug, $rol_meta ) ) {
                $checked = 'checked="checked"';
            } else {
                $checked = null;
            }
            $field .= '<label><input type="checkbox" value="' . $slug . '" name="rol[]" '. $checked .' /> ' .$rol. '</label><br />';

        }

       echo $field;
        
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
    
        $price = $_POST['price'];
        $roles = $_POST['rol'];
        update_post_meta($post_id, '_price', $price );
        if(!empty($roles)) {
            update_post_meta( $post_id, '_roles', $_POST['rol'] );
        } else {
            delete_post_meta( $post_id, '_roles' );
        }
    }

}