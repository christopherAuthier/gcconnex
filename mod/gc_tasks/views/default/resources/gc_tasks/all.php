<?php

$body = elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'gc_tasks',
));

$body = elgg_view_layout('one_column', array('content' => $body));

echo elgg_view_page("All Tasks", $body);