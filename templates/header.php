<?php

  /** @var User $logged_in_user */
  $logged_in_user = isset( $data[ 'logged_in_user' ] ) ? $data[ 'logged_in_user' ] : null;

  /** @var Battle $battle */
  $battle = isset( $data[ 'battle' ] ) ? $data[ 'battle' ] : null;

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en"><![endif]-->
<!--[if IE 9]>
<html class="ie ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"><!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="Title">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <link rel="stylesheet" href="css/base.css">

    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="css/ie.css"/>
    <![endif]-->

    <title><?php if ( isset( $data[ 'page_title' ] ) ) echo $data[ 'page_title' ] . " - "; ?>MorpheusPets</title>
  </head>
  <body>

    <nav>
      <ul class="navbar-left">
        <li class><a href="index.php">Home</a></li>

        <?php if ( $logged_in_user !== null ) : ?>
          <li><a href="my_profile.php?profileId=<?php echo $logged_in_user->getId() ?>">My Profile</a></li>
          <li><a href="pet_editor.php">Create Pet</a></li>

          <?php if ( $battle !== null ) : ?>
            <li><a href="battle.php">Return to Battle!</a></li>
          <?php endif; ?>

        <?php endif; ?>
      </ul>

      <div class="navbar-right">
        <form class="navbar-form" id="search_form" enctype="multipart/form-data" action="search.php"
              method="GET">
          <div class="form-group">
            <input class="form-control" id="search-bar" name="search" type="text" placeholder="Search User..." required>
            <input class="btn" id="search-button" name="search_submit" type="submit" value="Go">
          </div>

        </form>

        <ul>
          <?php if ( $logged_in_user === null ) : ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
          <?php else: ?>
            <li><a href="logout.php">Logout</a></li>
          <?php endif; ?>
        </ul>
      </div>


    </nav>

    <div id="container">
