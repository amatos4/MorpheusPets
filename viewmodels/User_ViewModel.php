<?php
  require_once 'viewmodels/ViewModel.php';
  require_once 'data/User.php';
  require_once 'utils/string.php';

  class User_ViewModel extends ViewModel
  {
    /**
     * @var MorpheusPetsData data model
     */
    private $data;

    /**
     * User_ViewModel constructor.
     */
    public function __construct()
    {
      parent::__construct();
      $this->data = MorpheusPetsData::getInstance();
    }

    /**
     * View for logging in a user
     */
    public function renderLoginUser()
    {
      // POST keys
      $submit_key    = 'submit';
      $username_key = 'username';
      $password_key  = 'password';

      // Form inputs
      $username = null;
      $password  = null;

      $errors_found = false;

      // View Config
      $view_data[ 'page_title' ] = 'Log In';
      $view_data[ 'js' ]         = '<script src="js/login.js"></script>';

      // Fill in view data
      if ( isset( $_POST[ $username_key ] ) )
      {
        $view_data[ 'username' ] = $_POST[ $username_key ];
      }
      if ( isset( $_POST[ $password_key ] ) )
      {
        $view_data[ 'password' ] = $_POST[ $password_key ];
      }

      // Check form was submitted
      if ( isset( $_POST[ $submit_key ] ) )
      {
        // Check user name is set
        if ( empty( $_POST[ $username_key ] ) || StringUtils::whitespaceOnly( $_POST[ $username_key ] ) )
        {
          $view_data[ 'err_username' ] = "Please enter a user name.";
          $errors_found                 = true;
        }
        else
        {
          // Sanitize the user name
          $username = StringUtils::sanitize( $_POST[ $username_key ] );
        }
        // Check password is set
        if ( empty( $_POST[ $password_key ] ) || StringUtils::whitespaceOnly( $_POST[ $password_key ] ) )
        {
          $view_data[ 'err_password' ] = "Please enter a password.";
          $errors_found                = true;
        }
        else
        {
          // Sanitize the password
          $password = StringUtils::sanitize( $_POST[ $password_key ] );
        }

        if ( $errors_found )
        {
          $view_data[ 'form_err' ] = "Please see errors below.";
        }
        // Form was submitted without errors
        else
        {
          // Validate password
          $user = $this->data->getUserByUserName( $username );

          // User not found
          if ( is_null( $user ) )
          {
            $view_data[ 'form_err' ] = "User and password combination do not exist. Please try again.";
          }
          else
          {
            // Login if password matches
            if ( $user->verifyPassword( $password ) )
            {
              $_SESSION[ 'user_id' ] = $user->getId();
              HTTPUtils::my_http_redirect( 'index.php' );
            }
            else
            {
              $view_data[ 'form_err' ] = "User and password combination do not exist. Please try again.";
            }
          }
        }
      }

      $this->renderTemplate( 'templates/header.php', $view_data );
      $this->renderTemplate( 'templates/login_view.php', $view_data );
      $this->renderTemplate( 'templates/footer.php', $view_data );
    }

    /**
     * View for registering a new user.
     * If a user is successfully registered, they are redirected to the home page.
     */
    public function renderRegisterUser()
    {
      // POST keys
      $submit_key     = 'submit';
      $username_key  = 'username';
      $password_key   = 'password';
      $email_address_key = 'email_address';
      $description_key  = 'description';

      // Form inputs
      $username  = null;
      $password   = null;
      $email_address = null;
      $description  = null;

      $errors_found = false;

      // View Config
      $view_data[ 'page_title' ] = 'Register';
      $view_data[ 'js' ]         = '<script src="js/register.js"></script>';

      // Fill in view data
      if ( isset( $_POST[ $username_key ] ) )
      {
        $view_data[ 'username' ] = $_POST[ $username_key ];
      }
      if ( isset( $_POST[ $password_key ] ) )
      {
        $view_data[ 'password' ] = $_POST[ $password_key ];
      }
      if ( isset( $_POST[ $email_address_key ] ) )
      {
        $view_data[ 'email_address' ] = $_POST[ $email_address_key ];
      }
      if ( isset( $_POST[ $description_key ] ) )
      {
        $view_data[ 'description' ] = $_POST[ $description_key ];
      }

      // Check form was submitted
      if ( isset( $_POST[ $submit_key ] ) )
      {
        // Check user name is set
        if ( empty( $_POST[ $username_key ] ) || StringUtils::whitespaceOnly( $_POST[ $username_key ] ) )
        {
          $view_data[ 'err_username' ] = "Please enter a user name.";
          $errors_found                 = true;
        }
        else
        {
          // Sanitize the user name
          $username = StringUtils::sanitize( $_POST[ $username_key ] );

          // Check user name meets length requirements
          if ( strlen( $username ) > 100 )
          {
            $view_data[ 'err_username' ] = "Please enter a user name that is no greater than 100 characters.";
            $errors_found                 = true;
          }
        }

        // Check password is set
        if ( empty( $_POST[ $password_key ] ) || StringUtils::whitespaceOnly( $_POST[ $password_key ] ) )
        {
          $view_data[ 'err_password' ] = "Please enter a password.";
          $errors_found                = true;
        }
        else
        {
          $password = StringUtils::sanitize( $_POST[ $password_key ] );
        }

        // Check email address is set
        if ( empty( $_POST[ $email_address_key ] ) || StringUtils::whitespaceOnly( $_POST[ $email_address_key ] ) )
        {
          $view_data[ 'err_email_address' ] = "Please enter an email address.";
          $errors_found                  = true;
        }
        else
        {
          // Sanitize the email address
          $email_address = StringUtils::sanitize( $_POST[ $email_address_key ] );

          // TODO: Check email address follows the right pattern
        }

        // Check description is set
        if ( empty( $_POST[ $description_key ] ) || StringUtils::whitespaceOnly( $_POST[ $description_key ] ) )
        {
          $view_data[ 'err_description' ] = "Please enter a brief description.";
          $errors_found                 = true;
        }
        else
        {
          // Sanitize the description
          $description = StringUtils::sanitize( $_POST[ $description_key ] );
        }

        if ( $errors_found )
        {
          $view_data[ 'form_err' ] = "Please see errors below.";
        }
        // Form was submitted without errors
        else
        {
          // Check if user with given username already exists
          if ( !is_null( $this->data->getUserByUserName( $username ) ) )
          {
            $view_data[ 'err_username' ] = "User with this username already exists. Please enter another one.";
          }
          else
          {
            // Add user to database
            $new_user = new User( $username, $email_address, $description );
            $new_user->setPassword( $password );

            $new_user_id = $this->data->addUser( $new_user );

            // Login user if they were successfully added
            if ( $new_user_id )
            {
              $_SESSION[ 'user_id' ] = $new_user_id;
              HTTPUtils::my_http_redirect( 'index.php' );
            }
            else
            {
              $view_data[ 'form_err' ] = "Failed to add new user. Please try again.";
            }
          }
        }
      }

      $this->renderTemplate( 'templates/header.php', $view_data );
      $this->renderTemplate( 'templates/register_view.php', $view_data );
      $this->renderTemplate( 'templates/footer.php', $view_data );
    }
  }
