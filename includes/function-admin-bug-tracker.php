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

/*function get all project type*/

function get_project_type() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'project_type';
	$get_project_type = $wpdb->get_results( "SELECT id, ptype_key, ptype_name FROM ".$table_name );

	return $get_project_type;

}
?>