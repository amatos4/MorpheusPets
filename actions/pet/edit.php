<?php
  require_once 'viewmodels/PetEditor_ViewModel.php';
  require_once 'data/UserSession.php';
  require_once 'data/data.php';
  require_once 'utils/http.php';

  $session = UserSession::getInstance();
  $data    = MorpheusPetsData::getInstance();

  // POST keys
  $oet_id_key = 'pet_id';

  // Redirect to home page if not logged in
  if ( !$session->isUserLoggedIn() )
  {
    // TODO Uncomment once user login form is complete
//    HTTPUtils::my_http_redirect( 'index.php' );
  }

  // Get logged in user
  $loggedInUser = $session->getLoggedInUser();

  // Get pet to edit
  $id_of_pet_to_edit = isset( $_POST[ $oet_id_key ] ) ? intval( $_POST[ $oet_id_key ] ) : 0;
  $pet_to_edit       = $id_of_pet_to_edit !== 0 ? $data->getPet( $id_of_pet_to_edit ) : null;

  // Get species list
  $species_list = $data->getAllSpecies();

  // Setup view model
  $viewModel = new PetEditor_ViewModel( $loggedInUser );
  $viewModel->setPetToEdit( $pet_to_edit );
  foreach ( $species_list as $species )
  {
    $viewModel->addSelectableSpecies( $species );
  }
  $viewModel->renderEditPet();
