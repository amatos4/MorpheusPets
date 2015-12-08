<img id="logo" src="images/logo.png"/>
<div class='text'>
  <div class='content'></div>
  <div class='dash'></div>
  <h2><?php echo $header_description; ?></h2>
<?php
  $recent_users = $data[ 'recent_users' ];
  foreach ( $recent_users as $key => $value )
  {
    echo "<section class=\"recent-user card\">";
  }
