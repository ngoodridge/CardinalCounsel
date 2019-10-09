<?php

/*
Educenter Child Theme Short Codes
*/

class Barkers_Boys_Shortcodes {

    public function __construct() {

        add_shortcode( 'home_page', array( $this, 'home_page') );

        add_shortcode( 'mentor_matchmaker', array( $this, 'mentor_matchmaker' ) );
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

    public function mentor_matchmaker() {
       
        // Get the current user ID
        $user_id = get_current_user_id();

        // Get the mentor role.  Should be Mentor, Mentee, or Neither.
        $mentor_role = get_user_meta( $user_id, 'mentor_role', true );

        if( $mentor_role == 'Mentor' ) {
            
            ?>

            <div class="row mentor-matchmaker" >
                <div class="col-md-12" >
                    <h4>My Mentee(s)</h4>
                </div>
                <div class="col-md-12" >
                </div>
                <div class="col-md-12" >
                    <h4>My Requests</h4>
                </div>
                <div class="col-md-12" >
                </div>
            </div>

            <?php
        }

        if( $mentor_role== 'Mentee' ) {
            
            ?>

            <div class="row mentor-matchmaker" >
                <div class="col-md-12" >
                    <h4>My Mentor</h4>
                </div>
                <div class="col-md-12" >
                </div>
                <div class="col-md-9" >
                    <h4>My Top 5 Mentor Matches</h4>
                </div>
                <div class="col-md-3" >
                    <button class="all_mentors" name="all_mentors" id="all_mentors" >All Mentors</button>
                </div>
                <div class="col-md-12" >
                </div>
            </div>

            <?php
        }

        if( $mentor_role == "Neither" || empty( $mentor_role) ) {

            ?>

            <div class="row mentor-matchmaker" >
                <div class="col-md-12" >
                    <h4>Welcome to the Mentor MatchMaker!</h4>
                </div>
                <div class="col-md-12" >
                    <p>The Mentor MatchMaker is our own custom tool built to match you with a fellow cardinal who is best equipped to help you be successful! To get started, select your mentor role
                    from the <a class="edit_profile" href="<?php echo um_user_profile_url(); ?>?profiletab=main&um_action=edit&um_action=edit" >edit profile</a> page </p>
                </div>
            </div>

            <?php
        }

    }
}
$Barkers_Boys_Shortcodes = new Barkers_Boys_Shortcodes();
?>