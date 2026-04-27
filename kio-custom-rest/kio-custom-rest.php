<?php
/*
Plugin Name: KIO Polylang Linker
Description: Custom REST endpoint to link EN and DE posts via Polylang.
Version: 1.0
Author: KIO
*/

/*
|--------------------------------------------------------------------------
| Safety Check
|--------------------------------------------------------------------------
| Prevents direct access to this file.
| If WordPress is not loaded, the plugin stops immediately.
*/
if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Register REST Route
|--------------------------------------------------------------------------
| When the REST API is ready, we create our custom endpoint.
| This endpoint allows us to connect English and German posts
| so Polylang knows they belong together.
*/
add_action('rest_api_init', 'kio_register_link_posts_route');

function kio_register_link_posts_route() {

    register_rest_route('custom/v1', '/link-posts', array(
        'methods'  => 'POST',
        'callback' => 'kio_link_posts_callback',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ));
}

/*
|--------------------------------------------------------------------------
| Main Callback Function
|--------------------------------------------------------------------------
| This runs when someone calls the REST endpoint.
| It:
| 1. Checks if Polylang is active
| 2. Reads the post IDs from the request
| 3. Validates them
| 4. Sets the correct language for each post
| 5. Links them together as translations
*/
function kio_link_posts_callback($request) {

    if (!function_exists('pll_set_post_language')) {
        return new WP_Error(
            'polylang_missing',
            'Polylang not active',
            array('status' => 500)
        );
    }

    $en_id = intval($request->get_param('en_id'));
    $de_id = intval($request->get_param('de_id'));

    if (!$en_id || !$de_id) {
        return new WP_Error(
            'missing_ids',
            'Both en_id and de_id are required',
            array('status' => 400)
        );
    }

    if (!get_post($en_id) || !get_post($de_id)) {
        return new WP_Error(
            'invalid_post',
            'One or both post IDs do not exist',
            array('status' => 400)
        );
    }

    /*
    ----------------------------------------------------------------------
    Set the language for each post explicitly.
    This makes sure the English post is marked as EN
    and the German post is marked as DE.
    ----------------------------------------------------------------------
    */
    pll_set_post_language($en_id, 'en');
    pll_set_post_language($de_id, 'de');

    /*
    ----------------------------------------------------------------------
    Link the two posts together.
    This tells Polylang that these posts are translations
    of the same content.
    ----------------------------------------------------------------------
    */
    pll_save_post_translations(array(
        'en' => $en_id,
        'de' => $de_id,
    ));

    return array(
        'success' => true,
        'linked'  => array(
            'en' => $en_id,
            'de' => $de_id,
        ),
    );
}
