<?php
/**
 * Plugin Name: Bug Tracker: Best WordPress plugin
 * Plugin URI: http://saurabhdixit.co.in/
 * Description: Easily create new projects and assigned users to particular project. Assigned user can create/manage tickets for particular project. Bug Tracker gives ability to manage tickets from front end and backend both.
 * Version: 1.0.0
 * Author: TechBrise Solutions
 * Author URI: https://techbrise.com/
 * License: GPLv2 or later
 * Text Domain: ticket-tracker
 * Domain Path: /languages
 */
/**
Bug Tracker: Best WordPress plugin
Copyright (C) 2016 TechBrise Solutions

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'BT_BASE' ) ) {
    define( 'BT_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'BT_DIR' ) ) {
    define( 'BT_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'BT_DIR_INC' ) ) {
    define( 'BT_DIR_INC', BT_DIR . 'includes/' );
}

if ( ! defined( 'BT_DIR_LIB' ) ) {
    define( 'BT_DIR_LIB', BT_DIR_INC . 'libraries/' );
}

if ( ! defined( 'BT_NAME' ) ) {
    define( 'BT_NAME', 'Bug Tracker' );
}

if ( ! defined( 'BT_VERSION' ) ) {
    define( 'BT_VERSION', '1.0.0' );
}

require_once BT_DIR_INC . 'requirements.php';

global $bt_activated;

require_once BT_DIR_INC . 'class-bug-tracker.php';

add_action( 'plugins_loaded', 'bugtracker_init', 99 );


/**
 *
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
if ( ! function_exists( 'bugtracker_init' ) ) {
    function bugtracker_init() {
        global $Tb_Bug_Tracker;

        if ( is_null( $Tb_Bug_Tracker ) ) {
            $Tb_Bug_Tracker = new Tb_Bug_Tracker();
            $Tb_Bug_Tracker->project_type_table();
            $Tb_Bug_Tracker->project_table();
            $Tb_Bug_Tracker->project_status();
            $Tb_Bug_Tracker->project_ticket_status();
            $Tb_Bug_Tracker->project_ticket();
            $Tb_Bug_Tracker->project_ticket_comments();
        }

        global $TB_Admin_Bug_Tracker;
        if ( is_null( $TB_Admin_Bug_Tracker ) ) {
            $TB_Admin_Bug_Tracker = new TB_Admin_Bug_Tracker();
        }

    }
}

//register_activation_hook( __FILE__, array( 'Tb_Bug_Tracker', 'activation' ) );
//register_deactivation_hook( __FILE__, array( 'Tb_Bug_Tracker', 'deactivation' ) );
//register_uninstall_hook( __FILE__, array( 'Tb_Bug_Tracker', 'uninstall' ) );

?>
