<?php

/*
Educenter Child Theme
Customs styles for the Educenter theme added by Nicholas Goodridge.
*/

// Include shortcodes created in the child theme
include 'shortcodes/shortcodes.php';

// Educenter child theme class
class EDUCENTER_CHILD_THEME {

    public function __construct() {

        // Enqueue scripts/styles
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
        
        // Add counter for pending users to WP Admin Bar and clean it up some
        add_action( 'wp_before_admin_bar_render', array( $this, 'wp_before_admin_bar_render') );

        // Add notification bubble counter to the Mentor MatchMaker menu item
        add_filter( 'wp_nav_menu_items', array( $this, 'wp_nav_menu_items'), 10, 2 );
    }

    //Enqueue scripts and styles
    public function wp_enqueue_scripts() {

        // Enqueue Bootstrap
        wp_enqueue_style( 'bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' );

        // Enqueue FontAwesome library
        wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.3.0/css/all.css' );

        // Enqueue parent and child style sheet
        $parent_style = 'educenter';
        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

        wp_enqueue_style( 'educenter-child',
            get_stylesheet_directory_uri() . '/style.css',
            array( $parent_style ),
            wp_get_theme()->get('Version')
        );

    }

    // Add counter for pending users to WP Admin Bar and clean it up some
    public function wp_before_admin_bar_render() {

        global $wp_admin_bar;
        
		if( is_plugin_active( 'ultimate-member/ultimate-member.php' ) ) {

            // Get the current user and make sure they are and admin
            $logged_in_user = wp_get_current_user();
		    $is_admin = in_array( 'administrator', (array) $logged_in_user->roles ) ? true : false;

            // Create counter for pending users
			$count = 0;
			$users = get_users();
				
			// Loop each user
			foreach( $users as $user ) {
				
				// Check approval status
                $user_status = get_user_meta( $user->ID, 'account_status', true );
                
				if( $user_status == 'awaiting_admin_review' ) {
					
					// Increase count if user is still awaiting admin review
					$count++;
				}
			}
        }

        // If the user is and admin create a counter in the wp_admin_bar and remove some unnecessary menu items
        if( $is_admin && $count != 0 ) {

            // Create pending user menu item
            $args = array( 'id' => 'frontend_user_admin_bar', 'title' => 'Pending Users <span id="bubble_count">' . $count . '</span>', 'href' => '/wp-admin/users.php?status=awaiting_admin_review' );
            $wp_admin_bar->add_node( $args );

            // Remove unecessary menu items
            $wp_admin_bar->remove_menu( 'wp-logo' );
            $wp_admin_bar->remove_menu( 'comments' );
            $wp_admin_bar->remove_menu( 'customize' );
            $wp_admin_bar->remove_menu( 'new-content' );
            $wp_admin_bar->remove_menu( 'edit' );

        }
    }

    // Add notification bubble counter to the Mentor MatchMaker menu item
    public function wp_nav_menu_items( $items, $args ) {

        // Get the current users ID, and their mentor/mentee role
        $current_user_id = get_current_user_id();
        $current_user_mentor_role = get_user_meta( $current_user_id, 'mentor_role', true );

        // Only continue of the current user is capable if recieveing mentorship requests
        if( $current_user_mentor_role == 'Mentor' ) {

            // Get the Mentors current Mentorship requests and count them 
            $mentorship_requests = get_user_meta( $current_user_id, 'mentorship_requests', true );
            $notifcations = is_array( $mentorship_requests ) ? count( $mentorship_requests ) : 0;

            // If the notifications count is greater than 0, show a bubble counter next to the Mentor MatchMaker Menu Item
            if( $notifcations > 0 ) {

                $items = str_replace( 'Mentor MatchMaker', 'Mentor MatchMaker <span id="bubble_count" style="background-color: red !important;" >' . $notifcations . '</span>', $items );
            }
        }

        return $items;
    }

}
$EDUCENTER_CHILD_THEME = new EDUCENTER_CHILD_THEME();

?>