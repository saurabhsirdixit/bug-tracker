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
function get_project_status() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'projects_status';
	$get_project_ststus = $wpdb->get_results( "SELECT id, p_satuts_key, p_status FROM ".$table_name );

	return $get_project_ststus;

}
function get_project_ticket() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'projects_ticket_status';
	$get_project_ticket = $wpdb->get_results( "SELECT id, p_ticket_key, p_ticket_status FROM ".$table_name );

	return $get_project_ticket;

}



/*if(isset($_POST['delete_row']))
{
 	$row_no=$_POST['row_id'];
 	mysql_query("delete from user_detail where id='$row_no'");
 	echo "success";
 	exit();
}*/
?>
