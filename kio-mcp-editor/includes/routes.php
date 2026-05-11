<?php

// includes/routes.php

register_rest_route('custom/v1', '/kio-ai-get-posts', [
    'methods' => 'GET',
    'callback' => 'kio_get_posts',
]);

register_rest_route('custom/v1', '/kio-ai-get-post-pair', [
    'methods' => 'GET',
    'callback' => 'kio_get_post_pair',
]);

register_rest_route('custom/v1', '/kio-ai-update', [
    'methods' => 'POST',
    'callback' => 'kio_test_update',
]);

?>