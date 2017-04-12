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
	$get_project_type = $wpdb->get_results( "SELECT id, ptype_key, ptype_name, ptype_status FROM ".$table_name );

	return $get_project_type;

}


    global $wpdb;
	$table_name = $wpdb->prefix . 'project_type';

if(isset($_POST['edit_row']))
{
 	$proj_type_name = $_POST['add_pro_type'];
    $proj_type_status = $_POST['add_pro_ststus'];

 $wpdb->update( 
	$table_name, 
	array( 
		'ptype_name' => $proj_type_name,
        'ptype_status' => $proj_type_status,  
	), 
	array( 'ID' => 1 ), 
	array( 
		'%s',	
		'%s'
	), 
	array( '%s' ) 
);
}

/*if(isset($_POST['delete_row']))
{
 	$row_no=$_POST['row_id'];
 	mysql_query("delete from user_detail where id='$row_no'");
 	echo "success";
 	exit();
}*/
?>
