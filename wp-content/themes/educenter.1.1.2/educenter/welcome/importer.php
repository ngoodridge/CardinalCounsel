<?php
/**
 * OCDI support.
 *
 * @package Educenter
 */

// Disable PT branding.
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * OCDI after import.
 *
 * @since 1.0.0
 */
function educenter_ocdi_after_import() {

    // Assign navigation menu locations.
    $menu_location_details = array(
        'menu-1'  => 'Menu 1',
        'menu-2'  => 'Menu 2',
    );

    if ( ! empty( $menu_location_details ) ) {
        $navigation_settings = array();
        $current_navigation_menus = wp_get_nav_menus();
        if ( ! empty( $current_navigation_menus ) && ! is_wp_error( $current_navigation_menus ) ) {
            foreach ( $current_navigation_menus as $menu ) {
                foreach ( $menu_location_details as $location => $menu_slug ) {
                    if ( $menu->slug === $menu_slug ) {
                        $navigation_settings[ $location ] = $menu->term_id;
                    }
                }
            }
        }

        set_theme_mod( 'nav_menu_locations', $navigation_settings );
    }
}
add_action( 'pt-ocdi/after_import', 'educenter_ocdi_after_import' );


/**
 * Demo export/import
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package CoverNews
 */
if (!function_exists('educenter_ocdi_files')) :
    /**
     * OCDI files.
     *
     * @since 1.0.0
     *
     * @return array Files.
     */
    function educenter_ocdi_files() {

        return apply_filters( 'educenter_demo_import_files', array(
            
            array(
                'import_file_name'             => esc_html__( 'Educenter Demo', 'educenter' ),
                'local_import_file'            => trailingslashit( get_template_directory() ) . 'welcome/demo-data/educenter.xml',
                'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'welcome/demo-data/educenter.wie',
                'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'welcome/demo-data/educenter.dat',
                'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'welcome/css/educenter.jpg',
                'preview_url'                  => 'http://demo.sparklewpthemes.com/educenter/',
            ),

            array(
                'import_file_name'             => esc_html__( 'Upgrade Premium', 'educenter' ),
                'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'welcome/css/educenterpro.jpg',
                'preview_url'                  => 'http://demo.sparklewpthemes.com/educenterpro/',
            ),

            array(
                'import_file_name'             => esc_html__( 'Upgrade Premium', 'educenter' ),
                'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'welcome/css/educenterproone.jpg',
                'preview_url'                  => 'http://demo.sparklewpthemes.com/educenterpro/demo1/',
            ),

            array(
                'import_file_name'             => esc_html__( 'Upgrade Premium', 'educenter' ),
                'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'welcome/css/educenterprotwo.jpg',
                'preview_url'                  => 'http://demo.sparklewpthemes.com/educenterpro/dem2/',
            )

        ));
    }
endif;
add_filter( 'pt-ocdi/import_files', 'educenter_ocdi_files');