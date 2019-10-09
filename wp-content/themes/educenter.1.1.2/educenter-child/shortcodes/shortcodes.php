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

        // If the current user is a mentor
        if( $mentor_role == 'Mentor' ) {

            // Get the arrays of mentees and mentorship requests from user meta
            $mentees = get_user_meta( $user_id, 'mentees', false );
            $mentorship_requests = get_user_meta( $user_id, 'mentorship_requests', true );

            // If we are responding to a mentorship request
            if( isset( $_POST['mentorship-request-response'] ) ) {

                // If the request was accepted, the user_id should have been passed in POST
                if( is_numeric( $_POST['mentorship-request-response'] ) ) {

                    // Set the mentee id
                    $mentee_id = (int)($_POST['mentorship-request-response']);

                    // Remove the user id from the mentorship_requests
                    $requestor_index = array_search( $mentee_id, $mentorship_requests );
                    unset( $mentorship_requests[$requestor_index] );

                    // Add user id to mentees array and update mentorship_requests meta with new array
                    update_user_meta( $user_id, 'mentees', $mentee_id );
                    update_user_meta( $user_id, 'mentorship_requests', $mentorship_requests );

                    // Update the mentees mentor meta value
                    update_user_meta( $mentee_id, 'mentors', $user_id );

                    // Sloppy method to get mentees array to update with the newly approved mentee
                    wp_redirect( '/index.php/mentor-matchmaker/' );
                    exit;
                }

                if( $_POST['mentorship-request-response'] == 'decline' ) {
                    

                }
            }
            
            ?>

            <div class="row mentor-matchmaker" >
                <div class="col-md-12" >
                    <h4>My Mentee(s)</h4>
                </div>
                <div class="col-md-12" >
                    <div class="um-members">

                        <div class="um-gutter-sizer"></div>

                        <?php $i = 0;
                        foreach ( $mentees as $member ) {
                            $i++;
                            um_fetch_user( $member ); ?>

                            <div class="um-member um-role-<?php echo esc_attr( um_user( 'role' ) ) . ' ' . esc_attr( um_user('account_status') ); ?> with-cover">

                                <span class="um-member-status <?php echo esc_attr( um_user( 'account_status' ) ); ?>"><?php echo esc_html( um_user( 'account_status_name' ) ); ?></span>

                                <?php 

                                $sizes = UM()->options()->get( 'cover_thumb_sizes' );
                                if ( UM()->mobile()->isTablet() ) {
                                    $cover_size = $sizes[1];
                                } else {
                                    $cover_size = $sizes[0];
                                } ?>

                                <div class="um-member-cover" data-ratio="<?php echo esc_attr( UM()->options()->get( 'profile_cover_ratio' ) ); ?>">
                                    <div class="um-member-cover-e">
                                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                            <?php echo um_user( 'cover_photo', $cover_size ); ?>
                                        </a>
                                    </div>
                                </div>

                                <?php 

                                $corner = UM()->options()->get( 'profile_photocorner' );

                                $default_size = UM()->options()->get( 'profile_photosize' );
                                $default_size = str_replace( 'px', '', $default_size ); ?>

                                <div class="um-member-photo radius-<?php echo esc_attr( $corner ); ?>">
                                    <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                        <?php echo get_avatar( um_user( 'ID' ), $default_size ); ?>
                                    </a>
                                </div>

                                <div class="um-member-card">
                                    <div class="um-member-name">
                                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                            <?php echo um_user( 'display_name', 'html' ); ?>
                                        </a>
                                    </div>

                                    <?php 

                                    if ( $show_tagline && ! empty( $tagline_fields ) && is_array( $tagline_fields ) ) {

                                        um_fetch_user( $member );

                                        foreach( $tagline_fields as $key ) {
                                            if ( $key ) {
                                                $value = um_filtered_value( $key );
                                                if ( ! $value ) {
                                                    continue;
                                                } ?>

                                                <div class="um-member-tagline um-member-tagline-<?php echo esc_attr( $key ); ?>">
                                                    <?php _e( $value, 'ultimate-member' ); ?>
                                                </div>

                                            <?php } // end if
                                        } // end foreach
                                    } // end if $show_tagline

                                    if ( ! empty( $show_userinfo ) ) { ?>

                                        <div class="um-member-meta-main">

                                            <?php if ( $userinfo_animate ) { ?>
                                                <div class="um-member-more"><a href="javascript:void(0);"><i class="um-faicon-angle-down"></i></a></div>
                                            <?php } ?>

                                            <div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

                                                <?php um_fetch_user( $member );
                                                if ( ! empty( $reveal_fields ) && is_array( $reveal_fields ) ) {
                                                    foreach ( $reveal_fields as $key ) {
                                                        if ( $key ) {
                                                            $value = um_filtered_value( $key );
                                                            if ( ! $value ) {
                                                                continue;
                                                            } ?>

                                                            <div class="um-member-metaline um-member-metaline-<?php echo esc_attr( $key ); ?>">
                                                                <span><strong><?php echo esc_html( UM()->fields()->get_label( $key ) ); ?>:</strong> <?php _e( $value, 'ultimate-member' ); ?></span>
                                                            </div>

                                                        <?php }
                                                    }
                                                }

                                                if ( $show_social ) { ?>
                                                    <div class="um-member-connect">
                                                        <?php UM()->fields()->show_social_urls(); ?>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                            <div class="um-member-less"><a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a></div>

                                        </div>

                                    <?php } ?>

                                </div>

                            </div>

                            <?php um_reset_user_clean();
                        } // end foreach

                        um_reset_user(); ?>

                    </div>
                </div>
                <div class="col-md-12" >
                    <h4>My Requests</h4>
                </div>
                <div class="col-md-12" >
                    <div class="um-members">

                        <div class="um-gutter-sizer"></div>

                        <?php $i = 0;
                        foreach ( $mentorship_requests as $member ) {
                            $i++;
                            um_fetch_user( $member ); ?>

                            <div class="um-member um-role-<?php echo esc_attr( um_user( 'role' ) ) . ' ' . esc_attr( um_user('account_status') ); ?> with-cover">

                                <span class="um-member-status <?php echo esc_attr( um_user( 'account_status' ) ); ?>"><?php echo esc_html( um_user( 'account_status_name' ) ); ?></span>

                                <?php 

                                $sizes = UM()->options()->get( 'cover_thumb_sizes' );
                                if ( UM()->mobile()->isTablet() ) {
                                    $cover_size = $sizes[1];
                                } else {
                                    $cover_size = $sizes[0];
                                } ?>

                                <div class="um-member-cover" data-ratio="<?php echo esc_attr( UM()->options()->get( 'profile_cover_ratio' ) ); ?>">
                                    <div class="um-member-cover-e">
                                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                            <?php echo um_user( 'cover_photo', $cover_size ); ?>
                                        </a>
                                    </div>
                                </div>

                                <?php 

                                $corner = UM()->options()->get( 'profile_photocorner' );

                                $default_size = UM()->options()->get( 'profile_photosize' );
                                $default_size = str_replace( 'px', '', $default_size ); ?>

                                <div class="um-member-photo radius-<?php echo esc_attr( $corner ); ?>">
                                    <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                        <?php echo get_avatar( um_user( 'ID' ), $default_size ); ?>
                                    </a>
                                </div>

                                <div class="um-member-card">
                                    <div class="um-member-name">
                                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                            <?php echo um_user( 'display_name', 'html' ); ?>
                                        </a>
                                    </div>

                                    <div>
                                        <form method="post" action="" >
                                            <button class="um-members-btn" name="mentorship-request-response" id="mentorship-request-response" value="<?php echo $member; ?>" >Accept Mentee</button>
                                            <button class="um-members-btn" name="mentorship-request-response" id="mentorship-request-response" value="decline" >Decline Mentee</button>
                                        </form>
                                    </div>

                                    <?php 

                                    if ( $show_tagline && ! empty( $tagline_fields ) && is_array( $tagline_fields ) ) {

                                        um_fetch_user( $member );

                                        foreach( $tagline_fields as $key ) {
                                            if ( $key ) {
                                                $value = um_filtered_value( $key );
                                                if ( ! $value ) {
                                                    continue;
                                                } ?>

                                                <div class="um-member-tagline um-member-tagline-<?php echo esc_attr( $key ); ?>">
                                                    <?php _e( $value, 'ultimate-member' ); ?>
                                                </div>

                                            <?php } // end if
                                        } // end foreach
                                    } // end if $show_tagline

                                    if ( ! empty( $show_userinfo ) ) { ?>

                                        <div class="um-member-meta-main">

                                            <?php if ( $userinfo_animate ) { ?>
                                                <div class="um-member-more"><a href="javascript:void(0);"><i class="um-faicon-angle-down"></i></a></div>
                                            <?php } ?>

                                            <div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

                                                <?php um_fetch_user( $member );
                                                if ( ! empty( $reveal_fields ) && is_array( $reveal_fields ) ) {
                                                    foreach ( $reveal_fields as $key ) {
                                                        if ( $key ) {
                                                            $value = um_filtered_value( $key );
                                                            if ( ! $value ) {
                                                                continue;
                                                            } ?>

                                                            <div class="um-member-metaline um-member-metaline-<?php echo esc_attr( $key ); ?>">
                                                                <span><strong><?php echo esc_html( UM()->fields()->get_label( $key ) ); ?>:</strong> <?php _e( $value, 'ultimate-member' ); ?></span>
                                                            </div>

                                                        <?php }
                                                    }
                                                }

                                                if ( $show_social ) { ?>
                                                    <div class="um-member-connect">
                                                        <?php UM()->fields()->show_social_urls(); ?>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                            <div class="um-member-less"><a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a></div>

                                        </div>

                                    <?php } ?>

                                </div>

                            </div>

                            <?php um_reset_user_clean();
                        } // end foreach

                        um_reset_user(); ?>

                    </div>
                </div>
            </div>

            <?php
        }

        // If the current user is a mentee
        if( $mentor_role== 'Mentee' ) {

            $mentors = get_user_meta( $user_id, 'mentors', false );
            
            ?>

            <div class="row mentor-matchmaker" >
                <div class="col-md-12" >
                    <h4>My Mentor</h4>
                </div>
                <div class="col-md-12" >
                    <div class="um-members">

                        <div class="um-gutter-sizer"></div>

                        <?php $i = 0;
                        foreach ( $mentors as $member ) {
                            $i++;
                            um_fetch_user( $member ); ?>

                            <div class="um-member um-role-<?php echo esc_attr( um_user( 'role' ) ) . ' ' . esc_attr( um_user('account_status') ); ?> with-cover">

                                <span class="um-member-status <?php echo esc_attr( um_user( 'account_status' ) ); ?>"><?php echo esc_html( um_user( 'account_status_name' ) ); ?></span>

                                <?php 

                                $sizes = UM()->options()->get( 'cover_thumb_sizes' );
                                if ( UM()->mobile()->isTablet() ) {
                                    $cover_size = $sizes[1];
                                } else {
                                    $cover_size = $sizes[0];
                                } ?>

                                <div class="um-member-cover" data-ratio="<?php echo esc_attr( UM()->options()->get( 'profile_cover_ratio' ) ); ?>">
                                    <div class="um-member-cover-e">
                                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                            <?php echo um_user( 'cover_photo', $cover_size ); ?>
                                        </a>
                                    </div>
                                </div>

                                <?php 

                                $corner = UM()->options()->get( 'profile_photocorner' );

                                $default_size = UM()->options()->get( 'profile_photosize' );
                                $default_size = str_replace( 'px', '', $default_size ); ?>

                                <div class="um-member-photo radius-<?php echo esc_attr( $corner ); ?>">
                                    <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                        <?php echo get_avatar( um_user( 'ID' ), $default_size ); ?>
                                    </a>
                                </div>

                                <div class="um-member-card">
                                    <div class="um-member-name">
                                        <a href="<?php echo esc_url( um_user_profile_url() ); ?>" title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>">
                                            <?php echo um_user( 'display_name', 'html' ); ?>
                                        </a>
                                    </div>

                                    <?php 

                                    if ( $show_tagline && ! empty( $tagline_fields ) && is_array( $tagline_fields ) ) {

                                        um_fetch_user( $member );

                                        foreach( $tagline_fields as $key ) {
                                            if ( $key ) {
                                                $value = um_filtered_value( $key );
                                                if ( ! $value ) {
                                                    continue;
                                                } ?>

                                                <div class="um-member-tagline um-member-tagline-<?php echo esc_attr( $key ); ?>">
                                                    <?php _e( $value, 'ultimate-member' ); ?>
                                                </div>

                                            <?php } // end if
                                        } // end foreach
                                    } // end if $show_tagline

                                    if ( ! empty( $show_userinfo ) ) { ?>

                                        <div class="um-member-meta-main">

                                            <?php if ( $userinfo_animate ) { ?>
                                                <div class="um-member-more"><a href="javascript:void(0);"><i class="um-faicon-angle-down"></i></a></div>
                                            <?php } ?>

                                            <div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

                                                <?php um_fetch_user( $member );
                                                if ( ! empty( $reveal_fields ) && is_array( $reveal_fields ) ) {
                                                    foreach ( $reveal_fields as $key ) {
                                                        if ( $key ) {
                                                            $value = um_filtered_value( $key );
                                                            if ( ! $value ) {
                                                                continue;
                                                            } ?>

                                                            <div class="um-member-metaline um-member-metaline-<?php echo esc_attr( $key ); ?>">
                                                                <span><strong><?php echo esc_html( UM()->fields()->get_label( $key ) ); ?>:</strong> <?php _e( $value, 'ultimate-member' ); ?></span>
                                                            </div>

                                                        <?php }
                                                    }
                                                }

                                                if ( $show_social ) { ?>
                                                    <div class="um-member-connect">
                                                        <?php UM()->fields()->show_social_urls(); ?>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                            <div class="um-member-less"><a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a></div>

                                        </div>

                                    <?php } ?>

                                </div>

                            </div>

                            <?php um_reset_user_clean();
                        } // end foreach

                        um_reset_user(); ?>

                    </div>
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

        // If the current user hasn't selected a mentorship role
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