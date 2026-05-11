<?php
/*
Plugin Name: KIO MCP Editor
Description: REST API endpoints for AI-driven post editing (EN/DE) via MCP-style tools.
Version: 1.0
Author: Willie Springer
*/

// kio-mcp-editor.php
    require_once __DIR__ . '/includes/get-posts.php';
    require_once __DIR__ . '/includes/get-post-pair.php';
    require_once __DIR__ . '/includes/update-post-pair.php';

add_action('rest_api_init', function () {

    require_once __DIR__ . '/includes/routes.php';
});
?>