<?php
/**
Bug Tracker
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

require_once BT_DIR_INC . 'class-admin-bug-tracker.php';
require_once BT_DIR_INC . 'function-admin-bug-tracker.php';

if ( class_exists( 'Tb_Bug_Tracker' ) ) {
    return;
}

class Tb_Bug_Tracker {
    const BASE    = BT_BASE;
    const ID      = 'bug-tracker';
    const SLUG    = 'bt_';
    const VERSION = BT_VERSION;

    const PT = 'bug-tracker';

    public static $project_type_table_version = '1.0';

    public static $class = __CLASS__;
    public static $library_assets;
    public static $plugin_assets;
    public static $settings_link;
    public static $wp_query;

    public function __construct() {
        self::$plugin_assets = plugins_url( '/assets/', dirname( __FILE__ ) );
        self::$plugin_assets = self::strip_protocol( self::$plugin_assets );

        //register_activation_hook( __FILE__, array( __CLASS__, 'project_type_table' ) );
        //register_activation_hook( __FILE__, array( __CLASS__, 'project_table' ) );
        //register_activation_hook( __FILE__, array( __CLASS__, 'project_status' ) );
        //register_activation_hook( __FILE__, array( __CLASS__, 'project_ticket_status' ) );
        //register_activation_hook( __FILE__, array( __CLASS__, 'project_ticket' ) );
    }

    public static function strip_protocol( $link ) {
        if ( ! empty( $link ) ) {
            $link = preg_replace( '#https?:#', '', $link );
        }

        return $link;
    }

    public static function project_type_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'project_type';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
		    id mediumint(9) NOT NULL AUTO_INCREMENT,
		    ptype_key tinytext NOT NULL,
            ptype_name tinytext NOT NULL,
		    UNIQUE KEY id (id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    public static function project_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'projects';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
		    id mediumint(9) NOT NULL AUTO_INCREMENT,
            p_key tinytext NOT NULL,
		    p_name tinytext NOT NULL,
            p_description tinytext NOT NULL,
            p_url tinytext NOT NULL,
            p_public tinytext NOT NULL,
            p_type tinytext NOT NULL,
            p_status tinytext NOT NULL,
            p_assignee tinytext NOT NULL,
            p_reporter tinytext NOT NULL,
		    UNIQUE KEY id (id)
	    ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }
     public static function project_status() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'projects_status';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            p_satuts_key tinytext NOT NULL,
            p_status tinytext NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }
    public static function project_ticket_status() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'projects_ticket_status';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            p_ticket_key tinytext NOT NULL,
            p_ticket_status tinytext NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }
    public static function project_ticket() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'projects_ticket';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            p_ticket_key tinytext NOT NULL,
            p_key tinytext NOT NULL,
            p_ticket_name tinytext NOT NULL,
            ticket_description tinytext NOT NULL,
            p_ticket_status tinytext NOT NULL,
            p_ticket_assignee tinytext NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }
    public static function project_ticket_comments() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'project_ticket_comments';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            t_discription_key tinytext NOT NULL,
            p_ticket_key tinytext NOT NULL,
            ticket_description tinytext NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }


}