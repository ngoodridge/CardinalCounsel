<?php

/*
Educenter Child Theme Short Codes
*/

class Barkers_Boys_Shortcodes {

    public function __construct() {

        add_shortcode( 'home_page', array( $this, 'home_page' ) );

        add_shortcode( 'donate_page', array( $this, 'donate_page' ) );

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

    public function donate_page() {

        ?>

        <h3>Never Expected, Always Appreciated.</h3>
        <p>Your support is crucial to our work as a premier metropolitan research university. Your gifts support scholarships, research, scientific discoveries and creative endeavors that cannot be funded by state and tuition support alone.</p>

        <div class="row donate" >
            <div class="col-md-6" >
                <div class="donate-paypal" >
                    <i class="fas fa-credit-card" ></i>
                    <p>Give through PayPal.</p>
                    <?php echo do_shortcode( '[paypal-donation]' ); ?>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="donate-phone" >
                    <i class="fas fa-phone"></i>
                    <p>Give By Phone.</p>
                    <p>502-852-4919</p>
                </div>
            </div>
        </div>
        <div class="row donate" >
            <div class="col-md-6" >
                <div class="donate-mail" >
                    <i class="fas fa-envelope-open-text"></i>
                    <p>Give by mail.</p>
                    <p>
                        University of Louisville
                        <br>
                        Advancement Operations 
                        <br>
                        2323 South Brook St.
                        <br>
                        Louisville, Kentucky 40292
                    </p>
                    <p>Checks payable to the University of Louisville Foundation. In the memo, include the gift allocation (e.g. A specific school/college, scholarship etc.).</p>
                </div>
            </div>
            <div class="col-md-6" >
                <div class="donate-gift" >
                    <i class="fas fa-gift"></i>
                    <p>Make a planned gift.</p>
                    <p>Planned gifts provide benefits including income, an avoidance of capital gains tax and immediate income tax deduction. 
                        Some planned gifts such as bequests, provide estate tax savings. To speak with someone about a planned gift, contact James Eriksen, Director of Planned Giving, 
                        at 502-852-6954 or <a href="mailto:jim.eriksen@louisville.edu?subject=Planned Gift Inquiry">jim.eriksen@louisville.edu</a>.
                    </p>
                </div>
            </div>
        </div>

        <?php
    }
}
$Barkers_Boys_Shortcodes = new Barkers_Boys_Shortcodes();
?>