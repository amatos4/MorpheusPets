<?php
  require_once 'data/data.php';

  class UserSession
  {
    private $user_logged_in = false;

    private $logged_in_user = null;

    private $data;

    private static $instance;

    /**
     * UserSession constructor.
     * Starts a PHP session
     */
    private function __construct()
    {
      $this->data = MorpheusPetsData::getInstance();
      $this->startSession();
    }

    /**
     * @return UserSession The single shared instance
     */
    public static function getInstance()
    {
      if ( !self::$instance )
      {
        self::$instance = new self();
      }

      return self::$instance;
    }

    /**
     * Empty clone method to prevent connection duplication
     */
    private function __clone()
    {

    }

    /**
     * Start a user session
     */
    public function startSession()
    {
      if ( session_status() !== PHP_SESSION_ACTIVE )
      {
        // Start the PHP Session
        session_start();

        // Set the user id of the logged in user
        $logged_in_user_id    = isset( $_SESSION[ 'user_id' ] ) ? $_SESSION[ 'user_id' ] : null;
        $this->user_logged_in = !is_null( $logged_in_user_id );

        // Get user information if logged in
        $this->logged_in_user = is_null( $logged_in_user_id ) ? null : $this->data->getUser( $logged_in_user_id );
      }
    }

    /**
     * Destroy a user session
     */
    public function destroySession()
    {
      if ( session_status() === PHP_SESSION_ACTIVE )
      {
        // Delete the session cookie as well if it exists (default behavior)
        if ( ini_get( "session.use_cookies" ) )
        {
          $params = session_get_cookie_params();
          setcookie( session_name(), '', time() - 42000,
            $params[ "path" ], $params[ "domain" ],
            $params[ "secure" ], $params[ "httponly" ]
          );
        }

        // Destroy the PHP Session
        session_destroy();
      }
    }

    /**
     * @return User|null The logged in user or null if not logged in.
     */
    public function getLoggedInUser()
    {
      return $this->logged_in_user;
    }

    /**
     * @return bool Whether a user is logged in
     */
    public function isUserLoggedIn()
    {
      return $this->user_logged_in;
    }
  }
