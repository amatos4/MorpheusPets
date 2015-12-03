<?php
// Header stuff
$page_title       = isset( $data[ 'page_title' ] ) ? $data[ 'page_title' ] : null;

// Other Data
$active_list = isset( $data[ 'active_pets' ] ) ? $data[ 'active_pets' ] : null;
$non_active_list = isset( $data[ 'nonactive_pets'] ) ? $data[ 'nonactive_pets' ] : null;
$can_edit_bool = isset( $data[ 'can_edit_profile' ] ) ? $data[ 'can_edit_profile' ] : null;
/** @var User $profile_user */
$profile_user = isset( $data[ 'profile_user' ] ) ? $data[ 'profile_user' ] : null;
$logged_in_user = isset( $data[ 'logged_in_user' ] ) ? $data[ 'logged_in_user' ] : null;

?>

<?php if (!$can_edit_bool && !empty($active_list) && !is_null($logged_in_user)) : ?>
<div class="btn"><a href="">Start Battle!</a></div>
<?php endif; ?>

<section class="profile-badge">
    <img src="images/avatar_blank.png"/>
    <article class="description">
        <h1><?php echo $profile_user->getUsername() ?></h1>
        <?php if ($can_edit_bool) : ?>
        <div class="small-btn"><a href="">Edit description</a></div>
        <?php endif; ?>
        <p id="user-description"><?php echo $profile_user->getDescription() ?></p>
    </article>
</section>

<section class="pet-container">
    <h1>My Pet Collection</h1>
    <ul>
        <?php if(!empty($active_list)) : ?>
            <?php /** @var Pet $active_pet */foreach ( $active_list as $active_pet ) : ?>
                <li class="pet-badge-active">
                    <a href="#"><img src="images/shoyru.jpg" /></a>
                    <div class="pet-stats" />
                        <h1><?php echo $active_pet->getName()?></h1>
                        <p><b>Species: </b><?php echo $active_pet->getSpecies()->getSpecies()?></p>
                        <p><b>Type: </b> <?php echo $active_pet->getSpecies()->getType()?></p>
                        <p><?php
                            $status = $active_pet->isActive();
                            if($status) {
                                echo "<b>Active</b>";
                            }
                        ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($non_active_list)) : ?>
            <?php /** @var Pet $non_active_pet */foreach ( $non_active_list as $non_active_pet ) : ?>
                <li class="pet-badge">
                    <a href="#"><img src="images/shoyru.jpg" /></a>
                    <div class="pet-stats" />
                        <h1><?php echo $non_active_pet->getName()?></h1>
                        <p><b>Species: </b><?php echo $non_active_pet->getSpecies()->getSpecies()?></p>
                        <p><b>Type: </b> <?php echo $non_active_pet->getSpecies()->getType()?></p>
                        <p><?php
                            $status = $non_active_pet->isActive();
                            if($status) {
                                echo "<b>Active</b>";
                            }?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(empty($active_list)) : ?>
        <p>There are no pets associated with this user.</p>
        <?php endif; ?>
    </ul>
</section>
