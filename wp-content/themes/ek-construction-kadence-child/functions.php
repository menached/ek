<?php

/**
 * EK Construction Child Theme Functions
 *
 * Uses Orbisius parent/child enqueue (for Kadence compatibility)
 * AND modular /css/ file enqueuing
 */

// 1. ORBISIUS ENQUEUE BLOCK (Parent + Child style.css)
function ekc_orbisius_enqueue_styles()
{
    global $wp_styles;
    $parent_style = 'orbisius_ct_ek_construction_kadence_child_parent_style';
    $parent_base_dir = 'kadence';
    $child_dir_id = basename(get_stylesheet_directory());
    // Dequeue possible earlier enqueues
    if (!empty($wp_styles->queue)) {
        $srch_arr = [
            $parent_base_dir,
            $parent_base_dir . '-style',
            $parent_base_dir . '_style',
            $child_dir_id,
            $child_dir_id . '-style',
            $child_dir_id . '_style',
        ];
        foreach ($wp_styles->queue as $registered_style_id) {
            if (in_array($registered_style_id, $srch_arr)) {
                wp_dequeue_style($registered_style_id);
                wp_deregister_style($registered_style_id);
            }
        }
    }
    // Parent theme style.css
    $parent_ver = file_exists(get_template_directory() . '/style.css') ? filemtime(get_template_directory() . '/style.css') : time();
    wp_enqueue_style(
        $parent_style,
        get_template_directory_uri() . '/style.css',
        [],
        $parent_ver
    );
    // Child theme style.css
    wp_enqueue_style(
        $parent_style . '_child_style',
        get_stylesheet_directory_uri() . '/style.css',
        [ $parent_style ],
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts', 'ekc_orbisius_enqueue_styles', 25);

// 2. MODULAR /css/ ENQUEUE BLOCK
add_action('wp_enqueue_scripts', function () {
    $modular_styles = [
        'base-fonts.css',
        'headings.css',
        'header.css',
        'footer.css',
        'hero.css',
        'faq.css',
        'forms.css',
        'lists.css',
        'about.css',
        'faq.css',
        'custom.css'
    ];
    foreach ($modular_styles as $file) {
        $handle = 'ekc-' . str_replace(['.css', '/'], ['', '-'], $file);
        $path = get_stylesheet_directory() . '/css/' . $file;
        if (file_exists($path)) {
            wp_enqueue_style($handle, get_stylesheet_directory_uri() . '/css/' . $file, [ 'orbisius_ct_ek_construction_kadence_child_parent_style_child_style' ], filemtime($path));
        }
    }
}, 30);

// (Add other theme functions as needed)
