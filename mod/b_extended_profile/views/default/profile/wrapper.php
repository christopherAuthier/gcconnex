<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Wrap the user profile details in divs for css styling and for jQuery elements (edit/save/cancel controls below)
 * Requires: Sections must be pre-populated in the $sections array below. The view for that section must be registered in start.php, and the file has
 * to be in lowercases, named the same as what you populate $sections with, but replacing spaces with dashes.
 * IE: "About Me" becomes "about-me.php"
 */

elgg_load_js('gcconnex-profile'); // js file for handling the edit/save/cancel toggles
elgg_load_css('gcconnex-css'); // main css styling sheet
elgg_load_css('font-awesome'); // font-awesome icons for social media and some of the basic profile fields

?>

<div class="profile elgg-col-3of3">
    <div class="elgg-inner clearfix">
        <?php echo elgg_view('profile/owner_block'); ?>
        <?php echo elgg_view('profile/details'); ?>
    </div>


    <div class="gcconnex-profile-wire-post">
        <?php $user = get_user(elgg_get_page_owner_guid());
            $params = array(
                'type' => 'object',
                'subtype' => 'thewire',
                'owner_guid' => $user->guid,
                'limit' => 1,
            );
        $latest_wire = elgg_get_entities($params);
        if ($latest_wire && count($latest_wire) > 0) {
            echo '<img class="profile-icons double-quotes" src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/double-quotes.png">';
            echo elgg_view("profile/status", array("entity" => $user));
        }
        else {
            error_log('false');
        }
        error_log(print_r($latest_wire, 1)); ?>
    </div>

    <div class="b_extended_profile">
        <?php
        //@todo: only show sections if they have content

        // pre-populate the sections that are not empty so that we can build the profile
        $sections = array();

        if ($user = get_user(elgg_get_page_owner_guid()))
        {
            if ($user->get("description") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
               // $sections[] = elgg_echo('gcconnex_profile:about_me');
                }
            if ($user->get("education") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
               // $sections[] = elgg_echo('gcconnex_profile:education');
            }
            if ($user->get("work") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
               // $sections[] = elgg_echo('gcconnex_profile:experience');
            }
            if ($user->get("gc_skills") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
               // $sections[] = elgg_echo('gcconnex_profile:gc_skills');
            }
            if ($user->get("langs") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
               // $sections[] = elgg_echo('gcconnex_profile:langs');
            }
        }

        echo '<div role="tabpanel">';
        echo '<ul class="nav nav-tabs" role="tablist">';
        echo '<li role="presentation" class="active"><a href="#splashboard" aria-controls="splashboard" role="tab" data-toggle="tab">' . elgg_echo('gcconnex_profile:widgets') . '</a></li>';
        echo '<li role="presentation"><a href="#profile-display" aria-controls="profile-display" role="tab" data-toggle="tab">' . elgg_echo('gcconnex_profile:profile') . '</a></li>';
        echo '<li role="presentation"><a href="#publications" aria-controls="publications" role="tab" data-toggle="tab">' . elgg_echo('gcconnex_profile:portfolio') . '</a></li>';
        echo '</ul>';
        echo '<div class="tab-content">';
            echo '<div role="tabpanel" class="tab-pane active" id="splashboard">';

                $num_columns = elgg_extract('num_columns', $vars, 3);
                $show_add_widgets = elgg_extract('show_add_widgets', $vars, true);
                $exact_match = elgg_extract('exact_match', $vars, false);
                $show_access = elgg_extract('show_access', $vars, true);

                $owner = elgg_get_page_owner_entity();

                $widget_types = elgg_get_widget_types();

                $context = elgg_get_context();
                elgg_push_context('widgets');

                $widgets = elgg_get_widgets($owner->guid, $context);

                if (elgg_can_edit_widget_layout($context)) {

                    $params = array(
                        'widgets' => $widgets,
                        'context' => $context,
                        'exact_match' => $exact_match,
                        'show_access' => $show_access,
                    );
                    echo elgg_view('page/layouts/widgets/add_panel', $params);
                }
                if (elgg_can_edit_widget_layout($context)) {
                    if ($show_add_widgets) {
                        echo elgg_view('page/layouts/widgets/add_button');
                    }

                    $params = array(
                        'widgets' => $widgets,
                        'context' => $context,
                        'exact_match' => $exact_match,
                    );
                    echo elgg_view('page/layouts/widgets/add_panel', $params);
                }
                $widget_class = "elgg-col-1of{$num_columns}";
                for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
                    if (isset($widgets[$column_index])) {
                        $column_widgets = $widgets[$column_index];
                    } else {
                        $column_widgets = array();
                    }

                    echo "<div class=\"$widget_class elgg-widgets\" id=\"elgg-widget-col-$column_index\">";
                    if (sizeof($column_widgets) > 0) {
                        foreach ($column_widgets as $widget) {
                            if (array_key_exists($widget->handler, $widget_types)) {
                                echo elgg_view_entity($widget, array('show_access' => $show_access));
                            }
                        }
                    }
                    echo '</div>';
                }
            echo '</div>'; // close div id="splashboard"


            echo '<div role="tabpanel" class="tab-pane" id="profile-display">';

            echo elgg_view('b_extended_profile/about-me');
            echo elgg_view('b_extended_profile/education');
            echo elgg_view('b_extended_profile/work-experience');
            echo elgg_view('b_extended_profile/skills');
            echo elgg_view('b_extended_profile/languages');

        // create the div wrappers and edit/save/cancel toggles for each profile section

            echo '</div>'; //close div id=#profile-display


            echo '<div role="tabpanel" class="tab-pane" id="publications">';
                echo elgg_view('b_extended_profile/publications'); // call the proper view for the section
            echo '</div>'; // close div id="#publications"


            echo '</div>'; // close div class="tab-content'
        echo '</div>'; // close div role="tabpanel"
        ?>
    </div>
</div>