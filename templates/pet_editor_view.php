<?php
  // Header stuff
  $header_title       = isset( $data[ 'header_title' ] ) ? $data[ 'header_title' ] : null;
  $header_description = isset( $data[ 'header_description' ] ) ? $data[ 'header_description' ] : null;

  // Form inputs
  $name       = isset( $data[ 'name' ] ) ? $data[ 'name' ] : null;
  $species_id = isset( $data[ 'species_id' ] ) ? $data[ 'species_id' ] : null;

  // Other Data
  $species_list = isset( $data[ 'species_list' ] ) ? $data[ 'species_list' ] : null;

  // Errors
  $general_error = isset( $data[ 'general_err' ] ) ? $data[ 'general_err' ] : null;
  $form_error    = isset( $data[ 'form_err' ] ) ? $data[ 'form_err' ] : null;
  $name_error    = isset( $data[ 'err_name' ] ) ? $data[ 'err_name' ] : null;
  $species_error = isset( $data[ 'err_species' ] ) ? $data[ 'err_species' ] : null;
?>


  <section class="pet-editor-header">
    <h1><?php echo $header_title; ?></h1>
  </section>

  <section class="pet-editor-form">
  <h2><?php echo $header_description; ?></h2>
<?php
  // Display general error
  if ( isset( $general_error ) )
  {
    ?>
    <p class="text-error" id="general_error"><?php echo $general_error; ?></p>
    <?php
  }
  else
  {
    ?>
    <form id="pet_editor_form" enctype="multipart/form-data" action="pet_editor.php" method="POST">
      <small>*Leading and trailing spaces do not count.</small>
      <p class="text-error"
         id="pet_editor_form_error"><?php if ( isset( $form_error ) ) echo $form_error; ?></p>

      <div class="form-group">
        <label for="pet_name">Name</label>
        <input type="text" class="form-control" id="pet_name" name="name" placeholder="Name"
               value="<?php if ( isset( $name ) ) echo $name; ?>" required maxlength="64">

        <p class="text-error"
           id="pet_name_error"><?php if ( isset( $name_error ) ) echo $name_error; ?></p>
      </div>
      <div class="form-group">
        <label for="pet_species">Species</label>
        <select class="form-control" id="pet_species" name="species" required>
          <option value="0">Select a species</option>
          <?php
//            // Display species list if available
//            if ( isset( $species_list ) )
//            {
//              /** @var Species $species */
//              foreach ( $species_list as $species )
//              {
//                ?>
<!--                <option-->
<!--                  value="--><?php //echo $species->getId(); ?><!--" --><?php //if ( isset( $species_id ) && $species_id === $species->getId() ) echo "selected=selected" ?><!-->--><?php //echo $species->getSpecies(); ?><!--</option>-->
<!--                --><?php
//              }
//            }
//            else
//            {
//              echo "<option value=\"0\">No species found.</option>";
//            }
          ?>
          <option value="0">Shoyru</option>
          <option value="0">Eyrie</option>
          <option value="0">Kau</option>
          <option value="0">Kacheek</option>
          <option value="0">JubJub</option>
          <option value="0">Krawk</option>
        </select>

        <p class="text-error"
           id="pet_species_error"><?php if ( isset( $species_error ) ) echo $species_error; ?></p>
      </div>


      <button type="submit" class="btn btn-primary" name="submit">Create Pet</button>
    </form>
    </section>

    <aside class="pet-editor-species" id="pet_species_details">
      <h2>Species Details</h2>
      <!--    <p id=pet_species_details_placeholder>Select a species to see more details</p>-->
      <h3>Shoyru</h3>
      <img src="images/shoyru.jpg"/>

      <p><b>Type:</b> Fire</p>

      <article class="pet-stat-priority">
        <h3>Stat Priorities</h3>
        <ol>
          <li>
            <p><b>Essence</b></p>
          </li>
          <li>
            <p><b>Brawn</b></p>
          </li>
          <li>
            <p><b>Focus</b></p>
          </li>
          <li>
            <p><b>Grit</b></p>
          </li>
          <li>
            <p><b>Guts</b></p>
          </li>
          <li>
            <p><b>Speed</b></p>
          </li>
        </ol>
      </article>
    </aside>
    <?php
  }

