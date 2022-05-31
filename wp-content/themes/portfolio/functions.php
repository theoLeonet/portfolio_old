<?php

use Timber\Timber;

require_once(__DIR__ . '/vendor/autoload.php');

//Remove block editor
add_filter('use_block_editor_for_post', '__return_false');

//support for thumbnails
add_theme_support('post-thumbnails');

//Create a new Timber instance

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