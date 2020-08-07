<?php

namespace Suscripciones\Menu;

use Suscripciones\Classes\Test;

class SuscripcionesMenu {

    static private $initialized = false;

    static public function initialize()
    {
        if (self::$initialized)
            return false;
        self::$initialized = true;
        add_action( 'admin_menu', [self::class,'main_menu'] );
        add_action( 'admin_menu', [self::class,'suscripciones_menu']);
        add_action( 'admin_menu', [self::class, 'pedidos_menu']);
        add_action( 'admin_menu', [self::class, 'miembros_menu']);
        add_action( 'admin_menu', [self::class, 'pagos_menu']);
        return true;
    }

    static public function main_menu() {
        add_menu_page( 'TAR Suscripciones', 'TAR Suscripciones', 'manage_options', 'tar_admin', [self::class,'panelcito'],'dashicons-nametag',20 );
    }
    
    //crear suscripciones
    static public function suscripciones_menu() {
        add_submenu_page( 'tar_admin', 'TAR Suscripciones', 'Suscripciones', 'edit_posts', 'edit.php?post_type=suscripciones');
    }

    static public function pedidos_menu() {
        add_submenu_page( 'tar_admin', 'TAR Pedidos', 'Pedidos', 'manage_options', 'tar_pedidos',[self::class,'pedidos'], 20 );
    }

    static public function miembros_menu() {
            add_submenu_page( 'tar_admin', 'TAR Miembros', 'Miembros', 'manage_options', 'tar_miembros',[self::class,'miembros'], 20 );
    }

    static public function pagos_menu() {
        add_submenu_page( 'tar_admin', 'TAR Pagos', 'Medios de Pagos', 'manage_options', 'tar_pagos',[self::class,'pagos'], 20 );
}

    static public function pedidos() {
        echo 'la lista de suscripciones realizadas por miembros';
    }

    static public function miembros() {
        echo 'aca se muestra la lista de miembros con opciones y demas';
    }

    static public function pagos() {
        echo 'aca sería la configuración para medios de pago';
    }

    static public function panelcito() {
        echo 'aca el panel llevaría data de suscripciones miembros y demas';
    }
    

}
