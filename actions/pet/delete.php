<?php
  require_once 'viewmodels/PetEditor_ViewModel.php';
  require_once 'viewmodels/Error_ViewModel.php';
  require_once 'data/UserSession.php';
  require_once 'data/data.php';
  require_once 'utils/http.php';
  require_once 'utils/string.php';
  require_once 'utils/Pet.php';

  $session = UserSession::getInstance();

  // Redirect to home page if not logged in
  if ( !$session->isUserLoggedIn() )
  {
    HTTPUtils::my_http_redirect( 'index.php' );
  }

  // POST keys
  $pet_id_key = 'pet_id';

  // Form inputs
  $form_pet_id = empty( $_POST[ $pet_id_key ] ) ? null : intval( StringUtils::sanitize( $_POST[ $pet_id_key ] ) );

  $data = MorpheusPetsData::getInstance();

  // Get logged in user
  $logged_in_user = $session->getLoggedInUser();

  // Get pet to edit
  $pet_to_edit = $form_pet_id === null ? null : $data->getPet( $form_pet_id );

  // Check if pet was found
  if ( $pet_to_edit === null )
  {
    // Pet does not exist
    $view_model = new Error_ViewModel();
    $view_model->renderPetNotExist( $form_pet_id );
  }
  elseif ( !PetUtils::userCanEditPet( $logged_in_user, $pet_to_edit ) )
  {
    // Pet does not belong to logged in user
    $view_model = new Error_ViewModel();
    $view_model->renderEditPetNotAllowed( $pet_to_edit );
  }
  else
  {

    // Delete pet
    if ( $data->deletePet( $pet_to_edit->getId() ) )
    {
      // Redirect to profile page
      HTTPUtils::my_http_redirect( "my_profile.php?profileId=" . $logged_in_user->getId() );
    }
    else
    {
      // Pet could not be deleted
      $view_model = new Error_ViewModel();
      $view_model->renderDeletePetFailed( $pet_to_edit );
    }


  }




