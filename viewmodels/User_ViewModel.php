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
      $submit_key   = 'submit';
      $username_key = 'username';
      $password_key = 'password';

      // Form inputs
      $form_username = empty( $_POST[ $username_key ] ) ? null : StringUtils::sanitize( $_POST[ $username_key ] );
      $form_password = empty( $_POST[ $password_key ] ) ? null : StringUtils::sanitize( $_POST[ $password_key ] );
      $form_submit   = isset( $_POST[ $submit_key ] );

      $errors_found = false;

      // View Config
      $view_data[ 'page_title' ] = 'Log In';
      $view_data[ 'js' ]         = '<script src="js/login.js"></script>';

      // Fill in view data
      if ( $form_username !== null )
      {
        $view_data[ 'username' ] = $form_username;
      }
      if ( $form_password !== null )
      {
        $view_data[ 'password' ] = $form_password;
      }

      // Check form was submitted
      if ( $form_submit )
      {
        // Check user name is set
        if ( $form_username === null || StringUtils::whitespaceOnly( $form_username ) )
        {
          $view_data[ 'err_username' ] = "Please enter a user name.";
          $errors_found                = true;
        }
        // Check password is set
        if ( $form_password === null || StringUtils::whitespaceOnly( $form_password ) )
        {
          $view_data[ 'err_password' ] = "Please enter a password.";
          $errors_found                = true;
        }

        if ( $errors_found )
        {
          $view_data[ 'form_err' ] = "Please see errors below.";
        }
        // Form was submitted without errors
        else
        {
          // Validate password
          $user = $this->data->getUserByUserName( $form_username );

          // User not found
          if ( $user === null )
          {
            $view_data[ 'form_err' ] = "User and password combination do not exist. Please try again.";
          }
          else
          {
            // Login if password matches
            if ( $user->verifyPassword( $form_password ) )
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
      $submit_key        = 'submit';
      $username_key      = 'username';
      $password_key      = 'password';
      $email_address_key = 'email_address';
      $description_key   = 'description';

      // Form inputs
      $form_username      = empty( $_POST[ $username_key ] ) ? null : StringUtils::sanitize( $_POST[ $username_key ] );
      $form_password      = empty( $_POST[ $password_key ] ) ? null : StringUtils::sanitize( $_POST[ $password_key ] );
      $form_email_address = empty( $_POST[ $email_address_key ] ) ? null : StringUtils::sanitize( $_POST[ $email_address_key ] );
      $form_description   = empty( $_POST[ $description_key ] ) ? null : StringUtils::sanitize( $_POST[ $description_key ] );
      $form_submit        = isset( $_POST[ $submit_key ] );

      $errors_found = false;

      // View Config
      $view_data[ 'page_title' ] = 'Register';
      $view_data[ 'js' ]         = '<script src="js/register.js"></script>';

      // Fill in view data
      if ( $form_username !== null )
      {
        $view_data[ 'username' ] = $form_username;
      }
      if ( $form_password !== null )
      {
        $view_data[ 'password' ] = $form_password;
      }
      if ( $form_email_address !== null )
      {
        $view_data[ 'email_address' ] = $form_email_address;
      }
      if ( $form_description !== null )
      {
        $view_data[ 'description' ] = $form_description;
      }

      // Check form was submitted
      if ( $form_submit )
      {
        // Check user name is set
        if ( $form_username === null || StringUtils::whitespaceOnly( $form_username ) )
        {
          $view_data[ 'err_username' ] = "Please enter a user name.";
          $errors_found                = true;
        }
        elseif ( strlen( $form_username ) > 100 )
        {
          $view_data[ 'err_username' ] = "Please enter a user name that is no greater than 100 characters.";
          $errors_found                = true;
        }

        // Check password is set
        if ( $form_password === null || StringUtils::whitespaceOnly( $form_password ) )
        {
          $view_data[ 'err_password' ] = "Please enter a password.";
          $errors_found                = true;
        }

        // Check email address is set
        if ( $form_email_address === null || StringUtils::whitespaceOnly( $form_email_address ) )
        {
          $view_data[ 'err_email_address' ] = "Please enter an email address.";
          $errors_found                     = true;
        }
        // Check email address is valid
        elseif ( !filter_var( $form_email_address, FILTER_VALIDATE_EMAIL ) )
        {
          $view_data[ 'err_email_address' ] = "Please enter a valid email address.";
          $errors_found                     = true;
        }

        // Check description is set
        if ( $form_description === null || StringUtils::whitespaceOnly( $form_description ) )
        {
          $view_data[ 'err_description' ] = "Please enter a brief description.";
          $errors_found                   = true;
        }

        // Form was submitted without errors
        if ( !$errors_found )
        {
          // Check if user with given username already exists
          if ( $this->data->getUserByUserName( $form_username ) !== null )
          {
            $view_data[ 'err_username' ] = "User with this username already exists. Please enter another one.";
            $errors_found                = true;
          }
          else
          {
            // Add user to database
            $new_user = new User( $form_username, $form_email_address, $form_description );
            $new_user->setPassword( $form_password );

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

        if ( $errors_found )
        {
          $view_data[ 'form_err' ] = "Please see errors below.";
        }
      }

      $this->renderTemplate( 'templates/header.php', $view_data );
      $this->renderTemplate( 'templates/register_view.php', $view_data );
      $this->renderTemplate( 'templates/footer.php', $view_data );
    }
  }
