<?php
/*
Plugin Name: Mentor MatchMaker
Description: A tool that matches mentors to mentees by comparing interests, strenghts and weaknesses
Version: 1.0
Author: Nicholas Goodridge
*/

class MENTOR_MATCHMAKER {

    public function __construct() {

        // Create the Mentor MatchMaker page
        add_shortcode( 'mentor_matchmaker', array( $this, 'mentor_matchmaker' ) );

        // Add a new tab to the profile
        add_filter( 'um_after_header_meta', array( $this, 'um_after_header_meta' ), 10, 2 );

        // Create short code to display the end mentorship form
        add_shortcode( 'end_mentorship_form', array( $this, 'end_mentorship_form') );
    }

    public function mentor_matchmaker() {
       
        // Get the current user ID
        $user_id = get_current_user_id();

        // Get the mentor role.  Should be Mentor, Mentee, or Neither.
        $mentor_role = get_user_meta( $user_id, 'mentor_role', true );

        // If the current user is a mentor
        if( $mentor_role == 'Mentor' ) {

            // Get the arrays of mentees and mentorship requests from user meta
            $mentees = get_user_meta( $user_id, 'mentees', true );
            $mentees = !empty( $mentees ) ? $mentees : array();
            $mentorship_requests = get_user_meta( $user_id, 'mentorship_requests', true );

            // If we are responding to a mentorship request
            if( isset( $_POST['accept-mentorship-request'] ) ) {

                // If the request was accepted, the user_id should have been passed in POST
                if( is_numeric( $_POST['accept-mentorship-request'] ) ) {

                    // Set the mentee id
                    $mentee_id = (int)($_POST['accept-mentorship-request']);

                    // Remove the user id from the mentorship_requests
                    $requestor_index = array_search( $mentee_id, $mentorship_requests );
                    unset( $mentorship_requests[$requestor_index] );

                    // Add user id to mentees array and update mentorship_requests meta with new array
                    array_push( $mentees, $mentee_id );
                    update_user_meta( $user_id, 'mentees', $mentees );
                    update_user_meta( $user_id, 'mentorship_requests', $mentorship_requests );

                    // Update the mentees mentor meta value
                    $mentee_mentors = get_user_meta( $mentee_id, 'mentors', true );
                    $mentee_mentors = !empty( $mentee_mentors ) ? $mentee_mentors : array();
                    array_push( $mentee_mentors, $user_id );
                    update_user_meta( $mentee_id, 'mentors', $mentee_mentors );

                    // Sloppy method to get mentees array to update with the newly approved mentee
                    wp_redirect( '/index.php/mentor-matchmaker/' );
                    exit;
                }
            }

            if( isset( $_POST['decline-mentorship-request'] ) ) {

                // If the request was accepted, the user_id should have been passed in POST
                if( is_numeric( $_POST['decline-mentorship-request'] ) ) {

                    // Set the mentee id
                    $mentee_id = (int)($_POST['decline-mentorship-request']);

                    // Remove the user id from the mentorship_requests
                    $requestor_index = array_search( $mentee_id, $mentorship_requests );
                    unset( $mentorship_requests[$requestor_index] );

                    // update mentorship_requests meta with new array
                    update_user_meta( $user_id, 'mentorship_requests', $mentorship_requests );

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
                                    <div class="um-member-meta-main">

                                        <div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

                                            <?php um_fetch_user( $member );

                                            $reveal_fields = array( 'phone_number', 'user_email' );
            
                                            foreach ( $reveal_fields as $key ) {
                                                if ( $key ) {
                                                    $value = um_filtered_value( $key );
                                                    if ( ! $value ) {
                                                        continue;
                                                    } ?>

                                                    <div class="um-member-metaline um-member-metaline-<?php echo esc_attr( $key ); ?>">
                                                        <span><strong><?php echo esc_html( UM()->fields()->get_label( $key ) ); ?>:</strong><br> <?php _e( $value, 'ultimate-member' ); ?></span>
                                                    </div>

                                                <?php }
                                            }

                                        ?>
                                        </div>

                                        <div class="um-member-less"><a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a></div>

                                    </div>
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
                                            <button class="um-members-btn" name="accept-mentorship-request" id="accept-mentorship-request" value="<?php echo $member; ?>" >Accept Mentee</button>
                                            <button class="um-members-btn" name="decline-mentorship-request" id="decline-mentorship-request" value="<?php echo $member; ?>" >Decline Mentee</button>
                                        </form>
                                    </div>

                                    <?php

                                    if ( ! empty( $show_userinfo ) ) { ?>

                                        <div class="um-member-meta-main">

                                            <div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

                                                <?php um_fetch_user( $member );

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

                                            ?>
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

            $mentors = get_user_meta( $user_id, 'mentors', true );
            $mentor_matches = $this->get_mentor_matches( $user_id );
            
            ?>

            <div class="row mentor-matchmaker" >

                <div class="col-md-12" >
                    <h4>My Mentor(s)</h4>
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
                                    
                                    <div class="um-member-meta-main">

                                        <?php if ( $userinfo_animate ) { ?>
                                            <div class="um-member-more"><a href="javascript:void(0);"><i class="um-faicon-angle-down"></i></a></div>
                                        <?php } ?>

                                        <div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

                                            <?php um_fetch_user( $member );

                                            $reveal_fields = array( 'phone_number', 'user_email' );

                                            foreach ( $reveal_fields as $key ) {
                                                if ( $key ) {
                                                    $value = um_filtered_value( $key );
                                                    if ( ! $value ) {
                                                        continue;
                                                    } ?>

                                                    <div class="um-member-metaline um-member-metaline-<?php echo esc_attr( $key ); ?>">
                                                        <span><strong><?php echo esc_html( UM()->fields()->get_label( $key ) ); ?>:</strong><br> <?php _e( $value, 'ultimate-member' ); ?></span>
                                                    </div>

                                                <?php }
                                            }
                                        ?>
                                        </div>

                                        <div class="um-member-less"><a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a></div>

                                    </div>
                                </div>

                            </div>

                            <?php um_reset_user_clean();
                        } // end foreach

                        um_reset_user(); ?>

                    </div>
                </div>

                <div class="col-md-4" style="font-size: 300px; color:#ad0000;" >
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="col-md-8" style="font-size: 75px;" >
                        <p>Scroll Down to see your top 10 Mentor Matches!</p>
                </div>

                <div class="col-md-9" >
                    <h4>My Mentor Matches</h4>
                </div>
                <div class="col-md-3" >
                    <!--<button class="all_mentors" name="all_mentors" id="all_mentors" >All Mentors</button>-->
                </div>
                <div class="col-md-12" >
                    <div class="um-members">

                    <div class="um-gutter-sizer"></div>

                    <?php $i = 0;
                    foreach ( $mentor_matches as $mentor ) {

                        // Let's only show the top 10 matches on this page.
                        if( $i == 10 ) {

                            break;
                        }

                        um_fetch_user( $mentor['user_id'] ); ?>

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
                                
                                <div class="um-member-meta-main">

                                    <?php if ( $userinfo_animate ) { ?>
                                        <div class="um-member-more"><a href="javascript:void(0);"><i class="um-faicon-angle-down"></i></a></div>
                                    <?php } ?>

                                    <div class="um-member-meta <?php if ( ! $userinfo_animate ) { echo 'no-animate'; } ?>">

                                        <?php um_fetch_user( $mentor['user_id'] ); ?>

                                        <div class="um-member-metaline um-member-metaline-<?php echo 'percent-match' ?>">
                                            <span><strong>Interests Match:</strong><br> <?php _e( sprintf("%.2f%%", $mentor['interests_match'] * 100), 'ultimate-member' ); ?></span>
                                            <br>
                                            <span><strong>Strengths/Weaknesses Match:</strong><br> <?php _e( sprintf("%.2f%%", $mentor['strengths_weaknesses_match'] * 100), 'ultimate-member' ); ?></span>
                                        </div>

                                    </div>

                                    <div class="um-member-less"><a href="javascript:void(0);"><i class="um-faicon-angle-up"></i></a></div>

                                </div>
                            </div>

                        </div>

                        <?php um_reset_user_clean();

                        $i++;

                    } // end foreach

                    um_reset_user(); ?>

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

    public function um_after_header_meta( $profile_user_id, $args ) {

        // Get the mentor role for the user of the profile being viewed
        $profile_user_mentor_role = get_user_meta( $profile_user_id, 'mentor_role', true);

        // Get the mentor role for the logged in user
        $current_user_id = get_current_user_id();
        $current_user_mentor_role = get_user_meta( $current_user_id, 'mentor_role', true);

        // If the profile user is a mentor, the currently logged in user is a mentee,  the profile being viewed isn't the logged in users profile, and the user being viewed is not already a mentor for the logged in user, show the request mentor button
        if( $profile_user_mentor_role == 'Mentor' && $current_user_mentor_role == 'Mentee' && $profile_user_id != $current_user_id ) {

            // Get the current users array of mentors
            $mentors = get_user_meta( $current_user_id, 'mentors', true );
            $mentorship_requests = get_user_meta( $profile_user_id, 'mentorship_requests', true);

            // If the meta value is empty, make an array otherwise keep meta value given.
            $mentorship_requests = empty( $mentorship_requests ) ? $mentorship_requests = array() : $mentorship_requests;

            // If sending a mentorship request
            if( isset( $_POST['request_mentorship'] ) ) {

                array_push( $mentorship_requests, $current_user_id );

                // Save request as user meta of the profile user with the current user id as the meta value
                $request_sent = update_user_meta( $profile_user_id, 'mentorship_requests', $mentorship_requests );

                if( $request_sent ) {

                    ?>

                    <div class="alert alert-success alert-dismissible fade show"  >
                        <p>Request sent!</p>
                    </div>

                    <?php

                }
                else {

                    ?>

                    <div class="alert alert-danger alert-dismissible fade show" >
                        <p>Error.  Request not sent.  Please try again or contact and administrator</p>
                    </div>

                    <?php

                }
            }

            if( !in_array( $profile_user_id, $mentors ) && !in_array( $current_user_id, $mentorship_requests ) ) {

                ?>

                <form method="post" action="" >
                    <button class="request_mentorship" name="request_mentorship" id="request_mentorship" value="send_request" >Request Mentorship</button>
                </form>

                <?php

            }

            if( in_array( $profile_user_id, $mentors ) ) {

                ?>

                <form method="post" action="https://cardinalcounsel.net/index.php/end-mentorship-form/" >
                    <button class="end_mentorship" name="end_mentorship" id="end_mentorship" value="end_mentorship" >End Mentorship</button>
                </form>

                <?php
            }

        }
    }

    public function get_mentor_matches( $mentee_id ) {

        // Get the mentees intereests
        $mentee_interests = get_user_meta( $mentee_id, 'mentor_interests', true );
        $mentee_strengths = get_user_meta( $mentee_id, 'strengths', true );
        $mentee_weaknesses = get_user_meta( $mentee_id, 'weaknesses', true );

        // Get all users that are mentors
        $args = array( 'meta_key' => 'mentor_role', 'meta_value' => 'Mentor' ) ;
        $mentor_users = get_users( $args );

        // Declare an array that will hold the Mentors ID and his match percentages
        $mentor_matches = array();

        // Compare all mentors interests to the mentees users interests
        foreach( $mentor_users as $mentor_user ) {

            $mentor_interests = get_user_meta( $mentor_user->id, 'mentor_interests', true );
            $mentor_strengths = get_user_meta( $mentor_user->id, 'strengths', true );
            $mentor_weaknesses = get_user_meta( $mentor_user->id, 'weaknesses', true );

            // Counter to calcuate match percentage
            $interests_match_count = 0;
            $strengths_weaknesses_match_count = 0;

            // Index to help on perform one loop instead of 3 
            $i = 0;

            foreach( $mentor_interests as $mentor_interest ) {

                if( is_int( array_search( $mentor_interest, $mentee_interests ) ) ) {

                    $interests_match_count++;
                }

                if( is_int( array_search( $mentor_strengths[$i], $mentee_weaknesses ) ) ) {

                    $strengths_weaknesses_match_count++;
                }

                if( is_int( array_search( $mentor_weaknesses[$i], $mentee_strengths ) ) ) {

                    $strengths_weaknesses_match_count++;
                }

                $i++;
            }

            // Calculate the match percentage between the mentee and mentor interests, and strengths/weaknesses
            $interests_match = number_format( $interests_match_count / ( count( $mentee_interests ) ), 2 );
            $strengths_weaknesses_match = number_format( $strengths_weaknesses_match_count / ( count( $mentee_strengths ) + count( $mentor_weaknesses ) ), 2 );

            // Create multi-dimensional array of user_id and interests_match to return
            array_push( $mentor_matches, array( 'user_id' => $mentor_user->id, 'interests_match' => $interests_match, 'strengths_weaknesses_match' => $strengths_weaknesses_match ) );
        }

        array_multisort( array_column( $mentor_matches, 'interests_match' ), SORT_DESC,  $mentor_matches );

        return $mentor_matches;

    }

    public function end_mentorship_form() {

        // If ending an existing mentorship connection, let's find out why first.
        if( isset( $_POST['end_mentorship'] ) ) {

            ?>

            <form method="POST" action="">
                <p>Were you satisfied with the the mentorship you recieved?</p>
                <input type="radio" name="mentee_satisfaction" id="satisfied" value="Yes" >
                <label for="satisfied">Yes</label>
                <input type="radio" name="mentee_satisfaction" id="dissatisfied" value="No" >
                <label for="dissatisfied">No</label>

            </form>

            <?php
        }
    }
}
$MENTOR_MATCHMAKER = new MENTOR_MATCHMAKER();


?>