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
register_nav_menu('primary', 'Navigation principale (haut de page)');
register_nav_menu('secondary', 'Navigation secondaire (bas de page)');

//Add a filter, so I can add stuff to the context
add_filter('timber/context', 'add_to_context');

function add_to_context(array $context): array
{
    // Add Timber Menu and send it to the context.
    $context['primary_menu'] = new \Timber\Menu('primary');
    $context['footer_menu'] = new \Timber\Menu('secondary');

    return $context;
}

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