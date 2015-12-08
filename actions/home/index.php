<?php
  require_once 'viewmodels/Home_ViewModel.php';
  require_once 'data/data.php';

  $data        = MorpheusPetsData::getInstance();
  $recentUsers = $data->getNRecentUsers( 5 );

  $viewModel = new Home_ViewModel();
  /** @var User $user */
  foreach ($recentUsers as $user )
  {
    $active_pets = $data->getActivePetsForUser( $user->getId() );

    $user_active_pet_array = [ "user" => $user, "active_pets" => $active_pets ];

    $viewModel->addRecentUsers( $user_active_pet_array );
  }

  $viewModel->renderHome();
