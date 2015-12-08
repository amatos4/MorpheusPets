<?php
  require_once 'viewmodels/Home_ViewModel.php';
  require_once 'data/data.php';

  $data        = MorpheusPetsData::getInstance();
  $recentUsers = $data->getNRecentUsers( 10 );

  $viewModel = new Home_ViewModel();
  foreach ( $recentUsers as $rusers )
  {
    $viewModel->addRecentUsers( $rusers );
  }

  $viewModel->renderHome();
