<?php
// Header stuff
$page_title       = isset( $data[ 'page_title' ] ) ? $data[ 'page_title' ] : null;

// Other Data
$pet_collection = isset($data[ 'pet_collection' ] ) ? $data[ 'pet_collection' ] : null;
$active_list = isset( $data[ 'active_pets' ] ) ? $data[ 'active_pets' ] : null;
$non_active_list = isset( $data[ 'nonactive_pets'] ) ? $data[ 'nonactive_pets' ] : null;
$can_edit_bool = isset( $data[ 'can_edit_profile' ] ) ? $data[ 'can_edit_profile' ] : null;
/** @var User $profile_user */
$profile_user = isset( $data[ 'profile_user' ] ) ? $data[ 'profile_user' ] : null;
$logged_in_user = isset( $data[ 'logged_in_user' ] ) ? $data[ 'logged_in_user' ] : null;

?>

<?php if (!$can_edit_bool && !empty($active_list) && !is_null($logged_in_user) && (count($active_list) != 3) ) : ?>
<div class="btn" xmlns="http://www.w3.org/1999/html"><a href="">Start Battle!</a></div>
<?php endif; ?>

<section class="profile-badge">
    <img src="images/avatar_blank.png"/>
    <article class="description">
        <h1><?php echo $profile_user->getUsername() ?></h1>
        <?php if ($can_edit_bool) : ?>
        <div id="description-btn" class="small-btn"><a href="">Edit description</a></div>
        <form id="description-edit" class="description-edit" enctype="multipart/form-data" action="profile_editor.php" method="POST">
            <textarea id="description-text" name="description-text" type="text"><?php echo $profile_user->getDescription() ?></textarea>
            <input id="profile-user" name="profile-user" type="hidden" type="number" value=<?php echo $profile_user->getId(); ?>/>
            <input type="submit" name="Submit"/>
        </form>
        <?php endif; ?>
        <p id="user-description"><?php echo $profile_user->getDescription() ?></p>
    </article>
</section>

<section class="pet-container">
    <h1>My Pet Collection</h1>
    <div id="active_pet_btn" class="small-btn"><a href="">Change Active Pets</a></div>
    <ul id="pet-collection">
        <?php if(!empty($active_list)) : ?>
            <?php /** @var Pet $active_pet */foreach ( $active_list as $active_pet ) : ?>
                <li class="pet-badge-active card">
                    <a href="pet.php?pet_id=<?php echo $active_pet->getId()?>"><img src="<?php echo $active_pet->getSpecies()->getImageUrl()?>" /></a>
                    <div class="pet-stats" />
                        <h2><?php echo $active_pet->getName()?></h2>
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
                <li class="pet-badge card">
                    <a href="pet.php?pet_id=<?php echo $non_active_pet->getId()?>"><img src="<?php echo $non_active_pet->getSpecies()->getImageUrl()?>" /></a>
                    <div class="pet-stats" />
                        <h2><?php echo $non_active_pet->getName()?></h2>
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
        <?php if(empty($active_list) && empty($non_active_list)) : ?>
        <p>There are no pets associated with this user.</p>
        <?php endif; ?>
    </ul>
</section>

<section class="pet-container">
    <form id="select-active" name="select-active" enctype="multipart/form-data" action="profile_editor.php" method="POST">
        <?php /** @var Pet $pet */foreach ( $pet_collection as $pet ) : ?>
        <input name="active[]" type="checkbox" value=<?php echo $pet->getId() ?> />
        <label for=<?php echo $pet->getId() ?>>
            <div class="pet-badge card">
                <a href="pet.php?pet_id=<?php echo $pet->getId()?>"><img src="<?php echo $pet->getSpecies()->getImageUrl()?>" /></a>
                <div class="pet-stats">
                    <h2><?php echo $pet->getName() ?></h2>
                    <p><b>Species: </b><?php echo $pet->getSpecies()->getSpecies() ?></p>
                    <p><b>Type: </b><?php echo $pet->getSpecies()->getType() ?></p>
                    <table>
                        <tr>
                            <td>Exp.</td>
                            <td>Brawn</td>
                            <td>Guts</td>
                            <td>Essence</td>
                            <td>Speed</td>
                            <td>Focus</td>
                            <td>Grit</td>
                        </tr>
                        <tr>
                            <td><?php echo $pet->getExperience() ?></td>
                            <td><?php echo $pet->getBrawn() ?></td>
                            <td><?php echo $pet->getGuts() ?></td>
                            <td><?php echo $pet->getEssence() ?></td>
                            <td><?php echo $pet->getSpeed() ?></td>
                            <td><?php echo $pet->getFocus() ?></td>
                            <td><?php echo $pet->getGrit() ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </label>
        <?php endforeach; ?>
        <input id="profileId" name="profileId" type="hidden" type="number" value=<?php echo $profile_user->getId() ?>/>
        <input type="submit" name="Submit" />
    </form>
</section>
