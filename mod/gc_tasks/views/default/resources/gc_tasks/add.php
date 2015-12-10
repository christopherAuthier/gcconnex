<?php
// make sure only logged in users can see this page
gatekeeper();

// set the title
// be sure to use ``elgg_echo()`` for internationalization if you need it
$title = "Create a new task";

// start building the main column of the page
$content = elgg_view_title($title);

// add the form to this section
$content .= elgg_view_form("gc_tasks/save");

// optionally, add the content for the sidebar
$sidebar = "";

// layout the page
$body = elgg_view_layout('one_sidebar', array(
    'content' => $content,
    'sidebar' => $sidebar
));

// draw the page, including the HTML wrapper and basic page layout
echo elgg_view_page($title, $body);