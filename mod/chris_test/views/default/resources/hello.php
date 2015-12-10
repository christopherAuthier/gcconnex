<?php

$params = array(
    'title' => elgg_echo('chris_test:header'),
    'content' => elgg_echo('chris_test:content'),
    'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page(elgg_echo('chris_test:title'), $body);