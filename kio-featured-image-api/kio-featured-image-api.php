<?php
/*
Plugin Name: Kio Featured Image API
Description: Custom REST endpoint to set featured images programmatically.
Version: 1.0
Author: Willie Springer
*/

/*
|--------------------------------------------------------------------------
| Safety Check
|--------------------------------------------------------------------------
*/
if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Register REST Route
|--------------------------------------------------------------------------
*/
add_action('rest_api_init', function () {

    register_rest_route('ob/v1', '/set-featured-image', [
        'methods'  => 'POST',
        'callback' => 'ob_set_featured_image_callback',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);

});


/*
|--------------------------------------------------------------------------
| Set Featured Image Callback
|--------------------------------------------------------------------------
| Expects:
| - post_id (int)
| - image_id (int, optional)
|
| If image_id is invalid or missing,
| fallback image will be used.
|--------------------------------------------------------------------------
*/
function ob_set_featured_image_callback($request) {

    $post_id  = intval($request->get_param('post_id'));
    $image_id = intval($request->get_param('image_id'));

    if (!$post_id) {
        return new WP_Error(
            'missing_post_id',
            'post_id is required',
            ['status' => 400]
        );
    }

    if (!get_post($post_id)) {
        return new WP_Error(
            'invalid_post',
            'Post does not exist',
            ['status' => 400]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Define Fallback Image ID
    |--------------------------------------------------------------------------
    | Replace 123 with your actual fallback image ID
    */
    $fallback_image_id = 123; // <-- CHANGE THIS

    if (!$image_id || !wp_attachment_is_image($image_id)) {
        $image_id = $fallback_image_id;
    }

    set_post_thumbnail($post_id, $image_id);

    return [
        'success'  => true,
        'post_id'  => $post_id,
        'image_id' => $image_id,
    ];
}