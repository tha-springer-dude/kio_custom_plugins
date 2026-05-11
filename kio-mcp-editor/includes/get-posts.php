<?php

function kio_get_posts($request) {

    $cat_id = $request->get_param('category');
    $lang = $request->get_param('lang');
    /*
    $posts = get_posts([
        'category_name' => $category,
        'numberposts' => 10,
        'lang' => 'en'
    ]);*/

    $posts = get_posts([
    'cat' => $cat_id,
    'numberposts' => 10,
    'lang' => $lang
    ]);

    return array_map(function($p) {
        return [
            'id' => $p->ID,
            'title' => $p->post_title
        ];
    }, $posts);
}
?>