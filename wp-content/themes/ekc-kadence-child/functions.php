<?php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('ekc-child-style', get_stylesheet_uri(), [], wp_get_theme()->get('Version'));
}, 20);

// Load parent styles
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri(), [ 'parent-style' ], wp_get_theme()->get('Version'));
});
