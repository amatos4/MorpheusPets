<!-- Header -->
<div class="page-header">
  <h1 class="page-title">Log In</h1>

  <p class="lead page-description">Log in with your credentials</p>
</div>

<!-- Main -->
<div class="row">
  <div class="col-sm-8 main">
    <form id="login_form" enctype="multipart/form-data" action="login.php" method="POST">
      <small class="text-muted">*Leading and trailing spaces do not count.</small>
      <p class="text-danger" id="login_form_error"><?php if ( isset( $data[ 'form_err' ] ) ) echo $data[ 'form_err' ]; ?></p>

      <div class="form-group">
        <label for="login_username">Username</label>
        <input type="text" class="form-control" id="login_username" name="username" placeholder="Username"
               value="<?php if ( isset( $data[ 'username' ] ) ) echo $data[ 'username' ]; ?>" required>

        <p class="text-danger"
           id="login_username_error"><?php if ( isset( $data[ 'err_username' ] ) ) echo $data[ 'err_username' ]; ?></p>
      </div>
      <div class="form-group">
        <label for="login_password">Password</label>
        <input type="password" class="form-control" id="login_password" name="password" placeholder="Password"
               value="<?php if ( isset( $data[ 'password' ] ) ) echo $data[ 'password' ]; ?>" required>

        <p class="text-danger"
           id="login_password_error"><?php if ( isset( $data[ 'err_password' ] ) ) echo $data[ 'err_password' ]; ?></p>
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Log In</button>
    </form>
  </div>
</div>
