<?php
    require_once 'viewmodels/Profile_ViewModel.php';
    require_once 'viewmodels/Error_ViewModel.php';
    require_once 'data/UserSession.php';
    require_once 'data/data.php';
    require_once 'utils/http.php';

    $session = UserSession::getInstance();
    $data    = MorpheusPetsData::getInstance();

    // Get logged in user
    $loggedInUser = $session->getLoggedInUser();

    // Get profile id
    $profileId = $_GET['profileId'];

    //Get profile's user
    $profileUser = $data->getUser($profileId);

    if(!is_null($profileUser))
    {
        //Get user profile's pet collection
        $pet_collection = $data->getAllPetsForUser($profileUser->getId());

        // Setup view model
        $viewModel = new Profile_ViewModel( $loggedInUser , $profileUser);

        $viewModel->setPetCollection($pet_collection);

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
    }
    else
    {
        //Setup view model
        $viewModel = new Error_ViewModel();
        $viewModel->renderUserNotExist($profileId);
    }
