<?php
  // Header stuff
  $header_title       = isset( $data[ 'header_title' ] ) ? $data[ 'header_title' ] : null;
  $header_description = isset( $data[ 'header_description' ] ) ? $data[ 'header_description' ] : null;

  // Model
  /** @var Pet $pet */
  $pet = isset( $data[ 'pet' ] ) ? $data[ 'pet' ] : null;

  // Other Data
  $edit_mode = isset( $data[ 'edit_mode' ] ) ? $data[ 'edit_mode' ] : null;
?>

  <section class="pet-viewer-pet-badge card">
    <h1><?php echo $pet->getName(); ?></h1>
    <img src="<?php echo $pet->getSpecies()->getImageUrl(); ?>">

    <div class="pet-viewer-experience">
      <progress class="experience-bar" value="<?php echo $pet->getExperience(); ?>" max="100"></progress>
      <p><b>Experience: </b><?php echo $pet->getExperience(); ?>/100</p>
    </div>
    <p><b>Species: </b><?php echo $pet->getSpecies()->getSpecies(); ?></p>

    <p><b>Type: </b><?php echo $pet->getSpecies()->getType(); ?></p>
    <?php
      if ( isset( $edit_mode ) )
      {
        // Show Edit button
        ?>
        <form id="pet_viewer_edit" enctype="multipart/form-data" action="pet_editor.php" method="POST">
          <input type="hidden" id="pet_id" name="pet_id" value="<?php echo $pet->getId(); ?>"/>
          <button type="submit" class="btn btn-primary" name="edit_pet">Edit Pet</button>
        </form>
        <?php
      }
    ?>
  </section>

  <section class="pet-viewer-stats-badge card">
    <h2>Stats</h2>
    <ul>
      <li><b>Brawn: </b><?php echo $pet->getBrawn() ?></li>
      <li><b>Guts: </b><?php echo $pet->getGuts() ?></li>
      <li><b>Essence: </b><?php echo $pet->getEssence() ?></li>
      <li><b>Speed: </b><?php echo $pet->getSpeed() ?></li>
      <li><b>Focus: </b><?php echo $pet->getFocus() ?></li>
      <li><b>Grit: </b><?php echo $pet->getGrit() ?></li>
    </ul>
  </section>
<?php

