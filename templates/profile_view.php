<?php
// Header stuff
$page_title       = isset( $data[ 'page_title' ] ) ? $data[ 'page_title' ] : null;

// Other Data
$active_list = isset( $data[ 'active_pets' ] ) ? $data[ 'active_pets' ] : null;
$non_active_list = isset( $data[ 'nonactive_pets'] ) ? $data[ 'nonactive_pets' ] : null;
$can_edit_bool = isset( $data[ 'can_edit_profile' ] ) ? $data[ 'can_edit_profile' ] : null;
/** @var User $profile_user */
$profile_user = isset( $data[ 'profile_user' ] ) ? $data[ 'profile_user' ] : null;

?>

<?php if ($can_edit_bool) : ?>
<div class="btn"><a href="">Start Battle!</a></div>
<?php endif; ?>

<section class="profile-badge">
    <img src="images/avatar_blank.png"/>
    <article class="description">
        <h1><?php echo $profile_user->getUsername() ?></h1>
        <p><?php echo $profile_user->getDescription() ?></p>
    </article>
</section>

<section class="pet-container">
    <h1>My Pet Collection</h1>
    <ul>
        <li class="pet-badge">
            <a href="#"><img src="images/shoyru.jpg" /></a>
            <div class="pet-stats" />
            <h1>Blu</h1>
            <p><b>Species: </b>Shoyru</p>
            <p><b>Type: </b> Fire</p>
            <p><b>Active: </b>Yes</p>
            </div>
        </li>
        <li class="pet-badge">
            <a href="#"><img src="images/eyrie.jpg" /></a>
            <div class="pet-stats" />
            <h1>Galvitron</h1>
            <p><b>Species: </b>Eyrie</p>
            <p><b>Type: </b>Flying</p>
            <p><b>Active: </b>Yes</p>
            </div>
        </li>
        <li class="pet-badge">
            <a href="#"><img src="images/kau.jpg" /></a>
            <div class="pet-stats" />
            <h1>Bessie</h1>
            <p><b>Species: </b>Kau</p>
            <p><b>Type: </b>Grass</p>
            <p><b>Active: </b>Yes</p>
            </div>
        </li>
        <li class="pet-badge">
            <a href="#"><img src="images/kacheek.png" /></a>
            <div class="pet-stats" />
            <h1>Bun</h1>
            <p><b>Species: </b>Kacheek</p>
            <p><b>Type: </b>Ground</p>
            <p><b>Active: </b>No</p>
            </div>
        </li>
        <li class="pet-badge">
            <a href="#"><img src="images/jubjub.jpg" /></a>
            <div class="pet-stats" />
            <h1>Fluff</h1>
            <p><b>Species: </b>JubJub</p>
            <p><b>Type: </b>Poison</p>
            <p><b>Active: </b>No</p>
            </div>
        </li>
        <li class="pet-badge">
            <a href="#"><img src="images/krawk.jpg" /></a>
            <div class="pet-stats" />
            <h1>Croc</h1>
            <p><b>Species: </b>Krawk</p>
            <p><b>Type: </b>Water</p>
            <p><b>Active: </b>No</p>
            </div>
        </li>
    </ul>
</section>
