<?php
function kio_get_post_pair($request) {

    $post_id = intval($request->get_param('post_id'));

    $translations = pll_get_post_translations($post_id);

    $en_id = $translations['en'] ?? null;
    $de_id = $translations['de'] ?? null;

    return [
        'en' => [
            'id' => $en_id,
            'title' => get_the_title($en_id),
            'content' => get_post_field('post_content', $en_id)
        ],
        'de' => [
            'id' => $de_id,
            'title' => get_the_title($de_id),
            'content' => get_post_field('post_content', $de_id)
        ]
    ];
}
?>