<?php
    require_once 'viewmodels/Battle_ViewModel.php';
    require_once 'viewmodels/Error_ViewModel.php';
    require_once 'data/UserSession.php';
    require_once 'data/data.php';
    require_once 'utils/http.php';

    $session = UserSession::getInstance();
    $data    = MorpheusPetsData::getInstance();

    // Get logged in user
    $loggedInUser = $session->getLoggedInUser();

    // Get profile id
	
    if(!is_null($loggedInUser))
    {
        // Setup view model
        $viewModel = new Battle_ViewModel( $loggedInUser);
        $viewModel->renderBattle();
    }
    else
    {
        //Setup view model
        $viewModel = new Error_ViewModel();
        $viewModel->renderUserNotExist($loggedInUser);
    }
