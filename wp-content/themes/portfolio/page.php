<?php

use Timber\Post;
use Timber\Timber;

$context = Timber::context();

$timber_post = new Post();
$context['post'] = $timber_post;

if ($timber_post->meta('unique_name') == 'my_works') {
    $context['works'] = Timber::get_posts([
        'post_type' => 'work',
        'order_by' => 'desc',
        'posts_per_page' => -1,
    ]);
}

Timber::render([
    '/pages/page_' . $timber_post->meta('unique_name') . '.twig',
    'page.twig'
],
    $context);