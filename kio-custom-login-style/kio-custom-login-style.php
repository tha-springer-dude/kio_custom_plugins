<?php
/*
Plugin Name: Kio Custom Login Style
Description: Custom styling for the WordPress login page.
Version: 1.0
Author: Willie Springer
*/

function kio_login_styles() {

    wp_enqueue_style(
        'kio-login-css',
        plugin_dir_url(__FILE__) . 'assets/login.css'
    );

    // Dynamic background + logo
    $bg = wp_get_attachment_url(2308);
    $logo = plugin_dir_url(__FILE__) . 'assets/logo.png'; // put logo here

    $custom_css = "
        body.login { background-image: url('{$bg}'); }
        body.login div#login h1 a { background-image: url('{$logo}'); }
    ";

    wp_add_inline_style('kio-login-css', $custom_css);
}

add_action('login_enqueue_scripts', 'kio_login_styles');