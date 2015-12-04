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

    $edited_description = StringUtils::sanitize($_POST['description-text']);
    $profileId = $_POST['profile-user'];
    $profileUser = $data->getUser($profileId);

    if(($loggedInUser->getId() == $profileUser->getId()) && !is_null($loggedInUser))
    {
        $data->updateUser($profileUser, $edited_description);
        HTTPUtils::my_http_redirect( "my_profile.php?profileId=$profileId" );
    }
    else
    {
        //Setup view model
        $viewModel = new Error_ViewModel();
        $viewModel->renderUserNotExist();
    }