<?php
  require_once 'viewmodels/User_ViewModel.php';
  require_once 'data/UserSession.php';
  require_once 'utils/http.php';

  $session = UserSession::getInstance();

  // Redirect to home page if already logged in
  if ( $session->isUserLoggedIn() )
  {
    HTTPUtils::my_http_redirect( 'index.php' );
  }

  $viewModel = new User_ViewModel();

  $viewModel->renderRegisterUser();
