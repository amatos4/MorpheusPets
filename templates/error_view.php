<?php
  $username_not_found = isset( $data[ 'username_not_found' ] ) ? $data[ 'username_not_found' ] : null;
  $user_id_not_found  = isset( $data[ 'user_id_not_found' ] ) ? $data[ 'user_id_not_found' ] : null;
  $pet_id_not_found   = isset( $data[ 'pet_id_not_found' ] ) ? $data[ 'pet_id_not_found' ] : null;
?>

<section id="error">
  <?php
    // Username Not Found Error
    if ( !is_null( $username_not_found ) )
  {
    echo "<h1>User <b>@" . $username_not_found . "</b> could not be found.</h1>";
  }
  ?>
  <?php
    // User Not Found Error
    if ( !is_null( $user_id_not_found ) )
  {
    echo "<h1>User with id <b>" . $user_id_not_found . "</b> could not be found.</h1>";
  }
  ?>
  <?php
    // Pet Not Found Error
    if ( !is_null( $pet_id_not_found ) )
    {
      echo "<h1>Pet with id <b>" . $pet_id_not_found . "</b> could not be found.</h1>";
    }
  ?>
</section>
