<?php

namespace Suscripciones\Entities;


class SuscripcionesPostType
{

    static private $initialized = false;

    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        add_action('init', [self::class, 'cpt_suscripciones'],0);
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

    //MetaBoxes Suscripciones


}