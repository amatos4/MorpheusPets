<!-- Header -->
<div class="page-header">
  <h1 class="page-title">Register</h1>

  <p class="lead page-description">Register a new user account</p>
</div>

<!-- Blog main -->
<div class="row">
  <div class="col-sm-8 blog-main">
    <form id="register_user_form" enctype="multipart/form-data" action="register.php" method="POST">
      <small class="text-muted">*Leading and trailing spaces do not count.</small>
      <p class="text-danger" id="register_form_error"><?php if ( isset( $data[ 'form_err' ] ) ) echo $data[ 'form_err' ]; ?></p>

      <div class="form-group">
        <label for="register_username">Username</label>
        <input type="text" class="form-control" id="register_username" name="username" placeholder="Username"
               value="<?php if ( isset( $data[ 'username' ] ) ) echo $data[ 'username' ]; ?>" required maxlength="100">

        <p class="text-danger"
           id="register_username_error"><?php if ( isset( $data[ 'err_username' ] ) ) echo $data[ 'err_username' ]; ?></p>
      </div>
      <div class="form-group">
        <label for="register_password">Password</label>
        <input type="password" class="form-control" id="register_password" name="password" placeholder="Password"
               value="<?php if ( isset( $data[ 'password' ] ) ) echo $data[ 'password' ]; ?>" required>

        <p class="text-danger"
           id="register_password_error"><?php if ( isset( $data[ 'err_password' ] ) ) echo $data[ 'err_password' ]; ?></p>
      </div>
      <div class="form-group">
        <label for="register_email_address">Email Address</label>
        <input type="email" class="form-control" id="register_email_address" name="email_address" placeholder="Email address"
               value="<?php if ( isset( $data[ 'email_address' ] ) ) echo $data[ 'email_address' ]; ?>" required>

        <p class="text-danger"
           id="register_email_address_error"><?php if ( isset( $data[ 'err_email_address' ] ) ) echo $data[ 'err_email_address' ]; ?></p>
      </div>
      <div class="form-group">
        <label for="register_description">description</label>
        <textarea class="form-control" rows="10" id="register_description" name="description"
                  required><?php if ( isset( $data[ 'description' ] ) ) echo $data[ 'description' ]; ?></textarea>

        <p class="text-danger"
           id="register_description_error"><?php if ( isset( $data[ 'err_description' ] ) ) echo $data[ 'err_description' ]; ?></p>
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Register</button>
    </form>
  </div>
</div>
