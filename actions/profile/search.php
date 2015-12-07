<?php
require_once 'viewmodels/Profile_ViewModel.php';
require_once 'viewmodels/Error_ViewModel.php';
require_once 'data/UserSession.php';
require_once 'data/data.php';
require_once 'utils/http.php';
require_once 'utils/string.php';

$session = UserSession::getInstance();
$data    = MorpheusPetsData::getInstance();

// Get logged in user
$loggedInUser = $session->getLoggedInUser();

// Username searched
$usernameSearched = StringUtils::sanitize($_POST['search']);

//Get profile's user
$profileUser = $data->getUserByUserName($usernameSearched);

if(!is_null($profileUser))
{
    $profileId = $profileUser->getId();
    HTTPUtils::my_http_redirect( "my_profile.php?profileId=$profileId" );
}
else
{

    $ret = $data->getLikeUsers($usernameSearched);

    if( !is_null($ret) )
    {
        $viewModel = new Profile_ViewModel($loggedInUser, $profileUser);
        $viewModel->renderSearchResults( $ret );
    }
    else {
        //Setup view model
        $viewModel = new Error_ViewModel();
        $viewModel->renderFailSearch($usernameSearched);
    }
}

