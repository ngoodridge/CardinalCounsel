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

}
$EDUCENTER_CHILD_THEME = new EDUCENTER_CHILD_THEME();

?>