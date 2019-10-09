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

        // Add a new tab to the profile
        add_filter( 'um_after_header_meta', array( $this, 'um_after_header_meta' ), 10, 2 );
    }

    //Enqueue scripts and styles
    public function wp_enqueue_scripts() {

        // Enqueue Bootstrap
        wp_enqueue_style( 'bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' );

        // Enqueue FontAwesome library
        wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.2.0/css/all.css' );

        // Enqueue parent and child style sheet
        $parent_style = 'educenter';
        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

        wp_enqueue_style( 'educenter-child',
            get_stylesheet_directory_uri() . '/style.css',
            array( $parent_style ),
            wp_get_theme()->get('Version')
        );

    }

    public function um_after_header_meta( $user_id, $args ) {

        // Get the mentor role for the user of the profile being viewed
        $profile_user_mentor_role = get_user_meta( $user_id, 'mentor_role', true);

        // Get the mentor role for the logged in user
        $current_user_id = get_current_user_id();
        $current_user_mentor_role = get_user_meta( $current_user_id, 'mentor_role', true);

        // If the profile user is a mentor, the currently logged in user is a mentee, and the profile being viewed isn't the logged in users profile, show the request mentor button
        if( $profile_user_mentor_role == 'Mentor' && $current_user_mentor_role == 'Mentee' && $user_id != $current_user_id ) {

            ?>

            <button class="request_mentorship" name="request_mentorship" id="request_mentorship" >Request Mentorship</button>

            <?php

        }
    }

}
$EDUCENTER_CHILD_THEME = new EDUCENTER_CHILD_THEME();

?>