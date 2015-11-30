<?php
  require_once 'viewmodels/Home_ViewModel.php';
  require_once 'data/data.php';

  $data = MorpheusPetsData::getInstance();

  $viewModel = new Home_ViewModel();

  // TODO: Complete home action
//  // Get posts
//  $postsData = $data->getLastNPosts( $numberOfPostsToShow );
//
//  foreach ( $postsData as $postData )
//  {
//    $viewModel->addPost( $postData );
//  }

  $viewModel->renderHome();
