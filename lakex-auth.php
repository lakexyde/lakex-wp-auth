<?php
/**
 * Plugin Name: Lakex Basic Authentication
 * Description: Basic Authentication handler for Woocommerce user authentication in apps
 * Author: Olalekan Oladipupo
 * Author URI: https://github.com/lakexyde/
 * Version: 0.3
 * Plugin URI: https://github.com/lakexyde/lakex-wp-auth
 */

add_action( 'rest_api_init', 'register_api_hooks' );

function register_api_hooks() {
  register_rest_route(
    'lakex-auth', '/login/',
    array(
      'methods'  => 'POST',
      'callback' => 'login',
    )
  );
}

function login($request){
    $username = $request->get_param( 'username' );
    $password = $request->get_param( 'password' );
  
    $user = wp_authenticate( $username, $password );

    if ( is_wp_error($user) ) {
        return array(
            "message" => $user->get_error_code()
        );
    }

    return array(
        "data" => array(
            "id" => $user->ID,
            "email" => $user->user_email,
            "display_name" => $user->display_name
        )
    );
}

add_action( 'after_setup_theme', 'custom_login' );
