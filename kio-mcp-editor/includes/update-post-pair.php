<?php
    // function kio_test_update($request) {

    // $data = $request->get_json_params();

    // update_option('kio_last_update_test', $data);

    // return [
    //     'success' => true,
    //     'received' => $data
    // ];
    // }

function kio_update_post_pair($request) {



    $data = $request->get_json_params();

    $post_id = intval($data['post_id'] ?? 0);
    $content = $data['content'] ?? [];

    if (!$post_id || empty($content)) {
        return [
            'success' => false,
            'error' => 'missing data'
        ];
    }

    // get translations (Polylang)
    $translations = pll_get_post_translations($post_id);

    foreach ($translations as $lang => $id) {

        if (!isset($content[$lang])) continue;

        wp_update_post([
            'ID' => $id,
            'post_content' => $content[$lang]
        ]);
    }

    return [
        'success' => true,
        'updated' => $translations
    ];
}
?>