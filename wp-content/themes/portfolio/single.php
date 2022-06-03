<?php

use Timber\Timber;

$context = Timber::context();
$timber_post = Timber::get_post();
$context['work'] = $timber_post;

if ($timber_post->post_type == 'work') {
    $works = get_posts([
        'post_type' => 'work',
        'post_status' => 'publish',
        'meta_key' => 'date',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'fields' => 'ids', // Only get post IDs
        'posts_per_page' => -1
    ]);

    $current_index = array_search($timber_post->ID, $works);

    if (isset($works[$current_index - 1])) {
        $context['previous_work'] = Timber::get_post($works[$current_index - 1]);
    }

    if (isset($works[$current_index + 1])) {
        $context['next_work'] = Timber::get_post($works[$current_index + 1]);
    }
}

Timber::render(
    [
        '/singles/single_' . $timber_post->post_name . '.twig',
        '/singles/single.twig'
    ],
    $context);

