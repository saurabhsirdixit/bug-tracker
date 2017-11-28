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

if ( class_exists( 'TB_Admin_Bug_Tracker' ) ) {
    return;
}

class TB_Admin_Bug_Tracker extends Tb_Bug_Tracker {
    const ID      = 'bug-tracker-setting';

    public static $form_options = array();
    public static $project_type = array();
    public static $project_status = array();
    public static $project_ticket_status = array();
    public static $project_name = array();
    public static $project_assignee = array();
    public static $project_reporter = array();
    public static $html         = '';
    public static $form         = '';
    public static $msg          = '';
    public static $msg_class    = '';

    public function __construct() {
        $classname   = __CLASS__;
        $description = esc_html__( 'Displays backend setting page.', 'bug-tracker' );
        $id_base     = self::ID;
        $title       = esc_html__( 'Bug Tracker', 'bug-tracker' );

        parent::__construct( $classname, $description, $id_base, $title );

        add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

        add_action( 'admin_print_scripts', array( __CLASS__, 'scripts' ) );
        add_action( 'admin_print_styles', array( __CLASS__, 'styles' ) );
    }

    public static function admin_menu() {
        add_menu_page('Projects', 'Manage Projects', 'manage_options', 'projects', array(__CLASS__,
            'bt_dashboard_page'));
         /*add_submenu_page('projects', 'Dashboard', 'Dashboard', 'manage_options', 'dashboard', array(__CLASS__,
            'bt_dashboard_page'));*/
        add_submenu_page('projects', 'New Project', 'New Project', 'manage_options', 'new-projects', array(__CLASS__,
            'bt_add_project_page'));
        add_submenu_page('projects', 'Project Type', 'Project Type', 'manage_options', 'project-type', array(__CLASS__,
            'bt_add_project_type'));

    }
    public static function bt_dashboard_page() {
        if ( !current_user_can( 'manage_options' ) ) {
            wp_die( __( 'you do not having permissions to access this page' ) );
        }
        echo'<center><h1><span class="yellow">Bug-Tracker: A Project Management System</span></h1>
                <h2>Powered by: <a href="http://techbrise.com" target="_blank">TechBrise Solutions</a></h2></center>';

               if( isset( $_GET['tvid'] ) ) {
                        $tvid = $_GET['tvid'];
                        echo $tvid;
                        echo self::bt_view_ticket_pages();
                    }

               else{
               if( isset( $_GET['tid'] ) ) {
                        $tid = $_GET['tid'];
                        echo $tid;
                        echo self::bt_add_ticket_page();
                    }

                else{
                        /* View projects pages */
                  if( isset( $_GET['pid'] ) ) {
                    $p = $_GET['pid'];
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'projects';
                    //$result = $wpdb->get_results( "SELECT * FROM $table_name where p_key = '$p'" );
                    foreach ( $result as $print ) {
                        ?>  <h1><center><?php echo $print->p_name; ?></center></h1>
                            <hr/>
                            <div class="div1">
                                <table>
                                    <tr>
                                      <Th COLSPAN="2">
                                            <h3><BR>Project Detils </h3>
                                     </Th>  

                                    </tr>
                                    <tr>
                                            <tr>
                                                    <td> Project id:</td>
                                                    <td><?php echo $print->id; ?></td>
                                            </tr>
                                            <tr>
                                                    <td> Project name:</td>
                                                    <td><?php echo $print->p_name; ?></td>
                                            </tr>
                                            <tr>
                                                    <td> Description: </td>
                                                    <td><?php echo $print->p_description; ?></td>
                                            </tr>
                                            <tr>
                                                    <td>URL:</td>
                                                    <td><?php echo $print->p_url; ?></td>
                                            </tr>
                                            <tr>
                                                    <td> Access:</td>
                                                    <td><?php echo $print->p_public; ?></td>
                                            </tr>
                                            <tr>
                                                    <td> Project type:</td>
                                                    <td><?php echo $print->p_type; ?></td>
                                            </tr>
                                            <tr>
                                                    <td>Status:</td>
                                                    <td><?php echo $print->p_status; ?></td>
                                            </tr>
                                            <tr>
                                                    <td> Assignee:</td>
                                                    <td><?php echo $print->p_assignee; ?></td>
                                            </tr>
                                            <tr>
                                                    <td> Reporter:</td>
                                                    <td><?php echo $print->p_reporter; ?></td>
                                            </tr>
                                    </tr>
                                </table>
                            </div>
                            
                             
                             
                        <?php
                    }

                    echo'<div class ="div2">
                    <center> <h2> Projects Tickets </h2></center>
                        <table>
                            <tr>
                                    <th>Ticket name</th>
                                    <th>Ticket Description</th>
                                    <th>Ticket Status</th>
                                    <th>Ticket Assignee</th>
                            </tr>';
                                 
                                         global $wpdb;
                                         $table_name = $wpdb->prefix . 'projects_ticket';
                                         $result = $wpdb->get_results( "SELECT * FROM $table_name where p_key = '$p'" );
                                         foreach ( $result as $print ) { 

                                                   ?>
                                                   <tr>
                                                        <td><?php echo $print->p_ticket_name; ?></td>

                                                        <td><?php echo $print->ticket_description; ?></td>

                                                        <td><?php echo $print->p_ticket_status; ?></td>

                                                        <td><?php echo $print->p_ticket_assignee; ?></td>

                                                        <td><a href=" <?php echo get_admin_url();?>admin.php?page=projects&pid=<?php echo $print->p_key;?>&tvid=view ticket"><input type="button" class="edit-proj_type" value="View Ticket" id="view_'.$print->id;.'" /></td>

                                                        <td><a href=" <?php echo get_admin_url();?>admin.php?page=projects&pid=<?php echo $print->p_key;?>&tvid=edit ticket"><input type="button" class="edit-proj_type" value="Edit Ticket" id="edit_'.$print->id;.'" /></td>
                                                    </tr>
                                                <?php
                                            }
                                            ?>
                            
                        </table>
                        
                            <a href=" <?php echo get_admin_url();?>admin.php?page=projects&pid=<?php echo $print->p_key;?>&tid=add ticket"><input type="button" class="edit-proj_type" value="Add New Tickets" id="view_'.$print->id;.'" /></a> 
                        </div>
                        <div class="div3">
                            <h2> Project peoples:-</h2>
                            <p> Here details of people related to this project</p>

                            <h4> Project Reporter:-</h4><?php echo $print->p_reporter; ?>
                            <h4> Project Assignee:-</h4><?php echo $print->p_assignee; ?>
                        </div>
                         <div class="div3">
                            <h2> Project Description:-</h2>
                            <p> Hrer Description abuot project.</p>
                            <?php echo $print->p_description; ?>
                        </div>
                        <div class="div3">
                            <h2> Project commnets:-</h2>
                            <p>commnets of projects will be here.</p>
                        </div>
                        <div class="div3">
                            <h2> Project Attachments:-</h2>
                            <p>Project file Attachments will be  here.</p>
                        </div>
                        <div class="div3">
                            <h2> Project Current Branch:-</h2>
                            <p>Here branch name where is the current development is gooing.</p>
                        </div>

                     <?php
                }
                    

                /* Edit project pages */
                elseif( isset( $_GET['eid'] ) ){
                    $eid = $_GET['eid'];
                    echo '<h1>Edit Project</h1>';
                    echo '<h2>'; echo $eid; echo '</h2>';
                    self::bt_admin_add_project_form();
                }
                else{                   
                        global $wpdb;
                        $table_name = $wpdb->prefix . 'projects';
                        $result = $wpdb->get_results( "SELECT * FROM $table_name" );
                        echo'<table class="container">
                            <thead>
                                <tr>
                                        <th><h1>S.NO</h1></th>
                                        <th><h1>Title</h1></th>
                                        <th><h1>Description</h1></th>
                                        <th><h1>URL</h1></th>
                                        <th><h1>Access</h1></th>
                                        <th><h1>Project type</h1></th>
                                        <th><h1>Status</h1></th>
                                        <th><h1>Assignee</h1></th>
                                        <th><h1>Reporter</h1></th>
                                        <th><h1>Edit</h1></th>
                                        <th><h1>view</h1></th>
                                        
                                </tr>
                            </thead>';
                            foreach ( $result as $print )   {
                                    ?> 
                                    <tr>
                                            <td><?php echo $print->id; ?></td>

                                            <td><?php echo $print->p_name; ?></td>

                                            <td><?php echo $print->p_description; ?></td>

                                            <td><?php echo $print->p_url; ?></td>

                                            <td><?php echo $print->p_public; ?></td>

                                            <td><?php echo $print->p_type; ?></td>

                                            <td><?php echo $print->p_status; ?></td>

                                            <td><?php echo $print->p_assignee; ?></td>

                                            <td><?php echo $print->p_reporter; ?></td>

                                            <td><a href=" <?php echo get_admin_url();?>admin.php?page=projects&eid=<?php echo $print->p_key; ?>"><input type="button" class="edit-proj_type" value="Edit" id="edit_'.$print->id;.'" /></a></td>

                                            <td><a href=" <?php echo get_admin_url();?>admin.php?page=projects&pid=<?php echo $print->p_key; ?>"><input type="button" class="edit-proj_type" value="View" id="view_'.$print->id;.'" /></a></td>
                                    </tr>
                                  <?php 
                                   }
                               }

                        echo'</table>';
                        } 
                 }
    }
    /* Viwe ticket page*/

    public static function bt_view_ticket_pages() {
        if( !current_user_can( 'manage_options' ) ) {
            wp_die( __( 'you do not have sufficient permission to  access this page.' ) );
        }
        echo "here you can see the  ticket detalis";
        $pid = $_GET['pid'];
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects_ticket';
        $result = $wpdb->get_results( "SELECT * FROM $table_name where p_key = '$pid'" );
            foreach ( $result as $print ) { 

                        ?> <hr/>
                        <div class ="divticket"><center> <h2> Projects Ticket:- <?php echo $print->p_ticket_key; ?> </h2></center>

                             <div class="div1">
                                <table>
                                    <Th COLSPAN="2">
                                        <h3>Ticket Detils </h3>
                                    </Th>
                                        
                                        
                                        <tr>
                                                <td> ticket id:</td>
                                                <td><?php echo $print->id; ?></td>
                                        </tr>
                                        <tr>
                                                <td> Ticket name:</td>
                                                <td><?php echo $print->p_ticket_name; ?></td>
                                        </tr>
                                        <tr>
                                                <td> Description: </td>
                                                <td><?php echo $print->ticket_description;; ?></td>
                                        </tr>
                                 </table>
                             </div>
                         
                             <div style="float:right;" class="">
                             <?php 
                             self:: bt_view_comments();

                             ?>    
                            </div>
                        </div>
                          <?php
                      }
    
}
            /** View ticket page end**/
 /* function View comment */
    public static function bt_view_comments(){
        if( !current_user_can( 'manage_options' ) ){
            wp_die( __( 'you do not have sufficient permission to access this page.' ) );
        }
        echo"you can view the comment here and ";
        self::bt_add_comments();

    }


 /* End function view comment */ 

 /* Function add comments */
    Public static function bt_add_comments(){
        if( !current_user_can( 'manage_options' ) ){
            wp_die( __ ( ' you do not have sufficient permission to access this page.' ) ); 
        }
        global $wpdb;
        $table_name = $wpdb->prefix . 'project_ticket_comments';
        /*$result = $wpdb->get_results( "SELECT 'p_ticket_name' FROM $table_name where p_key = '$pid'");
         foreach ( $result as $print ) {
            echo $print;
         }*/
        $p_ticket_name= 'p_ticket_name';
        //echo $result; 
        


        if( isset( $_POST['comment_submit'] ) ) {
            $ticket_comments    = $_POST['ticket_comments'];


            $proj_save = $wpdb->insert( 
                    $table_name, 
                    array(
                        't_discription_key'     => '',
                        'p_ticket_key'          => $p_ticket_name,
                        'ticket_description'    => $ticket_comments, 
                        ), 
                    array( 
                        '%s', 
                        '%s',
                        '%s',
                        ) 
                );

                if ( $proj_save === false ) {
                    self::$msg          = 'Something went wrong. Please try again.';
                    self::$msg_class    = 'error';
                } else {
                    self::$msg          = 'Added new ticket!!';
                    self::$msg_class    = 'success';
                }
        }
        echo "you can add new commnets";
        echo '<div class="notice-tracker msg_'.self::$msg_class.'" ><span>'.self::$msg.'</span></div>';
        echo '<form method="post" class="" >';
        echo '<div class="">';
        $form_box = self::bt_admin_commment_input();
        $html = '';
        $data = '';
        if ( !empty ( $form_box ) ) {
            foreach ( $form_box as $form => $value ) {

                switch ( $value['type'] ) {
                    case 'textarea':
                        $html .= '<p><label class = "label_textarea label">' . $value['label'] . '</label>';
                        $html .= '<span class="'.$value['validate'].'"></span>';
                        $html .= '<textarea id="' . esc_attr( $value['id'] ) . '" rows="5" cols="100" name="' . esc_attr(
                                $value['id'] ) . '" placeholder="' . esc_attr( $value['placeholder'] ) . '" 
                                class="form-textarea">' . $data . '</textarea></p>'. "\n";
                        break;

                }
            }
            $html .= '<input type="submit" id="comment" class="button button-primary button-large commentb" value="Add Comment" name="comment_submit" />';
            echo $html;
        }
        echo '</div>';
        echo '</form>';

    } 
 /* End function add comments*/ 

    public static function bt_add_ticket_page() {
        if( !current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permission to access this page.' ) );
        }
        echo"Here you can add new ticket";
        self::bt_admin_add_ticket_form();
    }
   
    public static function bt_project_page() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<div class="wrap">';
        echo '<p>Here is where the form would go if I actually had options.</p>';
        echo '</div>';
    }

    public static function bt_add_project_page() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<h1>Add New Project</h1>';
        self::bt_admin_add_project_form();
    }

    public static function bt_add_project_type() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        echo '<h1>Add Project Type</h1>';
        self::bt_admin_add_project_type();
    }
    
    public static function bt_admin_add_project_form() {
        global $wpdb;
       // $table_name = $wpdb->prefix . 'projects';
         if( isset( $_POST['proj_submit'] ) ) {
           if ( isset( $_POST['project_title'] ) && !empty( $_POST['project_title'] ) ) {
                $proj_title    = $_POST['project_title'];
                $proj_desc     = $_POST['project_description'];
                $proj_hpage    = $_POST['project_home_page'];
                $proj_public   = $_POST['project_public'];
                $proj_type     = $_POST['project_type'];
                $proj_status   = $_POST['project_status'];
                $proj_assignee = $_POST['project_Assignee'];
                $proj_reporter = $_POST['project_reporter'];
                $proj_key      = preg_replace( '/\s+/', '_', strtolower( $proj_title ) );
                
               
               
                $proj_save =  wp_insert_post( 
                    array(
                        'post_type'         => 'project',
                        'post_title'        => $proj_title,
                        'post_content'      => $proj_desc, 
                        'ping_status'       => $proj_public,
                        'post_status'       => $proj_status,
                        'meta_input'    => array(
                                    'proj_key'      => $proj_key,
                                    'assignee'      => $proj_assignee,
                                    'reporter'      =>  $proj_reporter,
                                    'poj_url'       => $proj_hpage,
                                    'project_type'  => $proj_type,
                                    
                                ))
                         
                   
                );

                if ( $proj_save === false ) {
                    self::$msg          = 'Something went wrong. Please try again.';
                    self::$msg_class    = 'error';
                } else {
                    self::$msg          = 'Added new project!!';
                    self::$msg_class    = 'success';
                }
            }

       }
        echo '<div class="notice-tracker msg_'.self::$msg_class.'" ><span>'.self::$msg.'</span></div>';
        echo '<form method="post" class="admin-add-project-form" >';
        echo '<div class="box">';
        $form_box = self::bt_admin_form_input();
        $html = '';
        $data = '';
        if ( !empty ( $form_box ) ) {
            foreach ( $form_box as $form => $value ) {

                switch ( $value['type'] ) {
                    case 'text':
                    case 'password':
                    case 'number':
	                    $html .= '<p><label class = "label_input label">' . $value['label'] . '</label>';

	                    $html .= '<span class="'.$value['validate'].'"></span>';

                        $html .= '<input id="' . esc_attr( $value['id'] ) . '" type="' . $value['type'] . '" name="' .
                                 esc_attr( $value['id'] ) . '"  value="' . esc_attr( $data ) . '" 
                                 class="form-input"/></p>' . "\n";
                        break;

                    case 'textarea':
	                    $html .= '<p><label class = "label_textarea label">' . $value['label'] . '</label>';
	                    $html .= '<span class="'.$value['validate'].'"></span>';
                        $html .= '<textarea id="' . esc_attr( $value['id'] ) . '" rows="5" cols="50" name="' . esc_attr(
                                $value['id'] ) . '" placeholder="' . esc_attr( $value['placeholder'] ) . '" 
                                class="form-textarea">' . $data . '</textarea></p>'. "\n";
                        break;

                    case 'checkbox':
                        $checked = '';
                        if ( $data && 'on' == $data ){
                            $checked = 'checked="checked"';
                        }
	                    $html .= '<p><label class = "label_checkbox label">' . $value['label'] . '</label>';
	                    $html .= '<span class="'.$value['validate'].'"></span>';
                        $html .= '<input id="' . esc_attr( $value['id'] ) . '" type="' . $value['type'] . '" name="' .
                                 esc_attr( $value['id'] ) . '" ' . $checked . ' class="form-checkbox"/></p>' . "\n";
                        break;

                    case 'checkbox_multi':
                        foreach ( $value['options'] as $k => $v ) {
                            $checked = false;
                            if ( in_array( $k, (array) $data ) ) {
                                $checked = true;
                            }
	                        $html .= '<p><label class = "label_select label" for="' . esc_attr( $value['id'] . '_' . $k ) .
	                                 '">' . $value['label'] . '</label>';
	                        $html .= '<span class="'.$value['validate'].'"></span>';
                            $html .= '<input type="checkbox" '
                                     . checked( $checked, true, false ) . ' name="' . esc_attr( $value['id'] ) . '[]" 
                                     value="' . esc_attr( $k ) . '" id="' . esc_attr( $value['id'] . '_' . $k ) . '" 
                                     class="form-checkbox" /></p>';
                        }
                        break;

                    case 'radio':
                        foreach ( $value['options'] as $k => $v ) {
                            $checked = false;
                            if ( $k == $data ) {
                                $checked = true;
                            }
	                        $html .= '<p><label class = "label_select label" for="' . esc_attr( $value['id'] . '_' . $k ) .
	                                 '">' . $value['label'] . '</label>';
	                        $html .= '<span class="'.$value['validate'].'"></span>';
                            $html .= '<input type="radio" ' .
                                     checked( $checked, true, false ) . ' name="' . esc_attr( $value['id'] ) . '" 
                                     value="' . esc_attr( $k ) . '" id="' . esc_attr( $value['id'] . '_' . $k ) . '" 
                                     class="form-radio" /></p>';
                        }
                        break;

                   
                    case 'select':
                        $html .= '<p><label class = "label_select label">' . $value['label'] . '</label>';
                        $html .= '<span class="'.$value['validate'].'"></span>';
                        $html .= '<select name="' . esc_attr( $value['id'] ) . '" id="' . esc_attr( $value['id'] ) . '" 
                        class="form-select">';

                        foreach ( $value['choices'] as $choice => $val ) {
                            $html .= '<option value="' . esc_attr( $choice ) . '">' . esc_html( $val ) . '</option>';
                        }
                        $html .= '</select></p>';

                        break;    
                }
            }
	        $html .= '<input type="submit" class="button button-primary button-large" value="Save" name="proj_submit" />';
            echo $html;

        }

        echo '</div>';
        echo '</form>';
    }

    /*  Add ticket from */

    public static function bt_admin_add_ticket_form() {
        global $wpdb;
        //$table_name = $wpdb->prefix . 'projects_ticket';


        if( isset( $_POST['proj_submit'] ) ) {
           if ( isset( $_POST['project_title'] ) && !empty( $_POST['project_title'] ) ) {
                $proj_key          = $_POST['project_key'];
                $proj_ticket_title = $_POST['project_title'];
                $proj_desc         = $_POST['project_description'];
                $proj_status       = $_POST['project_ticket_status'];
                $proj_assignee     = $_POST['project_Assignee'];
                $proj_ticket_key   = preg_replace( '/\s+/', '_', strtolower( $proj_ticket_title ) );
                
               
               
                $proj_save = wp_insert_post( 
                     
                    array(
                        'post_type'          => 'ticket',   
                        'p_ticket_key'       => $proj_ticket_ey,
                        'p_key'              => $proj_key,
                        'p_ticket_name'      => $proj_ticket_title,
                        'ticket_description' => $proj_desc, 
                        'p_ticket_status'    => $proj_status,
                        'p_ticket_assignee'  => $proj_assignee,

                        )
                );

                if ( $proj_save === false ) {
                    self::$msg          = 'Something went wrong. Please try again.';
                    self::$msg_class    = 'error';
                } else {
                    self::$msg          = 'Added new Ticket!!';
                    self::$msg_class    = 'success';
                }
            }
    }
        echo '<div class="notice-tracker msg_'.self::$msg_class.'" ><span>'.self::$msg.'</span></div>';
        echo '<form method="post" class="admin-add-project-form" >';
        echo '<div class="box">';
        $form_box = self::bt_admin_ticket_form_input();
        $html = '';
        $data = '';
        if ( !empty ( $form_box ) ) {
            foreach ( $form_box as $form => $value ) {

                switch ( $value['type'] ) {
                    case 'text':
                    case 'password':
                    case 'number':
                        $html .= '<p><label class = "label_input label">' . $value['label'] . '</label>';

                        $html .= '<span class="'.$value['validate'].'"></span>';

                        $html .= '<input id="' . esc_attr( $value['id'] ) . '" type="' . $value['type'] . '" name="' .
                                 esc_attr( $value['id'] ) . '" value="' . esc_attr( $value['data'] )  . '" 
                                 class="form-input"/></p>' . "\n";
                        break;

                    case 'textarea':
                        $html .= '<p><label class = "label_textarea label">' . $value['label'] . '</label>';
                        $html .= '<span class="'.$value['validate'].'"></span>';
                        $html .= '<textarea id="' . esc_attr( $value['id'] ) . '" rows="5" cols="50" name="' . esc_attr(
                                $value['id'] ) . '" placeholder="' . esc_attr( $value['placeholder'] ) . '" 
                                class="form-textarea">' . $data . '</textarea></p>'. "\n";
                        break;

                    case 'checkbox':
                        $checked = '';
                        if ( $data && 'on' == $data ){
                            $checked = 'checked="checked"';
                        }
                        $html .= '<p><label class = "label_checkbox label">' . $value['label'] . '</label>';
                        $html .= '<span class="'.$value['validate'].'"></span>';
                        $html .= '<input id="' . esc_attr( $value['id'] ) . '" type="' . $value['type'] . '" name="' .
                                 esc_attr( $value['id'] ) . '" ' . $checked . ' class="form-checkbox"/></p>' . "\n";
                        break;

                    case 'checkbox_multi':
                        foreach ( $value['options'] as $k => $v ) {
                            $checked = false;
                            if ( in_array( $k, (array) $data ) ) {
                                $checked = true;
                            }
                            $html .= '<p><label class = "label_select label" for="' . esc_attr( $value['id'] . '_' . $k ) .
                                     '">' . $value['label'] . '</label>';
                            $html .= '<span class="'.$value['validate'].'"></span>';
                            $html .= '<input type="checkbox" '
                                     . checked( $checked, true, false ) . ' name="' . esc_attr( $value['id'] ) . '[]" 
                                     value="' . esc_attr( $k ) . '" id="' . esc_attr( $value['id'] . '_' . $k ) . '" 
                                     class="form-checkbox" /></p>';
                        }
                        break;

                    case 'radio':
                        foreach ( $value['options'] as $k => $v ) {
                            $checked = false;
                            if ( $k == $data ) {
                                $checked = true;
                            }
                            $html .= '<p><label class = "label_select label" for="' . esc_attr( $value['id'] . '_' . $k ) .
                                     '">' . $value['label'] . '</label>';
                            $html .= '<span class="'.$value['validate'].'"></span>';
                            $html .= '<input type="radio" ' .
                                     checked( $checked, true, false ) . ' name="' . esc_attr( $value['id'] ) . '" 
                                     value="' . esc_attr( $k ) . '" id="' . esc_attr( $value['id'] . '_' . $k ) . '" 
                                     class="form-radio" /></p>';
                        }
                        break;

                   
                    case 'select':
                        $html .= '<p><label class = "label_select label">' . $value['label'] . '</label>';
                        $html .= '<span class="'.$value['validate'].'"></span>';
                        $html .= '<select name="' . esc_attr( $value['id'] ) . '" id="' . esc_attr( $value['id'] ) . '" 
                        class="form-select">';

                        foreach ( $value['choices'] as $choice => $val ) {
                            $html .= '<option value="' . esc_attr( $choice ) . '">' . esc_html( $val ) . '</option>';
                        }
                        $html .= '</select></p>';

                        break;    
                }
            }
            $html .= '<input type="submit" class="button button-primary button-large" value="Save" name="proj_submit" />';
            echo $html;

        }

        echo '</div>';
        echo '</form>';
    }
    /****************************************************/
    public static function bt_admin_form_input() {
          global $wpdb;

        self::$form_options['project_title'] = array(
            'section'       => 'form',
            'id'            => 'project_title',
            'label'         => esc_html__( 'Name', 'bug-tracker' ),
            'description'   => esc_html__( 'Add project name.', 'bug-tracker' ),
            'type'          => 'text',
            'validate'      => 'required',
            'placeholder'   => esc_html__( 'Project Name', 'bug-tracker' ),
        );

        self::$form_options['project_description'] = array(
            'section'       => 'form',
            'id'            => 'project_description',
            'label'         => esc_html__( 'Description', 'bug-tracker' ),
            'type'          => 'textarea',
            'validate'      => 'required',
            'placeholder'   => esc_html__( 'Description....', 'bug-tracker' ),
        );

        self::$form_options['project_home_page'] = array(
            'section'       => 'form',
            'label'         => esc_html__( 'Home Page', 'bug-tracker' ),
            'id'            => 'project_home_page',
            'type'          => 'text',
            'validate'      => 'required',
        );

        self::$form_options['project_public'] = array(
            'section'       => 'form',
            'label'         => esc_html__( 'Public', 'bug-tracker' ),
            'id'            => 'project_public',
            'type'          => 'checkbox',
            'validate'      => 'required',
        );

        $project_type_data = $wpdb->get_results( "SELECT ptype_key, ptype_name FROM wp_project_type", ARRAY_A );

        if( !empty( $project_type_data ) ):
            foreach( $project_type_data as $project_type_val ) {
                $a_key = $project_type_val['ptype_key'];
                $b_val = $project_type_val['ptype_name']; 
                self::$project_type[$a_key] = $b_val;
             }
        endif;
        
            self::$form_options['project_type'] = array(
            'section'   => 'form',
            'label'     => esc_html__( 'Project Type', 'bug-tracker' ),
            'type'      => 'select',
            'choices'   => self::$project_type,
            'id'        => 'project_type',
            'std'       => 1,
            'validate'  => 'required',
        );
                    $project_status_data = $wpdb->get_results( "SELECT p_satuts_key, p_status FROM  wp_projects_status", ARRAY_A );

        if( !empty( $project_status_data ) ):
            foreach( $project_status_data as $project_status_val ) {
                $a_key = $project_status_val['p_satuts_key'];
                $b_val = $project_status_val['p_status']; 
                self::$project_status[$a_key] = $b_val;
            }
        endif;
        
            self::$form_options['project_status'] = array(
            'section'  => 'form',
            'label'    => esc_html__( 'Project Status', 'bug-tracker' ),
            'type'     => 'select',
            'choices'  => self::$project_status,
            'id'       => 'project_status',
            'std'      => 2,
            'validate' => 'required',
        );
             $project_assignee_data = $wpdb->get_results( "SELECT ID, user_nicename FROM wp_users", ARRAY_A );

        if( !empty( $project_assignee_data ) ):
            foreach( $project_assignee_data as $project_assignee_val ) {
                $a_key = $project_assignee_val['user_nicename'];
                $b_val = $project_assignee_val['user_nicename'];
                self::$project_assignee[$a_key] = $b_val;
            }
        endif;
        
            self::$form_options['project_Assignee'] = array(
            'section'   => 'form',
            'label'     => esc_html__( 'Project Assignee', 'bug-tracker' ),
            'type'      => 'select',
            'choices'   => self::$project_assignee,
            'id'        => 'project_Assignee',
            'std'       => 3,
            'validate'  => 'required',
        );
          
          $project_reporter_data = $wpdb->get_results( "SELECT ID, user_nicename FROM wp_users", ARRAY_A );

        if( !empty( $project_reporter_data ) ):
            foreach( $project_reporter_data as $project_reporter_val ) {
                $a_key = $project_reporter_val['user_nicename']; 
                $b_val = $project_reporter_val['user_nicename']; 
                self::$project_reporter[$a_key] = $b_val;
            }
        endif;
        
            self::$form_options['project_reporter'] = array(
            'section'  => 'form',
            'label'    => esc_html__( 'Project Reporter', 'bug-tracker' ),
            'type'     => 'select',
            'choices'  => self::$project_reporter,
            'id'       => 'project_reporter',
            'std'      => 4,
            'validate' => 'required',
        );  
        
            return self::$form_options;
        }

    /* ticket input from */
    public static function bt_admin_ticket_form_input() {
        global $wpdb;

        if( isset( $_GET['pid'] ) ) {
            $pid = $_GET['pid'];
        } else {
            $pid = '';
        }

        self::$form_options['project_key'] = array(
            'section'       => 'form',
            'id'            => 'project_key',
            'label'         => esc_html__( 'p_key', 'bug-tracker' ),
            'description'   => esc_html__( 'project key.', 'bug-tracker' ),
            'type'          => 'text',
            'data'          => $pid,
            'validate'      => 'required',
            'placeholder'   => esc_html__( 'Project key', 'bug-tracker' ),
        );

        self::$form_options['project_title'] = array(
            'section'       => 'form',
            'id'            => 'project_title',
            'label'         => esc_html__( 'Name', 'bug-tracker' ),
            'description'   => esc_html__( 'Add project name.', 'bug-tracker' ),
            'type'          => 'text',
            'validate'      => 'required',
            'placeholder'   => esc_html__( 'Project Name', 'bug-tracker' ),
        );

        self::$form_options['project_title'] = array(
            'section'       => 'form',
            'id'            => 'project_title',
            'label'         => esc_html__( 'Name', 'bug-tracker' ),
            'description'   => esc_html__( 'Add project name.', 'bug-tracker' ),
            'type'          => 'text',
            'validate'      => 'required',
            'placeholder'   => esc_html__( 'Project Name', 'bug-tracker' ),
        );

        self::$form_options['project_description'] = array(
            'section'       => 'form',
            'id'            => 'project_description',
            'label'         => esc_html__( 'Description', 'bug-tracker' ),
            'type'          => 'textarea',
            'validate'      => 'required',
            'placeholder'   => esc_html__( 'Description....', 'bug-tracker' ),
        );

                     $project_status_data = $wpdb->get_results( "SELECT  p_ticket_key, p_ticket_status FROM  wp_projects_ticket_status", ARRAY_A );

        if( !empty( $project_status_data ) ):
            foreach( $project_status_data as $project_status_val ) {
                $a_key = $project_status_val['p_ticket_key'];
                $b_val = $project_status_val['p_ticket_status']; 
                self::$project_ticket_status[$a_key] = $b_val;
            }
        endif;
        
            self::$form_options['$project_ticket_status'] = array(
            'section'   => 'form',
            'label'     => esc_html__( 'Ticket status', 'bug-tracker' ),
            'type'      => 'select',
            'choices'   => self::$project_ticket_status,
            'id'        => 'project_ticket_status',
            'std'       => 1,
            'validate'  => 'required',
        );
             $project_assignee_data = $wpdb->get_results( "SELECT ID, user_nicename FROM wp_users", ARRAY_A );

        if( !empty( $project_assignee_data ) ):
            foreach( $project_assignee_data as $project_assignee_val ) {
                $a_key = $project_assignee_val['user_nicename'];
                $b_val = $project_assignee_val['user_nicename'];
                self::$project_assignee[$a_key] = $b_val;
            }
        endif;
        
            self::$form_options['project_Assignee'] = array(
            'section'  => 'form',
            'label'    => esc_html__( 'Ticket Assignee', 'bug-tracker' ),
            'type'     => 'select',
            'choices'  => self::$project_assignee,
            'id'       => 'project_Assignee',
            'std'      => 2,
            'validate' => 'required',
        );
          
          return self::$form_options;
     }

     /* comments input fields*/
     public static function bt_admin_commment_input(){
        global $wpdb;
        self::$form_options['ticket_comments'] = array(
            'section'       => 'form',
            'id'            => 'ticket_comments',
            'label'         => esc_html__( '', 'bug-tracker' ),
            'type'          => 'textarea',
            'validate'      => 'required',
            'placeholder'   => esc_html__( 'Here add More Ticket comments....', 'bug-tracker' ),
        );
         return self::$form_options;


     }
     /* comments inputs fields end*/ 

    /***********************************************************************************************************************************/

    public static function bt_admin_add_project_type() {

        global $wpdb;

        //$table_name = $wpdb->prefix . 'project_type';

        if( isset( $_POST['proj_type_submit'] ) ) {
            if ( isset( $_POST['add_pro_type'] ) && !empty( $_POST['add_pro_type'] ) ) {
                $proj_type_name = $_POST['add_pro_type'];
                $proj_type_key  = preg_replace( '/\s+/', '_', strtolower( $proj_type_name ) );
                 $proj_type_save = $wpdb->insert( 
                    $table_name,
                    array(
                        'ptype_key' => $proj_type_key, 
                        'ptype_name'     => $proj_type_name,
                        )
                    
                );

                if ( $proj_type_save === false ) {
                    self::$msg          = 'Something went wrong. Please try again.';
                    self::$msg_class    = 'error';
                } else {
                    self::$msg          = 'Added new project type!!';
                    self::$msg_class    = 'success';
                }
            }
        }
        /*$id = wp_insert_post(array('post_title'=>'random', 'post_type'=>'custom_post', 'post_content'=>'demo text'));*/
                
        /* Project type status*/
         $table_name = $wpdb->prefix . 'projects_status';

        if( isset( $_POST['proj_status_submit'] ) ) {
            if ( isset( $_POST['add_pro_status'] ) && !empty( $_POST['add_pro_status'] ) ) {
                $proj_type_name = $_POST['add_pro_status'];
                $proj_type_key  = preg_replace( '/\s+/', '_', strtolower( $proj_type_name ) );
                $proj_type_save = $wpdb->insert( 
                    $table_name, 
                    array( 
                        'p_satuts_key' => $proj_type_key, 
                        'p_status'     => $proj_type_name,
                    ), 
                    array( 
                        '%s', 
                        '%s',
                    ) 
                );

                if ( $proj_type_save === false ) {
                    self::$msg          = 'Something went wrong. Please try again.';
                    self::$msg_class    = 'error';
                } else {
                    self::$msg          = 'Added new project type!!';
                    self::$msg_class    = 'success';
                }
            }
        }

         /* Project ticket status*/
         $table_name = $wpdb->prefix . 'projects_ticket_status';

        if( isset( $_POST['proj_ticket_submit'] ) ) {
            if ( isset( $_POST['add_pro_ticket'] ) && !empty( $_POST['add_pro_ticket'] ) ) {
                $proj_type_name = $_POST['add_pro_ticket'];
                $proj_type_key  = preg_replace( '/\s+/', '_', strtolower( $proj_type_name ) );
                $proj_type_save = $wpdb->wp_insert_pos( 
                    $table_name, 
                    array( 
                        'p_ticket_key'    => $proj_type_key, 
                        'p_ticket_status' => $proj_type_name,
                    ), 
                    array( 
                        '%s', 
                        '%s',
                    ) 
                );

                if ( $proj_type_save === false ) {
                    self::$msg          = 'Something went wrong. Please try again.';
                    self::$msg_class    = 'error';
                } else {
                    self::$msg          = 'Added new project type!!';
                    self::$msg_class    = 'success';
                }
            }
        }
        echo'<div id="statictabs" class="tabs">
        <ul>
            <li><a class="" href="#statictabs-1">Add Project Type</a></li>
            <li><a class="" href="#statictabs-2">Add Project Status</a></li>
            <li><a class="" href="#statictabs-3">Add ticket status</a></li>
        </ul>';
        echo'<div id="statictabs-1" >';
        echo '<form method="post" class="add_project_type">';
            echo '<div class="notice-tracker msg_'.self::$msg_class.'" ><span>'.self::$msg.'</span></div>';
            echo '<div class="div_proj_type">';
                echo '<div class="div_add_proj_type">';
                    echo '<input type="text" name="add_pro_type" class="input_add_pro_type" />';
                    echo '<input type="submit" class="button button-primary button-large" value="Add" 
                        name="proj_type_submit" />';
                echo '</div>';
                echo '<div class="div_list_proj_type">';
                    $proj_types = get_project_type();
                    if ( !empty( $proj_types ) ) {
                        foreach( $proj_types as $pro_type ){
                            echo '<div class="div-disply-type">';
                            echo '<input readonly type="text" class="display_proj_type" name="'.$pro_type->ptype_key.'" value="'.$pro_type->ptype_name.'" id="'.$pro_type->ptype_key.'" />';
                            echo '<input type="button" class="edit-proj_type" value="Edit" id="edit_'.$pro_type->id.'" onclick="edit_row('.$pro_type->id.');"/>';
                            echo '<input type="button" class="del-proj_type" value="Delete" id="del_'.$pro_type->id.'" onclick="delete_row('.$pro_type->id.');"/>';
                            echo '<input type="button" class="edit-proj_type" value="save" id="save_'.$pro_type->id.'" onclick="save_row('.$pro_type->id.');"/>';

                            echo '</div>';
                        }


                    }
                echo '</div>';
            echo '</div>';
        echo '</form>';
        echo '</div>';

        /* project status from */
        echo'<div id="statictabs-2">';
        echo'<h1>Add Project Status</h1>';
        echo '<form method="post" class="add_project_type">';
            echo '<div class="notice-tracker msg_'.self::$msg_class.'" ><span>'.self::$msg.'</span></div>';
            echo '<div class="div_proj_type">';
                echo '<div class="div_add_proj_ststus">';
                    echo '<input type="text" name="add_pro_status" class="input_add_pro_type" />';
                    echo '<input type="submit" class="button button-primary button-large" value="Add" 
                        name="proj_status_submit" />';
                echo '</div>';
                echo '<div class="div_list_proj_type">';
                    $proj_types = get_project_status();
                    if ( !empty( $proj_types ) ) {
                        foreach( $proj_types as $pro_type ){
                            echo '<div class="div-disply-type">';
                            echo '<input readonly type="text" class="display_proj_type" name="'.$pro_type->p_satuts_key.'" value="'.$pro_type->p_status.'" id="'.$pro_type->p_satuts_key.'" />';
                            echo '<input type="button" class="edit-proj_type" value="Edit" id="edit_'.$pro_type->id.'" onclick="edit_row('.$pro_type->id.');"/>';
                            echo '<input type="button" class="del-proj_type" value="Delete" id="del_'.$pro_type->id.'" onclick="delete_row('.$pro_type->id.');"/>';
                            echo '<input type="button" class="edit-proj_type" value="save" id="save_'.$pro_type->id.'" onclick="save_row('.$pro_type->id.');"/>';

                            echo '</div>';
                        }


                    }
                echo '</div>';
            echo '</div>';
        echo '</form>';
        echo '</div>';

        /* ticket status from*/
        echo'<div id="statictabs-3">';
        echo'<h1>Add ticket status</h1>';
        echo '<form method="post" class="add_project_ticket">';
            echo '<div class="notice-tracker msg_'.self::$msg_class.'" ><span>'.self::$msg.'</span></div>';
            echo '<div class="div_proj_type">';
                echo '<div class="div_add_proj_type">';
                    echo '<input type="text" name="add_pro_ticket" class="input_add_pro_type" />';
                    echo '<input type="submit" class="button button-primary button-large" value="Add" 
                        name="proj_ticket_submit" />';
                echo '</div>';
                echo '<div class="div_list_proj_type">';
                    $proj_types = get_project_ticket();
                    if ( !empty( $proj_types ) ) {
                        foreach( $proj_types as $pro_type ){
                            echo '<div class="div-disply-type">';
                            echo '<input readonly type="text" class="display_proj_type" name="'.$pro_type->p_ticket_key.'" value="'.$pro_type->p_ticket_status.'" id="'.$pro_type->p_ticket_key.'" />';
                            echo '<input type="button" class="edit-proj_type" value="Edit" id="edit_'.$pro_type->id.'" onclick="edit_row('.$pro_type->id.');"/>';
                            echo '<input type="button" class="del-proj_type" value="Delete" id="del_'.$pro_type->id.'" onclick="delete_row('.$pro_type->id.');"/>';
                            echo '<input type="button" class="edit-proj_type" value="save" id="save_'.$pro_type->id.'" onclick="save_row('.$pro_type->id.');"/>';

                            echo '</div>';
                        }
                    }
                echo '</div>';
            echo '</div>';
        echo '</form>';
        echo '</div>';
        echo '</dv>';
    }
    /* Register Stylesheet */
    public static function styles() {
        wp_register_style( 'tb-bug-tracker-form', parent::$plugin_assets . 'css/admin-bug-tracker.css' );
        wp_register_style( 'tb-bug-tracker-form-1', parent::$plugin_assets . 'css/custom-admin.css' );
        wp_enqueue_style( 'tb-bug-tracker-form' );
        wp_enqueue_style( 'tb-bug-tracker-form-1' );
    }

    /* Register Script files */
    public static function scripts() {
        wp_register_script( 'tb-bug-tracker-form-script', parent::$plugin_assets . 'js/admin-bug-tracker.js' );
        wp_register_script( 'tb-bug-tracker-form-script-1', parent::$plugin_assets . 'js/._jquery.min.js' );
        wp_register_script( 'tb-bug-tracker-form-script-2', parent::$plugin_assets . 'js/custom-admin.js' );
        wp_register_script( 'tb-bug-tracker-form-script-3', parent::$plugin_assets . 'js/jquery.min.js' );
        wp_register_script( 'tb-bug-tracker-form-script-4', parent::$plugin_assets . 'js/bt_ajax.js' );
        wp_register_script( 'tb-bug-tracker-form-script-5', parent::$plugin_assets . 'js/fetch_data.js' );
        wp_enqueue_script( 'tb-bug-tracker-form-script' );
        wp_enqueue_script( 'tb-bug-tracker-form-script-1' );
        wp_enqueue_script( 'tb-bug-tracker-form-script-2' );
        wp_enqueue_script( 'tb-bug-tracker-form-script-3' );
        wp_enqueue_script( 'tb-bug-tracker-form-script-4' );
        wp_enqueue_script( 'tb-bug-tracker-form-script-5' );
    }
}