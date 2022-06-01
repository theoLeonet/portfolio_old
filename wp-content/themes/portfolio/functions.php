<?php

use Timber\Timber;

require_once(__DIR__ . '/vendor/autoload.php');

//Remove block editor
add_filter('use_block_editor_for_post', '__return_false');

//support for thumbnails
add_theme_support('post-thumbnails');

//Create a new Timber instance
$timber = new Timber();

// Register menus
register_nav_menu('header_nav', 'Header Nav');
register_nav_menu('footer_nav', 'Footer Nav');

//Add a filter, so I can add stuff to the context
add_filter('timber/context', 'add_to_context');

function add_to_context(array $context): array
{
    // Add Timber Menu and send it to the context.
    $context['header_nav'] = new \Timber\Menu('header_nav');
    $context['footer_nav'] = new \Timber\Menu('footer_nav');

    return $context;
}

//register a custom post type for the works
register_post_type('work', [
    'label' => 'Works',
    'labels' => [
        'name' => 'Works',
        'singular_name' => 'Work',
    ],
    'description' => 'All the work i’ve done',
    'public' => true,
    'has_archive' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-hammer',
    'supports' => ['title', 'thumbnail'],
    'rewrite' => ['slug' => 'works'],
]);


function portfolio_mix($path)
{
    $path = '/' . ltrim($path, '/');

    if (!realpath(__DIR__ . '/public' . $path)) {
        return;
    }

    if (!($manifest = realpath(__DIR__ . '/public/mix-manifest.json'))) {
        return get_stylesheet_directory_uri() . '/public' . $path;
    }

    // Ouvrir mix-manifest.json
    $manifest = json_decode(file_get_contents($manifest), true);

    // Look if there is a key that corresponds to the file loaded in $path.
    if (!array_key_exists($path, $manifest)) {
        return get_stylesheet_directory_uri() . '/public' . $path;
    }

    // Get and return the versioned path.
    return get_stylesheet_directory_uri() . '/public' . $manifest[$path];
}