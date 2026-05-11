<?php

function kio_get_posts($request) {

    $category = $request->get_param('category');

    $posts = get_posts([
        'category_name' => $category,
        'numberposts' => 10,
        'lang' => 'en'
    ]);

    return array_map(function($p) {
        return [
            'id' => $p->ID,
            'title' => $p->post_title
        ];
    }, $posts);
}
?>