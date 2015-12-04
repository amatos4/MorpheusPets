<?php
  // Form inputs
  $username = isset( $data[ 'username' ] ) ? $data[ 'username' ] : null;
  $password = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;

  // Errors
  $form_error     = isset( $data[ 'form_err' ] ) ? $data[ 'form_err' ] : null;
  $username_error = isset( $data[ 'err_username' ] ) ? $data[ 'err_username' ] : null;
  $password_error = isset( $data[ 'err_password' ] ) ? $data[ 'err_password' ] : null;
?>

<section class="login-form card">
  <h2>Login</h2>

  <form id="login_form" enctype="multipart/form-data" action="login.php" method="POST">
    <small>*Leading and trailing spaces do not count.</small>
    <p class="text-error"
       id="login_form_error"><?php if ( isset( $form_error ) ) echo $form_error; ?></p>

    <div class="form-group">
      <label for="login_username">Username</label>
      <input type="text" class="form-control" id="login_username" name="username" placeholder="Username"
             value="<?php if ( isset( $username ) ) echo $username; ?>" required>

      <p class="text-error"
         id="login_username_error"><?php if ( isset( $username_error ) ) echo $username_error; ?></p>
    </div>
    <div class="form-group">
      <label for="login_password">Password</label>
      <input type="password" class="form-control" id="login_password" name="password" placeholder="Password"
             value="<?php if ( isset( $password ) ) echo $password; ?>" required>

      <p class="text-error"
         id="login_password_error"><?php if ( isset( $password_error ) ) echo $password_error; ?></p>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Log In</button>
  </form>
</section>
