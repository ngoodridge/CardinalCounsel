<?php

/*
Educenter Child Theme Short Codes
*/

class Barkers_Boys_Shortcodes {

    public function __construct() {

        add_shortcode( 'home_page', array( $this, 'home_page') );
    }

    public function home_page() {

        ?>

        <div class="banner-image" >
            <img src="<?php  echo get_stylesheet_directory_uri() . '/assets/images/banner-image.jpg' ?>" />
        </div>

        <div class="row about-site" >
            <div class="col-md-4" >
                <div class="about-title" >
                <i class="fa fa-question-circle" aria-hidden="true"></i>
                <h2>Need Help?</h2>
                <p>Create a new topic or search through exisitng ones in our forum boards.  Conveniently categorized by major to help you quickly get the answers you are looking for!</p>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="about-title" >
                <img class="cardinal" src="<?php  echo get_stylesheet_directory_uri() . '/assets/images/cardinal.png' ?>" />
                <h2>Cards Only</h2>
                <p>Have the comfort of knowing you're getting help you can trust!  All members of Cardinal Counsel are current students or alumni of the University of Louisville!  
                All user sign ups are reviewed by a member of the U of L faculty before the are given access to the site.</p>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="about-title" >
                <i class="fas fa-hands-helping"></i>
                <h2>Mentor Matchmaker</h2>
                <p>Prefer one on one help?  Use our custom built Mentor Matchmaker!  The Mentor Matchmaker will attempt to match you with a fellow cardinal who is best equipped to help you be successful!</p>
                </div>
            </div>
        </div>

        <?php
    }
}
$Barkers_Boys_Shortcodes = new Barkers_Boys_Shortcodes();
?>