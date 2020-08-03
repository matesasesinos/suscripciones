<?php

namespace Suscripciones\Menu;

use Suscripciones\Classes\Test;
use Suscripciones\Classes\UserRole;

class SuscripcionesMenu {

    static private $initialized = false;

    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        add_action( 'admin_menu', [self::class,'main_menu'] );
        add_action( 'admin_menu', [self::class,'suscripciones_menu']);
        add_action( 'admin_menu', [self::class, 'roles_menu']);
        return true;
    }

    static public function main_menu() {
        add_menu_page( 'GNI Suscripciones', 'GNI Suscripciones', 'manage_options', 'gni_admin', [self::class,'panelcito'],'dashicons-nametag',20 );
    }
    
    static public function suscripciones_menu() {
        add_submenu_page( 'gni_admin', 'GNI Suscripciones', 'Suscripciones', 'edit_posts', 'edit.php?post_type=suscripciones');
    }

    static public function roles_menu() {
        add_submenu_page( 'gni_admin', 'GNI Suscripciones', 'Roles de usuario', 'manage_options', 'user_roles',[self::class,'roles'], 20 );
    }

    static public function roles(){
        echo UserRole::form_role('');
        echo UserRole::view_roles();
        
    }

    static public function panelcito() {
        echo 'aca el panel';
    }
    

}
