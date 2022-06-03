<?php

use Portfolio\Controllers\ContactFormController;
use Timber\Timber;

require_once(__DIR__ . '/vendor/autoload.php');

//Remove block editor
add_filter('use_block_editor_for_post', '__return_false');

//support for thumbnails
add_theme_support('post-thumbnails');

add_action('init', 'portfolio_session', 1);

function portfolio_session()
{
    if (!session_id()) {
        session_start();
    }

    if (isset($_SESSION['contact_form_feedback']['success'])) {
        session_destroy();
    }
}

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
    $context['days_left'] = (new DateTime("2023-06-30"))->diff(new DateTime('now'))->format("%a");

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
    'supports' => ['title', 'thumbnail', 'editor'],
    'rewrite' => ['slug' => 'works'],
]);

// Add a unique name field to acf
add_filter('acf/validate_value/name=' . 'unique_name', 'acf_unique_value_field', 10, 4);

function acf_unique_value_field($valid, $value, $field, $input)
{
    if (!$valid || (!isset($_POST['post_ID']) && !isset($_POST['post_id']))) {
        return $valid;
    }
    if (isset($_POST['post_ID'])) {
        $post_id = intval($_POST['post_ID']);
    } else {
        $post_id = intval($_POST['post_id']);
    }
    if (!$post_id) {
        return $valid;
    }
    $post_type = get_post_type($post_id);
    $field_name = $field['name'];
    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish, draft, trash',
        'post__not_in' => [$post_id],
        'meta_query' => [
            [
                'key' => $field_name,
                'value' => $value
            ]
        ]

    );
    $query = new WP_Query($args);
    if (count($query->posts)) {
        return 'This Value is not Unique. Please enter a unique ' . $field['label'];
    }
    return true;
}

// Find a post based on its unique name
function portfolio_get_by_unique_name(string $post_type, string $post_unique_name = null)
{
    $post = new WP_Query([
        'post_type' => $post_type,
        'meta_query' => [
            [
                'key' => 'nom_unique',
                'value' => $post_unique_name,
            ],
        ]
    ]);

    return $post->post;
}

//Things to do on form sending
add_action('admin_post_nopriv_submit_contact_form', 'portfolio_handle_submit_contact_form');

function portfolio_handle_submit_contact_form()
{
    $form = new ContactFormController($_POST);
}

function portfolio_get_contact_field_value($field)
{
    if (!isset($_SESSION['contact_form_feedback'])) {
        return '';
    }

    return $_SESSION['contact_form_feedback']['data'][$field] ?? '';
}

function portfolio_get_contact_field_error($field)
{
    if (!isset($_SESSION['contact_form_feedback'])) {
        return '';
    }

    if (!($_SESSION['contact_form_feedback']['errors'][$field] ?? null)) {
        return '';
    }

    return '<p>' . $_SESSION['contact_form_feedback']['errors'][$field] . '</p>';
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