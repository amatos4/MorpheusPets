<?php
  require_once 'viewmodels/ViewModel.php';
  require_once 'data/data.php';
  require_once 'data/Pet.php';
  require_once 'utils/string.php';
  require_once 'utils/http.php';
  require_once 'utils/Pet.php';

  class PetEditor_ViewModel extends ViewModel
  {
    /**
     * @var MorpheusPetsData data model
     */
    private $data;

    /**
     * @var User user which is logged in
     */
    private $logged_in_user;

    /**
     * @var Pet pet that will be edited
     */
    private $pet_to_edit;

    /**
     * @var array all the species that a user can select
     */
    private $species_list = [ ];

    /**
     * PetEditor_ViewModel constructor.
     *
     * @param User $user current logged in user
     */
    public function __construct( $user )
    {
      parent::__construct();
      $this->logged_in_user = $user;
      $this->data           = MorpheusPetsData::getInstance();
    }

    /**
     * @param $pet pet to edit
     */
    public function setPetToEdit( $pet )
    {
      $this->pet_to_edit = $pet;
    }

    /**
     * @param Species $species species that user can select
     */
    public function addSelectableSpecies( $species )
    {
      if ( isset( $species ) )
      {
        array_push( $this->species_list, $species );
      }
    }

    /*
     * Render the Create Pet page
     */
    public function renderCreatePet()
    {
      $view_data[ 'page_title' ]         = 'Pet Creator';
      $view_data[ 'header_title' ]       = 'Pet Creator';
      $view_data[ 'header_description' ] = 'Create a New Pet';
      $view_data[ 'submit_button_text' ] = 'Create Pet';
      $view_data[ 'js' ]                 = '<script src="js/pet_editor.js"></script><script src="js/create_pet.js"></script>';

      $view_data = $this->editPet( $view_data, true );

      $this->renderTemplate( 'templates/header.php', $view_data );
      $this->renderTemplate( 'templates/pet_editor_view.php', $view_data );
      $this->renderTemplate( 'templates/footer.php', $view_data );
    }

    /**
     * Render the Edit Pet page
     */
    public function renderEditPet()
    {
      $view_data[ 'page_title' ]         = 'Pet Editor';
      $view_data[ 'header_title' ]       = 'Pet Editor';
      $view_data[ 'header_description' ] = 'Edit your Pet';
      $view_data[ 'submit_button_text' ] = 'Save Changes';
      $view_data[ 'js' ]                 = '<script src="js/pet_editor.js"></script>';

      $view_data = $this->editPet( $view_data );

      $this->renderTemplate( 'templates/header.php', $view_data );
      $this->renderTemplate( 'templates/pet_editor_view.php', $view_data );
      $this->renderTemplate( 'templates/footer.php', $view_data );
    }

    /**
     * Create/Edit a pet
     *
     * @param      $view_data
     * @param bool $create whether a pet is being created or edited
     *
     * @return mixed
     */
    private function editPet( $view_data, $create = false )
    {
      // POST keys
      $submit_key     = 'submit';
      $name_key       = 'name';
      $species_id_key = 'species_id';
      $pet_id_key     = 'pet_id';

      $errors_found = false;

      // Gather form inputs
      $form_name       = isset( $_POST[ $name_key ] ) ? $_POST[ $name_key ] : null;
      $form_species_id = isset( $_POST[ $species_id_key ] ) ? $_POST[ $species_id_key ] : null;

      // Sanitized inputs
      $sanitized_name = null;
      $species        = null;

      // View config
      $view_data[ 'species_list' ] = $this->species_list;

      // Pet is being created
      if ( $create )
      {
        $view_data[ $name_key ]       = $form_name;
        $view_data[ $species_id_key ] = $form_species_id;
      }
      // Check if an existing pet is being edited
      else
      {
        // Set the flag that this pet is being edited
        // Species should not be modifiable
        $view_data[ 'edit_mode' ] = true;

        // Check if pet was found
        if ( $this->pet_to_edit === null )
        {
          $view_data[ 'general_err' ] = 'The pet to be edited does not exist.';
        }
        // Check if user can edit the pet
        elseif ( !PetUtils::userCanEditPet( $this->logged_in_user, $this->pet_to_edit ) )
        {
          $view_data[ 'general_err' ] = "You are not allowed to edit this pet.";
        }
        else
        {
          $view_data[ $pet_id_key ]     = $this->pet_to_edit->getId();
          $view_data[ $name_key ]       = isset( $form_name ) ? $form_name : $this->pet_to_edit->getName();
          $view_data[ $species_id_key ] = $this->pet_to_edit->getSpecies()->getId();
        }
      }

      // Check form was submitted without error
      if ( !isset( $view_data[ 'general_err' ] ) && isset( $_POST[ $submit_key ] ) )
      {
        // Check name is set
        if ( empty( $form_name ) || StringUtils::whitespaceOnly( $form_name ) )
        {
          $view_data[ 'err_name' ] = "Please enter a name.";
          $errors_found            = true;
        }
        else
        {
          // Sanitize the name
          $sanitized_name = StringUtils::sanitize( $form_name );

          // Check name meets length requirements
          if ( strlen( $sanitized_name ) > 64 )
          {
            $view_data[ 'err_name' ] = "Please enter a name that is no greater than 64 characters.";
            $errors_found            = true;
          }
        }


        // Check species_id is set
        // Only using in create mode
        if ( $create && empty( $form_species_id ) )
        {
          $view_data[ 'err_species' ] = "Please select a species.";
          $errors_found               = true;
        }
        elseif ( $create )
        {
          // Get the int for species_id
          $sanitized_species_id = intval( $form_species_id );

          $species = $this->data->getSpecies( $sanitized_species_id );

          if ( $species === null )
          {
            $view_data[ 'err_species' ] = "Could not find species. Please try again.";
            $errors_found               = true;
          }

        }

        if ( $errors_found )
        {
          $view_data[ 'form_err' ] = "Please see errors below.";
        }
        // Form was submitted without errors
        else
        {

          // Check if a pet is being created
          if ( $create )
          {
            $new_pet = new Pet( $this->logged_in_user, $species, $sanitized_name );

            // Generate initial stats
            $new_pet->rollStats();

            // Add pet to database
            $new_pet_id = $this->data->addPet( $new_pet );

            // Redirect to view pet if added successfully
            if ( $new_pet_id )
            {
              HTTPUtils::my_http_redirect( 'pet.php?pet_id=' . $new_pet_id );
            }
            else
            {
              $view_data[ 'form_err' ] = 'Failed to add pet. Please try again.';
            }
          }
          // Check if this is an existing pet to be edited
          else
          {
            // Update pet fields
            // Species cannot be modified
            $this->pet_to_edit->setName( $sanitized_name );

            // Update pet in database
            $updated = $this->data->updatePet( $this->pet_to_edit );

            // Redirect to view pet if updated successfully
            if ( $updated )
            {
              HTTPUtils::my_http_redirect( 'pet.php?pet_id=' . $this->pet_to_edit->getId() );
            }
            else
            {
              $view_data[ 'form_err' ] = 'Failed to update pet. Please try again.';
            }
          }

        }
      }

      return $view_data;
    }
  }
