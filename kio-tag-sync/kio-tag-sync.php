<?php
/*
Plugin Name: Kio Tag Sync
Description: Syncs post tags across languages using Polylang.
Version: 1.0
Author: Willie Springer
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
    register_rest_route('custom/v1', '/sync-tags', [
        'methods'  => 'POST',
        'callback' => 'kio_sync_tags_callback',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
});

/*
|--------------------------------------------------------------------------
| Main Callback
|--------------------------------------------------------------------------
*/
function kio_sync_tags_callback($request) {

    if (!function_exists('pll_get_term')) {
        return new WP_Error(
            'polylang_missing',
            'Polylang not active',
            ['status' => 500]
        );
    }

    $en_id = intval($request->get_param('en_id'));
    $de_id = intval($request->get_param('de_id'));

    if (!$en_id || !$de_id) {
        return new WP_Error(
            'missing_ids',
            'Both en_id and de_id are required',
            ['status' => 400]
        );
    }

    if (!get_post($en_id) || !get_post($de_id)) {
        return new WP_Error(
            'invalid_post',
            'One or both post IDs do not exist',
            ['status' => 400]
        );
    }

    // 🔥 sync FROM EN → TO DE
    kio_sync_tags($en_id, $de_id,  'de');

    return [
        'success' => true,
        'synced' => [
            'from' => $de_id,
            'to'   => $en_id,
        ],
    ];
}

/*
|--------------------------------------------------------------------------
| Core Sync Logic
|--------------------------------------------------------------------------
*/
function kio_sync_tags($source_post_id, $target_post_id, $target_lang) {

    $terms = wp_get_post_terms($source_post_id, 'post_tag', ['fields' => 'ids']);

    if (empty($terms)) {
        return;
    }

    $translated_terms = [];

    foreach ($terms as $term_id) {
        $translated_id = pll_get_term($term_id, $target_lang);

        if ($translated_id) {
            $translated_terms[] = $translated_id;
        }
    }

    if (!empty($translated_terms)) {
        wp_set_post_terms($target_post_id, $translated_terms, 'post_tag');
    }
}
