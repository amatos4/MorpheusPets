<?php
  require_once 'viewmodels/Home_ViewModel.php';
  require_once 'data/data.php';

  $data = MorpheusPetsData::getInstance();

  $viewModel = new Home_ViewModel();

  // TODO: Complete home action

  $viewModel->renderHome();
