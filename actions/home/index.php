<?php
  require_once 'viewmodels/Home_ViewModel.php';
  require_once 'data/data.php';

  $data = MorpheusPetsData::getInstance();
  $recentUsers = $data->getNRecentUsers(10);
  // var_dump(recentUsers);
  //var_dump($data->getNRecentUsers(10));
  $viewModel = new Home_ViewModel();
  foreach ( $recentUsers as $rusers )
  {
      $viewModel->addRecentUsers( $rusers );
  }
  // TODO: Complete home action
  $viewModel->renderHome();
