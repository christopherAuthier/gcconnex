<?php

elgg_register_event_handler('init', 'system', 'chris_test_init');

function chris_test_init() {
    elgg_register_page_handler('hello', 'chris_test_page_handler');
}

function chris_test_page_handler() {
    // tutorial from https://github.com/Elgg/Elgg/blob/1.12/docs/tutorials/hello_world.rst
    /*$params = array(
        'title' => 'Hello world!',
        'content' => 'This is my first plugin.',
        'filter' => '',
    );

    $body = elgg_view_layout('content', $params);

    echo elgg_view_page('Hello', $body);*/

    echo elgg_view('resources/hello');
}