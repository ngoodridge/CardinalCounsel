<?php
// Custom footer for Cardinal Counsel.

?>

	</div><!-- #content -->

	<?php

		do_action( 'educenter_footer_before');

			/**
			 * @see  educenter_footer_widget_area() - 10
			*/
			do_action( 'educenter_footer_widget');

	    	/**
	    	 * Button Footer Area
	    	   * @see  educenter_copyright() - 5
	    	*/
            //do_action( 'educenter_button_footer'); 
            
            ?>
            <div class="bottom-footer clearfix">

                <div class="container">

                    <div class="footer-bottom-left">

                        <p>Copyright © <?php echo date("Y"); ?> Cardinal Counsel - By Barkers Boys</p>

                    </div>

                    <div class="footer-bottom-right">
                        <?php
                            if( has_nav_menu( 'menu-2' ) ){
                                wp_nav_menu( array(
                                    'theme_location' => 'menu-2',
                                    'menu_id'        => 'footer-menu',
                                    'depth'          => 1,
                                ) );
                            }
                        ?>
                    </div>

                </div>

            </div>
            <?php
	    
	    do_action( 'educenter_footer_after');
	?><!-- #colophon -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
