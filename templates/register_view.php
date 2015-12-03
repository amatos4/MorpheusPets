<?php
  // Form inputs
  $username      = isset( $data[ 'username' ] ) ? $data[ 'username' ] : null;
  $password      = isset( $data[ 'password' ] ) ? $data[ 'password' ] : null;
  $email_address = isset( $data[ 'email_address' ] ) ? $data[ 'email_address' ] : null;
  $description   = isset( $data[ 'description' ] ) ? $data[ 'description' ] : null;

  // Errors
  $form_error          = isset( $data[ 'form_err' ] ) ? $data[ 'form_err' ] : null;
  $username_error      = isset( $data[ 'err_username' ] ) ? $data[ 'err_username' ] : null;
  $password_error      = isset( $data[ 'err_password' ] ) ? $data[ 'err_password' ] : null;
  $email_address_error = isset( $data[ 'err_email_address' ] ) ? $data[ 'err_email_address' ] : null;
  $description_error   = isset( $data[ 'err_description' ] ) ? $data[ 'err_description' ] : null;
?>

<section class="register-form">
  <h2>Register</h2>

  <form id="register_form" enctype="multipart/form-data" action="register.php" method="POST">
    <small>*Leading and trailing spaces do not count.</small>
    <p class="text-error" id="register_form_error"><?php if ( isset( $form_error ) ) echo $form_error; ?></p>

    <div class="form-group">
      <label for="register_username">Username</label>
      <input type="text" class="form-control" id="register_username" name="username" placeholder="Username"
             value="<?php if ( isset( $username ) ) echo $username; ?>" required maxlength="100">

      <p class="text-error"
         id="register_username_error"><?php if ( isset( $username_error ) ) echo $username_error; ?></p>
    </div>
    <div class="form-group">
      <label for="register_password">Password</label>
      <input type="password" class="form-control" id="register_password" name="password" placeholder="Password"
             value="<?php if ( isset( $password ) ) echo $password; ?>" required>

      <p class="text-error"
         id="register_password_error"><?php if ( isset( $password_error ) ) echo $password_error; ?></p>
    </div>
    <div class="form-group">
      <label for="register_email_address">Email Address</label>
      <input type="email" class="form-control" id="register_email_address" name="email_address"
             placeholder="Email Address"
             value="<?php if ( isset( $email_address ) ) echo $email_address; ?>" required>

      <p class="text-error"
         id="register_email_address_error"><?php if ( isset( $email_address_error ) ) echo $email_address_error; ?></p>
    </div>
    <div class="form-group">
      <label for="register_description">Description</label>
        <textarea class="form-control" rows="5" id="register_description" name="description"
                  required><?php if ( isset( $description ) ) echo $description; ?></textarea>

      <p class="text-error"
         id="register_description_error"><?php if ( isset( $description_error ) ) echo $description_error; ?></p>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Register</button>
  </form>
</section>
