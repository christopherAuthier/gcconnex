<?php

elgg_register_event_handler('init', 'system', 'gc_tasks_init');

elgg_register_action("gc_tasks/save", __DIR__ . "/actions/gc_tasks/save.php");

function gc_tasks_init() {
    elgg_register_page_handler('gc_tasks', 'gc_tasks_page_handler');

    global $CONFIG;

    elgg_register_menu_item('top_bar', array(
        'name' => 'huzzah - name',
        'href' => $CONFIG->wwwroot . "gc_tasks/all",
        'text' => 'huzzah - text', //elgg_echo('chris_test:menu_item'),
        'priority' => 1000,
    ) );
}

function gc_tasks_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
            echo elgg_view('resources/gc_tasks/add');
            break;

        case 'all':
        default:
            echo elgg_view('resources/gc_tasks/all');
            break;
    }

    return true;
}