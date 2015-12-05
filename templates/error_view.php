<?php
  $username_not_found = isset( $data[ 'username_not_found' ] ) ? $data[ 'username_not_found' ] : null;
  $user_id_not_found  = isset( $data[ 'user_id_not_found' ] ) ? $data[ 'user_id_not_found' ] : null;
  $pet_id_not_found   = isset( $data[ 'pet_id_not_found' ] ) ? $data[ 'pet_id_not_found' ] : null;

  /** @var Pet $pet_edit_not_allowed */
  $pet_edit_not_allowed = isset( $data[ 'pet_edit_not_allowed' ] ) ? $data[ 'pet_edit_not_allowed' ] : null;
  $active_edit_not_allowed = isset( $data[ 'active_edit_not_allowed' ] ) ? $data[ 'active_edit_not_allowed' ] : null;
?>

<section id="error">
  <?php
    // Username Not Found Error
    if ( $username_not_found !== null )
    {
      echo "<h1>User <b>@" . $username_not_found . "</b> could not be found.</h1>";
    }
  ?>
  <?php
    // User Not Found Error
    if ( $user_id_not_found !== null )
    {
      echo "<h1>User with id <b>" . $user_id_not_found . "</b> could not be found.</h1>";
    }
  ?>
  <?php
    // Pet Not Found Error
    if ( $pet_id_not_found !== null )
    {
      echo "<h1>Pet with id <b>" . $pet_id_not_found . "</b> could not be found.</h1>";
    }
  ?>
  <?php
    // Pet Not Allowed Edit Error
    if ( $pet_edit_not_allowed !== null )
    {
      echo "<h1>Pet with id <b>" . $pet_edit_not_allowed->getId() . "</b> cannot be edited.</h1>";
    }
  ?>
  <?php
    //active_edit_not_allowed
    if ( $active_edit_not_allowed !== null )
    {
      echo "<h1>User with id <b>" . $active_edit_not_allowed . "</b> could not have their active pets edited. Must choose 3 or less pets to be active.</h1>";
    }
  ?>
</section>
