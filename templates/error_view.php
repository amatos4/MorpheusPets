<?php
  $error_username     = isset( $data[ 'not_found_username' ] ) ? $data[ 'not_found_username' ] : null;
  $userIdNotFound = isset( $data[ 'userIdNotFound' ] ) ? $data[ 'userIdNotFound' ] : null;
?>

<section id="error">
    <?php if(!is_null($error_username)) {
        echo "<h1>User <b>@" . $error_username . "</b> could not be found.</h1>";
    }
    ?>
    <?php if(!is_null($userIdNotFound)) {
        echo "<h1>User with id <b>" . $userIdNotFound . "</b> could not be found.</h1>";
    }
    ?>
</section>
