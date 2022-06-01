<?php

use Timber\Post;
use Timber\Timber;

$context = Timber::context();

$timber_post = new Post();
$context['post'] = $timber_post;

Timber::render([
    '/pages/page_' . $timber_post->name . '.twig',
    'page.twig'
],
    $context);