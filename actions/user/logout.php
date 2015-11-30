<?php
  require_once 'data/UserSession.php';
  require_once 'utils/http.php';

  $session = UserSession::getInstance();

  // Destroy session if exists and redirect to home
  if ( $session->isUserLoggedIn() )
  {
    $session->destroySession();
  }

  HTTPUtils::my_http_redirect( 'index.php' );
