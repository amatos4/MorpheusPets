<?php

/** @var User $logged_in_user */
$logged_in_user = isset( $data[ 'logged_in_user' ] ) ? $data[ 'logged_in_user' ] : null;

?>
<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="Title">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

	
    <link rel="stylesheet" href="css/battle.css">

    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="css/ie.css"/>
    <![endif]-->

    <script src="js/lib/modernizr.js"></script>

    <title><?php if ( isset( $data[ 'page_title' ] ) ) echo $data[ 'page_title' ] . " - "; ?>MorpheusPets</title>
  </head>
  <body>
      
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if ( !is_null( $logged_in_user )) : ?>
            <li><a href="my_profile.php?profileId=<?php echo $logged_in_user->getId() ?>">My Profile</a></li>
            <li class="logout"><a href="logout.php">Logout</a></li>
            <?php endif; ?>
            <form id="search_form" enctype="multipart/form-data" action="search.php" method="POST">
                <input id="search-bar" name="search" type="text" placeholder="Search..." required>
                <input id="search-button" name="search_submit" type="submit" value="Go">
            </form>
            <?php if ( is_null( $logged_in_user )) : ?>
            <li class="login"><a href="login.php">Login</a></li>
            <li class="register"><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div id="container">
