<?php
    require_once 'viewmodels/Error_ViewModel.php';
    require_once 'data/UserSession.php';
    require_once 'data/data.php';
    require_once 'utils/http.php';
    require_once 'utils/string.php';

    $session = UserSession::getInstance();
    $data    = MorpheusPetsData::getInstance();

    // Get logged in user
    $loggedInUser = $session->getLoggedInUser();

    // Profile id of pets we are editing
    $profileId = $_POST['profileId'];

    // Profile User object
    $profileUser = $data->getUser($profileId);

    // Array of pet id's that the user has chosen as active
    /** @var array $chosen_pets */
    $chosen_petIds = $_POST['active'];

    // New Active Pets Array
    $active_pets = [];

    foreach ($chosen_petIds as $pet_id)
    {
        array_push($active_pets, $data->getPet($pet_id));
    }

    // Check if logged in user is the profile user, if the user is logged in, or they chose 3 active pets
    if(($loggedInUser->getId() == $profileUser->getId()) && !is_null($loggedInUser) && sizeof($active_pets) > 3)
    {
        /** @var array $pet_collection */
        $pet_collection = $data->getAllPetsForUser($profileId);

        /** @var Pet $pet */
        foreach ( $pet_collection as $pet )
        {
            if(in_array($pet, $active_pets))
            {
                // If the pet is meant to be active
                $pet->setActive(true);
            }
            else
            {
                $pet->setActive(false);
            }
            $data->updatePet($pet);
        }

        HTTPUtils::my_http_redirect( "my_profile.php?profileId=$profileId" );
    }
    else
    {
        //Setup view model
        $viewModel = new Error_ViewModel();
        if(sizeof($active_pets) > 3)
        {
            $viewModel->renderEditActivePetsNotAllowed($profileUser->getId());
        }
    }
