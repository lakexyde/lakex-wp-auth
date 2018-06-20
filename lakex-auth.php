<?php
/**
 * Plugin Name: Lakex Basic Authentication
 * Description: Basic Authentication handler for Woocommerce user authentication in apps
 * Author: Olalekan Oladipupo
 * Author URI: https://github.com/lakexyde/
 * Version: 0.1
 * Plugin URI: https://github.com/lakexyde/lakex-wp-auth
 */

add_action( 'rest_api_init', 'register_api_hooks' );

function register_api_hooks() {
  register_rest_route(
    'lakex-auth', '/login/',
    array(
      'methods'  => 'GET',
      'callback' => 'login',
    )
  );
}

function login($request){
    $creds = array();
    $creds['user_login'] = $request["username"];
    $creds['user_password'] =  $request["password"];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );

    if ( is_wp_error($user) )
      echo $user->get_error_message();

    return $user;
}

add_action( 'after_setup_theme', 'custom_login' );
