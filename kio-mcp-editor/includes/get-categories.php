<?php

function kio_get_categories($request) {

    $terms = get_terms([
        'taxonomy' => 'category',
        'hide_empty' => false
    ]);

    return array_map(function($t) {
        return [
            'id' => $t->term_id,
            'slug' => $t->slug,
            'name' => $t->name
        ];
    }, $terms);
}