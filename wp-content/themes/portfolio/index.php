<?php

use Timber\Timber;

$context = Timber::context();

$context['latest_works'] = Timber::get_posts([
    'post_type' => 'work',
    'posts_per_page' => 1,
]);

Timber::render('index.twig', $context);