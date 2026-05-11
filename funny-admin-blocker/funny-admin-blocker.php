<?php
/**
 * Plugin Name: Funny Admin Blocker
 * Description: Redirects wp-admin access for non-logged-in users to a funny page.
 * Version: 1.0
 */

add_action('init', function() {

    // Only affect non-logged-in users
    if (is_user_logged_in()) return;

    $request = $_SERVER['REQUEST_URI'];

    // Catch wp-admin and common typos
    if (preg_match('#/wp-admi[nm]#', $request) || preg_match('#/wp-login#', $request)) {
        wp_redirect(home_url('/gotcha/'));
        exit;
    }
});