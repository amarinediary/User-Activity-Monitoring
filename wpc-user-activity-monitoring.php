<?php

if ( ! defined( 'ABSPATH' ) ) {

    exit;

};

/**
 * Plugin Name: User-Activity-Monitoring
 * Text Domain: user-activity-monitoring
 * Plugin URI: https://github.com/amarinediary/User-Activity-Monitoring
 * Description: A non-invasive, lightweight WordPress plugin adding user activity monitoring support. User-Activity-Monitoring is a plug-and-play plugin with no required configuration.
 * Version: 1.0.0
 * Requires at least: 3.0.0 
 * Requires PHP: 4.0
 * Tested up to: 5.7.1
 * Author: amarinediary
 * Author URI: https://github.com/amarinediary
 * License: CC0 1.0 Universal (CC0 1.0) Public Domain Dedication
 * License URI: https://github.com/amarinediary/User-Activity-Monitoring/blob/main/LICENSE
 * GitHub Plugin URI: https://github.com/amarinediary/User-Activity-Monitoring
 * GitHub Branch: main
 */
if ( ! class_exists( 'User_Activity_Monitoring' ) ) {

    class User_Activity_Monitoring {

        /**
         * @var Integer User inactivity margin in minutes.
         */
        private const USER_INACTIVITY_MARGIN = 10 * MINUTE_IN_SECONDS;

        /**
         * @var Integer Transient self clear margin in minutes.
         */
        private const TRANSIENT_SELF_CLEAR = 30 * MINUTE_IN_SECONDS;

        /**
         * Hooks methods to actions.
         *
         * @since 1.0.0
         */
        public function __construct() {

            add_action( 'init', array( $this, 'user_activity_monitoring_transient' ) );

        }
        
        /**
         * Set & update WPC user activity monitoring transient on user server interactions.
         *
         * @since 1.0.0
         */
        public function user_activity_monitoring_transient() {
        
            if ( is_user_logged_in() ) {

                $user_activity_monitoring_transient = get_transient( 'user_activity_monitoring_transient' );
        
                if ( empty( $user_activity_monitoring_transient ) ) {
    
                    $user_activity_monitoring_transient = array();
    
                };
            
                $user_id = get_current_user_id();
                
                $timestamp = current_time( 'timestamp' );
    
                if ( empty( $user_activity_monitoring_transient[$user_id] ) || ( $user_activity_monitoring_transient[$user_id] < ( $timestamp - self::USER_INACTIVITY_MARGIN ) ) ) {
    
                    $user_activity_monitoring_transient[$user_id] = $timestamp;
    
                    set_transient( 'user_activity_monitoring_transient', $user_activity_monitoring_transient, self::TRANSIENT_SELF_CLEAR );

                };
        
            };
        
        }
        
        /**
         * Get a specific user activity status from it's ID.
         *
         * @since 1.0.0
         *
         * @param Integer $user_id The user ID.
         *
         * @return Bool True for online.
         */
        public function is_user_currently_online( $user_id ) {
        
            $user_activity_monitoring_transient = get_transient( 'user_activity_monitoring_transient' );

            if ( ! isset( $user_activity_monitoring_transient[$user_id] ) ) {
                return;
            };

            if ( $user_activity_monitoring_transient[$user_id] > ( current_time( 'timestamp' ) - self::USER_INACTIVITY_MARGIN ) ) {
    
                return isset( $user_activity_monitoring_transient[$user_id] );
    
            };

        }
        
        /**
         * Get an array of all users currently online.
         *
         * @since 1.0.0
         *
         * @return Array An array of currently online users ID.
         */
        public function get_currently_online_users() {
        
            $user_activity_monitoring_transient = array_reverse( get_transient( 'user_activity_monitoring_transient' ), true );
            
            $currently_online_users = array();
    
            foreach ( $user_activity_monitoring_transient as $user_id => $timestamp ) {
    
                if ( $timestamp > ( current_time( 'timestamp' ) - self::USER_INACTIVITY_MARGIN ) ) {
    
                    array_push( $currently_online_users, $user_id );
    
                };
    
            };
    
            return $currently_online_users;
        
        }

        /**
         * Get an array of all users recently offline.
         *
         * @since 1.0.0
         *
         * @return Array An array of recently offline users ID.
         */
        public function get_recently_offline_users() {
        
            $user_activity_monitoring_transient = array_reverse( get_transient( 'user_activity_monitoring_transient' ), true );
            
            $recently_offline_users = array();
    
            foreach ( $user_activity_monitoring_transient as $user_id => $timestamp ) {
    
                if ( $timestamp < ( current_time( 'timestamp' ) - self::USER_INACTIVITY_MARGIN ) ) {
    
                    array_push( $recently_offline_users, $user_id );
    
                };
    
            };
    
            return $recently_offline_users;
        
        }   
        
    };

    $user_activity_monitoring = new User_Activity_Monitoring();

};

/**
 * Schedules a recurring daily event.
 *
 * @since 1.0.0
 */
if ( ! wp_next_scheduled ( 'schedule_event_delete_user_activity_monitoring_transient' ) ) {

    wp_schedule_event( strtotime( '23:59:00' ), 'daily', 'schedule_event_delete_user_activity_monitoring_transient' );

};

/**
 * Delete the user_activity_monitoring_transient.
 *
 * @since 1.0.0
 */
add_action( 'schedule_event_delete_user_activity_monitoring_transient', 'delete_user_activity_monitoring_transient' );

if ( ! function_exists( 'delete_user_activity_monitoring_transient' ) ) {

    function delete_user_activity_monitoring_transient() {

        delete_transient( 'user_activity_monitoring_transient' );

    };

};
