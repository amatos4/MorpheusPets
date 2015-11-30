<?php
  require_once 'data/UserSession.php';

  class ViewModel
  {
    /**
     * @var UserSession current user session
     */
    private $session;

    public function __construct()
    {
      $this->session = UserSession::getInstance();
    }


    public function renderTemplate( $template, $data = null )
    {
      $data[ 'logged_in_user' ] = $this->session->getLoggedInUser();

      include $template;
    }
  }
