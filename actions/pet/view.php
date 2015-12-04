<?php
  require_once 'viewmodels/PetViewer_ViewModel.php';
  require_once 'viewmodels/Error_ViewModel.php';
  require_once 'data/UserSession.php';
  require_once 'data/data.php';

  // GET keys
  $pet_id_key = "pet_id";

  $session = UserSession::getInstance();

  $data = MorpheusPetsData::getInstance();

  $pet_id = null;

  $pet_to_show = null;

  // Get a pet if a pet id was specified
  if ( isset( $_GET[ $pet_id_key ] ) )
  {
    $pet_id      = intval( $_GET[ $pet_id_key ] );
    $pet_to_show = $data->getPet( $pet_id );
  }

  if ( $pet_to_show !== null )
  {
    // Create view model
    $view_model = new PetViewer_ViewModel( $pet_to_show );

    // Add logged in user if such exists
    if ( $session->isUserLoggedIn() )
    {
      $logged_in_user = $session->getLoggedInUser();
      $view_model->setLoggedInUser( $logged_in_user );
    }

    $view_model->renderPet();
  }
  else
  {
    // Pet does not exist
    $view_model = new Error_ViewModel();
    $view_model->renderPetNotExist( $pet_id );
  }


