<?php
  // Header stuff
  $header_title       = isset( $data[ 'header_title' ] ) ? $data[ 'header_title' ] : null;
  $header_description = isset( $data[ 'header_description' ] ) ? $data[ 'header_description' ] : null;

  // Form stuff
  $submit_button_text = isset( $data[ 'submit_button_text' ] ) ? $data[ 'submit_button_text' ] : null;

  // Form inputs
  $name       = isset( $data[ 'name' ] ) ? $data[ 'name' ] : null;
  $species_id = isset( $data[ 'species_id' ] ) ? $data[ 'species_id' ] : null;
  $pet_id     = isset( $data[ 'pet_id' ] ) ? $data[ 'pet_id' ] : null;

  // Other Data
  $species_list = isset( $data[ 'species_list' ] ) ? $data[ 'species_list' ] : null;
  $edit_mode    = isset( $data[ 'edit_mode' ] ) ? $data[ 'edit_mode' ] : null;

  // Errors
  $form_error    = isset( $data[ 'form_err' ] ) ? $data[ 'form_err' ] : null;
  $name_error    = isset( $data[ 'err_name' ] ) ? $data[ 'err_name' ] : null;
  $species_error = isset( $data[ 'err_species' ] ) ? $data[ 'err_species' ] : null;
?>


  <section class="pet-editor-header">
    <h1><?php echo $header_title; ?></h1>
  </section>

  <section class="pet-editor-form card">
    <h2><?php echo $header_description; ?></h2>

    <form id="pet_editor_form" enctype="multipart/form-data" action="pet_editor.php" method="POST">
      <small>*Leading and trailing spaces do not count.</small>
      <p class="text-error"
         id="pet_editor_form_error"><?php if ( isset( $form_error ) ) echo $form_error; ?></p>
      <?php
        // Add hidden pet id if pet is being edited
        if ( isset( $edit_mode ) )
        {
          ?>
          <input type="hidden" id="pet_id" name="pet_id" value="<?php echo $pet_id; ?>"/>
          <?php
        }
      ?>
      <div class="form-group">
        <label for="pet_name">Name</label>
        <input type="text" class="form-control" id="pet_name" name="name" placeholder="Name"
               value="<?php if ( isset( $name ) ) echo $name; ?>" required maxlength="64">

        <p class="text-error"
           id="pet_name_error"><?php if ( isset( $name_error ) ) echo $name_error; ?></p>
      </div>
      <div class="form-group">
        <label for="pet_species">Species</label>
        <select class="form-control" id="pet_species"
                name="species_id" <?php if ( isset( $edit_mode ) ) echo "disabled"; ?>>
          <option value="0">Select a species</option>
          <?php
            // Display species list if available
            if ( isset( $species_list ) )
            {
              /** @var Species $species */
              foreach ( $species_list as $species )
              {
                ?>
                <option
                  value="<?php echo $species->getId(); ?>" <?php if ( isset( $species_id ) && $species_id == $species->getId() ) echo "selected=selected" ?>><?php echo $species->getSpecies(); ?></option>
                <?php
              }
            }
          ?>
        </select>

        <p class="text-error"
           id="pet_species_error"><?php if ( isset( $species_error ) ) echo $species_error; ?></p>
      </div>


      <button type="submit" class="btn btn-primary" name="submit"><?php echo $submit_button_text ?></button>
    </form>
  </section>

  <aside class="pet-editor-species-details-container card">
    <h2>Species Details</h2>

    <div id="pet_species_details">
    </div>
  </aside>
<?php
