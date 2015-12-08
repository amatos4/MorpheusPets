<?php
// Header stuff
$page_title       = isset( $data[ 'page_title' ] ) ? $data[ 'page_title' ] : null;

// Other Data
$recent_users        = isset( $data[ 'recent_users' ] ) ? $data[ 'recent_users' ] : null;

?>

<img id="logo" src="images/logo.png"/>
<div class='text'>
  <div class='content'></div>
  <div class='dash'></div>
</div>

<section class="news-container">
  <h1>MorpheusPets News</h1>
  <div class="card">
    <h2>Featured Species of the Week</h2>
    <img src="images/species/Pikachoo.png" />
    <p>Our species of the week is <b>Pikachoo</b>. </p>
    <p>Pikachoo is an Air type pet that will battle until the very end. Add this species to your active pets and watch Pikachoo deal tons of damage to your enemies.</p>
  </div>
</section>
<aside class="right-container">
  <h1>Most Recent Sign Ups</h1>
  <?php foreach ( $recent_users as $user_active_pets ) :
      $user = $user_active_pets[ "user" ];
      $active_pets = $user_active_pets[ "active_pets" ];
    ?>
    <div class="card">
      <a href="my_profile.php?profileId=<?php echo $user->getId(); ?>"><?php echo $user->getUsername();?></a>
      <?php /** @var Pet $pet */foreach ( $active_pets as $pet ) : ?>
          <img width=75px height=75px src="<?php echo $pet->getSpecies()->getImageUrl(); ?>" />
      <?php endforeach; ?>
      <?php if ( empty( $active_pets ) ): ?>
          <p>No active pets to display.</p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</aside>

