<?php
namespace Suscripciones\Classes;


class UserRole {

    static private $initialized = false;
    static public $role;

    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        self::form_role(self::$role);
        self::user_role();
        self::chekboxes();
        return true;
    }
    

    static public function get_roles() {
        global $wp_roles;
        $roles = $wp_roles->get_names();
        return $roles;
    }

    static public function chekboxes() {
        $role = self::get_roles();
        $roles = array();
        foreach($role as $rol) {
            $roles_cap = get_role( sanitize_title($rol) )->capabilities;
            foreach($roles_cap as $key => $value) {
                if($key === 'suscriptores') {
                    $roles[] = $rol;
                }
            }
        }
        return $roles;
    }

    static public function view_roles() {
        $roles = '<div class="content-roles wrap">';
        $roles .= '<h2 class="wp-heading-inline">Lista de roles</h2>';
        $role = self::get_roles();
        foreach($role as $rol) {
            $roles_cap = get_role( sanitize_title($rol) )->capabilities;
            foreach($roles_cap as $key => $value) {
                if($key === 'suscriptores') {
                    $roles .= '<p>'.$rol.'</p>';
                }
            }
        } 
        $roles .= '</div>';

        return $roles;
    }

    static public function form_role($role) {
        $form = '<div class="wrap">';
        $form = '<h1 class="wp-heading-inline">Roles para suscripciones</h1>';
        $form .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">';
        $form .= '<ul><li>
                    <label for="role">'.__( 'Nombre del Rol', 'genosha' ).'</label><br>
                    <input type="text" name="rol" value="' . ( isset( $_POST['rol'] ) ? $role : null ) . '" class="regular-text" /></li>
                 </ul>';
        $form .= '<input type="submit" name="submit" class="button-primary" value="'.__( 'Crear Rol', 'genosha' ).'" />';
        $form .= '</form>';
        $form .= '</div>';
        return $form;
    }

    static public function user_role() {

        if(isset($_POST['submit'])) {
            $role = sanitize_text_field( $_POST['rol'] );
            $slug = sanitize_title( $role );

            if(empty( $role )) {
                echo 'el campo no puede estar vacio';
            } else {
                add_role(
                    $slug,
                    $role,
                    [
                        'read' => true
                    ]
                );

                $rol = get_role($slug);
                $rol->add_cap('suscriptores');
            }
        }
    }

}

UserRole::initialize();
