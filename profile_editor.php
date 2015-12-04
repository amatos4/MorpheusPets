<?php
    // POST keys
    $description_key = 'description-text';
    $active_key = 'profileId';

    // Route to edit pet page if pet id is given
    if ( isset( $_POST[ $description_key ] ) )
    {
        require_once 'actions/profile/edit_description.php';
    }
    else if( isset( $_POST[ $active_key ] ) )
    {
        require_once 'actions/profile/edit_active.php';
    }
