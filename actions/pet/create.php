<?php
  require_once 'viewmodels/PetEditor_ViewModel.php';
  require_once 'data/UserSession.php';
  require_once 'data/data.php';
  require_once 'utils/http.php';

  $session = UserSession::getInstance();
  $data    = MorpheusPetsData::getInstance();

  // Redirect to home page if not logged in
  if ( !$session->isUserLoggedIn() )
  {
    // TODO Uncomment once user login form is complete
//    HTTPUtils::my_http_redirect( 'index.php' );
  }

  // Get logged in user
  $loggedInUser = $session->getLoggedInUser();

  // Get species list
  $speciesList = $data->getAllSpecies();

  // Setup view model
  $viewModel = new PetEditor_ViewModel( $loggedInUser );
  foreach ( $speciesList as $species )
  {
    $viewModel->addSelectableSpecies( $species );
  }
  $viewModel->renderCreatePet();
