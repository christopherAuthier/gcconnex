<?php
// get the form inputs
$title = get_input('title');
$body = get_input('body');
$tags = string_to_tag_array(get_input('tags'));

// create a new gc_tasks object
$task = new ElggObject();
$task->subtype = "gc_tasks";
$task->title = $title;
$task->description = $body;

// for now make all gc_tasks public
$task->access_id = ACCESS_PUBLIC;

// owner is logged in user
$task->owner_guid = elgg_get_logged_in_user_guid();

// save tags as metadata
$task->tags = $tags;

// save to database and get id of the new task
$task_guid = $task->save();

// if the task was saved, we want to display it
// otherwise, we want to register an error and forward back to the form
if ($task_guid) {
    system_message("Your task was saved");
    forward($task->getURL());
} else {
    register_error("The task could not be saved");
    forward(REFERER); // REFERER is a global variable that defines the previous page
}