<?php
/*
Plugin Name: Username in Header with Shortcode
Description: Display the logged-in username in the header with a [username_in_header] shortcode.
Version: 1.0
Author: depaksampath
*/

function add_username_to_header() {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $username = $current_user->user_login;

      

        // Enqueue CSS for the dropdown icon.
        wp_enqueue_style('username-in-header-css', plugin_dir_url(__FILE__) . 'style.css');
    }
}
add_action('wp_head', 'add_username_to_header');

function username_in_header_shortcode() {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $username = $current_user->user_login;

        // Create a shortcode output with the username and logout link.
        return '<div class="username-header"><span>Hi, ' . $username . '</span> <a href="' . wp_logout_url(home_url()) . '">Logout</a></div>';
    }
}
add_shortcode('username_in_header', 'username_in_header_shortcode');
