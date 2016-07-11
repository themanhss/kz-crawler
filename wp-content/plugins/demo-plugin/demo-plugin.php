<?php
	/*
	Plugin Name: Demo Plugin
	Plugin URI:  http://URI_Of_Page_Describing_Plugin_and_Updates
	Description: This describes my plugin in a short sentence
	Version:     1.0.0
	Author:      manhNT
	Author URI:  http://URI_Of_The_Plugin_Author
	License:     GPL2
	License URI: https://www.gnu.org/licenses/gpl-2.0.html
	Domain Path: /languages
	Text Domain: demo-plugin
	*/
	Class demoPlugin
	{
		public function __construct(){
			add_action( 'admin_menu', array($this,'add_my_custom_menu') );
		}
		
 
		public function add_my_custom_menu() {
		    //add an item to the menu
		    add_menu_page(
		        'My Page',
		        'Demo Plugin',
		        'manage_options',
		        'my-page',
		        array($this, 'wporg_options_page'),
		        plugin_dir_url( __FILE__ ).'icons/my_icon.png',
		        '23.56'
		    );

		   
		    add_submenu_page('my-page', 'Custom', 'Custom', 'manage_options', 'my-page/custom', array($this, 'clivern_render_custom_page'));
   			add_submenu_page('my-page', 'About', 'About', 'manage_options', 'my-page/about', array($this, 'clivern_render_about_page'));
		}

		public function wporg_options_page()
		{
			$this->custom_registration_function();
		}

		public function clivern_render_custom_page(){
			   ?>
			   <div class='wrap'>
			    <h2>Custom</h2>
			   </div>
			   <?php
		 }

		 public function clivern_render_about_page(){
		   ?>
		   <div class='wrap'>
		    <h2>About</h2>
		   </div>
		   <?php
		 }


		public function registration_form( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio ) {
		    echo '
		    <style>
		    div {
		        margin-bottom:2px;
		    }
		     
		    input{
		        margin-bottom:4px;
		    }
		    </style>
		    ';
		 
		    echo '
		    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
		    <div>
		    <label for="username">Username <strong>*</strong></label>
		    <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
		    </div>
		     
		    <div>
		    <label for="password">Password <strong>*</strong></label>
		    <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
		    </div>
		     
		    <div>
		    <label for="email">Email <strong>*</strong></label>
		    <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
		    </div>
		     
		    <div>
		    <label for="website">Website</label>
		    <input type="text" name="website" value="' . ( isset( $_POST['website']) ? $website : null ) . '">
		    </div>
		     
		    <div>
		    <label for="firstname">First Name</label>
		    <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
		    </div>
		     
		    <div>
		    <label for="website">Last Name</label>
		    <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
		    </div>
		     
		    <div>
		    <label for="nickname">Nickname</label>
		    <input type="text" name="nickname" value="' . ( isset( $_POST['nickname']) ? $nickname : null ) . '">
		    </div>
		     
		    <div>
		    <label for="bio">About / Bio</label>
		    <textarea name="bio">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
		    </div>
		    <input type="submit" name="submit" value="Register"/>
		    </form>
		    ';
		}

		//registration_validation
		public function registration_validation( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio ){
			global $reg_errors;
			$reg_errors = new WP_Error;

			if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
			    $reg_errors->add('field', 'Required form field is missing');
			}

			if ( 4 > strlen( $username ) ) {
			    $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
			}

			if ( username_exists( $username ) )
    			$reg_errors->add('user_name', 'Sorry, that username already exists!');

    		if ( ! validate_username( $username ) ) {
			    $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
			}

			if ( 5 > strlen( $password ) ) {
		        $reg_errors->add( 'password', 'Password length must be greater than 5' );
		    }

		    if ( !is_email( $email ) ) {
			    $reg_errors->add( 'email_invalid', 'Email is not valid' );
			}

			if ( email_exists( $email ) ) {
			    $reg_errors->add( 'email', 'Email Already in use' );
			}

			if ( ! empty( $website ) ) {
			    if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
			        $reg_errors->add( 'website', 'Website is not a valid URL' );
			    }
			}

			if ( is_wp_error( $reg_errors ) ) {
 
			    foreach ( $reg_errors->get_error_messages() as $error ) {
			     
			        echo '<div>';
			        echo '<strong>ERROR</strong>:';
			        echo $error . '<br/>';
			        echo '</div>';
			         
			    }
			 
			}

		}

		// complete_registration

		public function complete_registration() {
		    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
		    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
		        $userdata = array(
		        'user_login'    =>   $username,
		        'user_email'    =>   $email,
		        'user_pass'     =>   $password,
		        'user_url'      =>   $website,
		        'first_name'    =>   $first_name,
		        'last_name'     =>   $last_name,
		        'nickname'      =>   $nickname,
		        'description'   =>   $bio,
		        );
		        $user = wp_insert_user( $userdata );
		        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
		    }
		}

		public function custom_registration_function() {
		    if ( isset($_POST['submit'] ) ) {
		        $this->registration_validation(
		        $_POST['username'],
		        $_POST['password'],
		        $_POST['email'],
		        $_POST['website'],
		        $_POST['fname'],
		        $_POST['lname'],
		        $_POST['nickname'],
		        $_POST['bio']
		        );
		         
		        // sanitize user form input
		        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
		        $username   =   sanitize_user( $_POST['username'] );
		        $password   =   esc_attr( $_POST['password'] );
		        $email      =   sanitize_email( $_POST['email'] );
		        $website    =   esc_url( $_POST['website'] );
		        $first_name =   sanitize_text_field( $_POST['fname'] );
		        $last_name  =   sanitize_text_field( $_POST['lname'] );
		        $nickname   =   sanitize_text_field( $_POST['nickname'] );
		        $bio        =   esc_textarea( $_POST['bio'] );
		 
		        // call @function complete_registration to create the user
		        // only when no WP_error is found
		        $this->complete_registration(
		        $username,
		        $password,
		        $email,
		        $website,
		        $first_name,
		        $last_name,
		        $nickname,
		        $bio
		        );
		    }
		 
		    $this->registration_form(
		        $username,
		        $password,
		        $email,
		        $website,
		        $first_name,
		        $last_name,
		        $nickname,
		        $bio
		        );
		}


	}

	$demo_plugin = new demoPlugin;
?>