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
            'bt_project_page'));
        add_submenu_page('projects', 'New Project', 'New Project', 'manage_options', 'new-projects', array(__CLASS__,
            'bt_add_project_page'));
        add_submenu_page('projects', 'Project Type', 'Project Type', 'manage_options', 'project-type', array(__CLASS__,
            'bt_add_project_type'));

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
        echo '<h1>Project Type</h1>';
        self::bt_admin_add_project_type();
    }

    public static function bt_admin_add_project_form() {
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
            'id'            => 'project_title',
            'label'         => esc_html__( 'Description', 'bug-tracker' ),
            'type'          => 'textarea',
            'validate'      => '',
            'placeholder'   => esc_html__( 'Description....', 'bug-tracker' ),
        );

        self::$form_options['project_home_page'] = array(
            'section'       => 'form',
            'label'         => esc_html__( 'Home Page', 'bug-tracker' ),
            'id'            => 'project_home_page',
            'type'          => 'text',
            'validate'      => '',
        );

        self::$form_options['project_public'] = array(
            'section'       => 'form',
            'label'         => esc_html__( 'Public', 'bug-tracker' ),
            'id'            => 'project_title',
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
            'section' => 'form',
            'label' => esc_html__( 'Project Type', 'bug-tracker' ),
            'type' => 'select',
            'choices' => self::$project_type,
            'id' => 'project_title',
            'std' => 1,
            'validate'      => '',
        );

        return self::$form_options;
    }

    public static function bt_admin_add_project_type() {

        global $wpdb;

        $table_name = $wpdb->prefix . 'project_type';

        if( isset( $_POST['proj_type_submit'] ) ) {
            if ( isset( $_POST['add_pro_type'] ) && !empty( $_POST['add_pro_type'] ) ) {
                $proj_type_name = $_POST['add_pro_type'];
                $proj_type_key  = preg_replace( '/\s+/', '_', strtolower( $proj_type_name ) );
                $proj_type_save = $wpdb->insert( 
                    $table_name, 
                    array( 
                        'ptype_key' => $proj_type_key, 
                        'ptype_name' => $proj_type_name, 
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
                            echo '<input type="button" class="edit-proj_type" value="Edit" id="edit_'.$pro_type->id.'"/>';
                            echo '<input type="button" class="del-proj_type" value="Delete" id="del_'.$pro_type->id.'"/>';
                            echo '</div>';
                        }

                    }
                echo '</div>';
            echo '</div>';
        echo '</form>';
    }

    /* Register Stylesheet */
    public static function styles() {
        wp_register_style( 'tb-bug-tracker-form', parent::$plugin_assets . 'css/admin-bug-tracker.css' );
        wp_enqueue_style( 'tb-bug-tracker-form' );
    }

    /* Register Script files */
    public static function scripts() {
        wp_register_script( 'tb-bug-tracker-form-script', parent::$plugin_assets . 'js/admin-bug-tracker.js' );
        wp_enqueue_script( 'tb-bug-tracker-form-script' );
    }
}