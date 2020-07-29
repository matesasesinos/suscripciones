<?php
/*
Plugin Name:  Suscripciones
Plugin URI:   https://genosha.com.ar/
Description:  Suscripciones
Version:      1.0
Author:       genosha.com.ar
Author URI:   https://genosha.com.ar/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  genosha
Domain Path:  /languages
*/

define('BASE_PATH', plugin_dir_path(__FILE__));
define('BASE_URL', plugin_dir_url(__FILE__));

// include the Composer autoload file
require BASE_PATH . 'vendor/autoload.php';

// use Suscripciones\Classes\Test;
// Test::initialize();

use Suscripciones\Menu\SuscripcionesMenu;
use Suscripciones\Entities\SuscripcionesPostType;
use Suscripciones\Classes\Metaboxes;


SuscripcionesMenu::initialize();
SuscripcionesPostType::initialize();
Metaboxes::initialize();
