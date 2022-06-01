<?php

use Timber\Timber;

$context = Timber::context();

$context['latest_works'] = Timber::get_posts(array(
    'post_type' => 'work',
    'order_by' => 'desc',
    'post_per_page' => 1,
));

Timber::render('index.twig', $context);