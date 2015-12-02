<?php
    require_once 'viewmodels/Profile_ViewModel.php';
    require_once 'data/UserSession.php';
    require_once 'data/data.php';
    require_once 'utils/http.php';

    $session = UserSession::getInstance();
    $data    = MorpheusPetsData::getInstance();

    // Get logged in user
    $loggedInUser = $session->getLoggedInUser();

    //Get profile's user
    $profileUser = $data->getUser($_GET['profileId']);

    //Get user profile's pet collection
    $pet_collection = $data->getAllPetsForUser($profileUser->getId());

    // Setup view model
    $viewModel = new Profile_ViewModel( $loggedInUser , $profileUser);

    /** @var Pet $pet */
    foreach ( $pet_collection as $pet )
    {
        if ( $pet->isActive() )
        {
            $viewModel->addPetToActive( $pet );
        }
        else
        {
            $viewModel->addPetToNonActive( $pet );
        }
    }

    $viewModel->renderProfile();
