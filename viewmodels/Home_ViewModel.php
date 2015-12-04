<?php
  require_once 'viewmodels/ViewModel.php';

  class Home_ViewModel extends ViewModel
  {
    /*
     * Render the home page
     */
    public function renderHome()
    {
      $view_data[ 'page_title' ] = 'Home';
      $view_data[ 'js' ]         = '<script src="js/index.js"></script>';

      $this->renderTemplate( 'templates/header.php', $view_data );
      $this->renderTemplate( 'templates/home_view.php', $view_data );
      $this->renderTemplate( 'templates/footer.php', $view_data );
    }
  }
