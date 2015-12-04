<?php
  require_once 'viewmodels/ViewModel.php';
  require_once 'utils/Pet.php';

  class PetViewer_ViewModel extends ViewModel
  {
    /**
     * Pet to show
     * @var Pet
     */
    private $pet;

    /**
     * @var User user which is logged in
     */
    private $logged_in_user;

    /**
     * PetViewer_ViewModel constructor.
     *
     * @param Pet $pet
     */
    public function __construct( $pet )
    {
      parent::__construct();
      $this->pet = $pet;
    }

    /**
     * Set the logged in user for checking if pet is editable
     *
     * @param User $user
     */
    public function setLoggedInUser( $user )
    {
      $this->logged_in_user = $user;
    }

    /**
     * Render the Pet page
     */
    public function renderPet()
    {
      $view_data[ 'page_title' ] = $this->pet->getName();
      $view_data[ 'pet' ]        = $this->pet;

      // Check if pet can be edited
      if ( isset( $this->logged_in_user ) && PetUtils::userCanEditPet( $this->logged_in_user, $this->pet ) )
      {
        $view_data[ 'edit_mode' ] = true;
      }

      $this->renderTemplate( 'templates/header.php', $view_data );
      $this->renderTemplate( 'templates/pet_viewer_view.php', $view_data );
      $this->renderTemplate( 'templates/footer.php', $view_data );
    }
  }
