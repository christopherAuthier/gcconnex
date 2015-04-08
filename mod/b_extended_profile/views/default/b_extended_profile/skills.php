<?php
$user_guid = elgg_get_page_owner_guid();
$user = get_user($user_guid);

echo '<div class="gcconnex-profile-section-wrapper gcconnex-skills">'; // create the profile section wrapper div for css styling
echo '<div class="gcconnex-profile-title">' . elgg_echo('gcconnex_profile:gc_skills') . '</div>'; // create the profile section title

if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
    // create the edit/save/cancel toggles for this section
    echo '<span class="gcconnex-profile-edit-controls">';
    echo '<span class="edit-control edit-skills"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">' . elgg_echo('gcconnex_profile:edit') . '</span>';
    echo '<span class="save-control save-skills hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">' . elgg_echo('gcconnex_profile:save') . '</span>';
    echo '<span class="cancel-control cancel-skills hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">' . elgg_echo('gcconnex_profile:cancel') . '</span>';
    echo '</span>';
}

// if skills isn't empty, display them so that the user can use them as a guide
if ($user->skills != NULL && $user->skillsupgraded == NULL) {
    echo '<div class="gcconnex-old-skills">';
    echo '<div class="gcconnex-old-skills-message">You have previously entered skills which may need to be re-entered in the system. Please review your previously entered skills below and re-enter them as needed. When entering or re-entering a skill, <b>please make sure they are actual  skills that you believe you possess, that they are specific, professional and that they provide viewers of your profile with clear, meaningful and useful information</b> (ie: Not "A bunch of things.. " or "Getting things done!").</div>';
    echo '<div class="gcconnex-old-skills-display">';

    if (is_array($user->skills)) {
        foreach ($user->skills as $oldskill)
        echo $oldskill . '<br>';
    }

    echo '</div><br>'; // close div class="gcconnex-old-skills-display
    echo '<span class="gcconnex-old-skills-stop-showing gcconnex-profile-button" onclick="removeOldSkills()">Stop showing me this message.</span>';
    echo '</div>'; // close div class="gcconnex-old-skills"
}

$skill_guids = $user->gc_skills;

echo '<div class="gcconnex-profile-skills-display">';
echo '<div class="gcconnex-skills-skills-list-wrapper">';

if ($skill_guids == NULL || empty($skill_guids)) {
    echo elgg_echo('gcconnex_profile:gc_skill:empty');
}
else {
    if (!(is_array($skill_guids))) {
        $skill_guids = array($skill_guids);
    }
// if the skill list isn't empty, and a logged-in user is viewing this page... show skills
    if (elgg_is_logged_in()) {
        foreach ($skill_guids as $skill_guid) {
            $skill = get_entity($skill_guid);
            $skill_class = str_replace(' ', '-', strtolower($skill->title));
            echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guid . '">';
            echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';

            $endorsements = $skill->endorsements;
            if (!(is_array($endorsements))) {
                $endorsements = array($endorsements);
            }

            if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
                if (in_array(elgg_get_logged_in_user_guid(), $endorsements) == false || empty($endorsements)) {
                    // user has not yet endorsed this skill for this user.. present the option to endorse

                    echo '<span class="gcconnex-endorsement-add elgg-button" onclick="addEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">Endorse</span>';
                } else {
                    // user has endorsed this skill for this user.. present the option to retract endorsement
                    echo '<span class="gcconnex-endorsement-retract elgg-button" onclick="retractEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">Retract Endorsement</span>';

                }
            }
            // @todo: add the endorsing user's profile image to the list of endorsers for this skill
            echo '<div class="gcconnex-skill-endorsements">';
            echo list_avatars(array(
                'guids' => $skill->endorsements,
                'size' => 'tiny',
                'limit' => 10
            ));
            echo '</div>'; // close div class="gcconnex-skill-endorsements"
            echo '</div>'; // close div class=gcconnex-skill-entry
        }

    }
}

//echo '</div></div><div class="endorsements-message"></div>';
echo '</div>';
echo '</div>';
echo '</div>'; // close div class=gcconnex-profile-section-wrapper
