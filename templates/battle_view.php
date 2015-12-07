<?php
	require_once 'utils/battle_logic.php';
	if(isset($_SESSION['battle'])){
		$battle = $_SESSION['battle'];
	}
	else {
		$_SESSION['battle'] = new Battle();
		$battle = $_SESSION['battle'];
	}

	$alert = "Make your move!";

	// Header stuff
	$page_title       = isset( $data[ 'page_title' ] ) ? $data[ 'page_title' ] : null;

	$logged_in_user = isset( $data[ 'logged_in_user' ] ) ? $data[ 'logged_in_user' ] : null;
	$enemyId = -1;
	if(isset($_GET['enemyId'])) {
		$enemyId = $_GET['enemyId'];
	}

	//Remember at end of battle to reset battle session variables
	//echo $logged_in_user->getId() . " " . $enemyId;
	$valid = $battle->Setup($logged_in_user->getId(), $enemyId);

	if($valid != -1) {
		$user_team = $battle->getUser();
		$enemy_team = $battle->getEnemy();

		$activeUser = $battle->getActivePet();
		$activeEnemy = $battle->getEnemyPet();

		$enemy_Pet = $enemy_team[$activeEnemy];
		$user_Pet =  $user_team[$activeUser];

		$user = $user_team[$activeUser]->getOwner();
		$enemy = $enemy_team[$activeEnemy]->getOwner();
	}
?>

<?php
	if($valid != -1) {
		$user_health = $battle->getUserHealth();
		if(isset($_SESSION['conclusion'])) {
			$conclusion = $_SESSION['conclusion'];
			$alert = $conclusion[1];
		}
		else if(isset($_GET['attack'])) {
			if($user_health[0] <= 0) {
				$alert = "Your pet has been knocked out! You must switch your pet!";
			}
			else {
				$alert = $battle->attack();
				$activeEnemy = $battle->getEnemyPet();
				$enemy_Pet = $enemy_team[$activeEnemy];
			}
		}
		else if(isset($_GET['magic'])) {
			if($user_health[0] <= 0) {
				$alert = "Your pet has been knocked out! You must switch your pet!";
			}
			else {
				$alert = $battle->magic();
				$activeEnemy = $battle->getEnemyPet();
				$enemy_Pet = $enemy_team[$activeEnemy];
			}
		}
		else if(isset($_GET['defend'])) {
			if($user_health[0] <= 0) {
				$alert = "Your pet has been knocked out! You must switch your pet!";
			}
			else {
				$alert = $battle->defend();
				$activeEnemy = $battle->getEnemyPet();
				$enemy_Pet = $enemy_team[$activeEnemy];
			}
		}
		else if(isset($_GET['switch'])) {
			if($battle->getPetHealth($_GET['switch'])[0] > 0) {
				if($_GET['switch'] != $activeUser) {
					$alert = $battle->switchPet(0, $_GET['switch']);
					$activeUser = $battle->getActivePet();
					$user_Pet =  $user_team[$activeUser];
					$activeEnemy = $battle->getEnemyPet();
					$enemy_Pet = $enemy_team[$activeEnemy];
				}
				else {
					$alert = "You can't switch to a pet that's already in battle!";
				}
			}
			else {
				$alert = "You cannot switch into a knocked out pet!";
			}
		}
		$user_health = $battle->getUserHealth();
		$enemy_health = $battle->getEnemyHealth();

		if(!isset($_SESSION['conclusion'])) {
			$conclusion = $battle->checkConclusion();
			if($conclusion[0] == true) {
				$alert .= $conclusion[1];
				$_SESSION['conclusion'] = $conclusion;
			}
		}
	}
?>
<?php if ($valid != -1) :?>

	<section class="enemy-info">
		<h1>Enemy Team</h1>
		<ul class="enemy_team">
			<li class="enemy_petimg"><img src= <?php echo "images/species/". $enemy_team[0]->getSpecies()->getSpecies() . ".png"; ?> width="50" height="50" alt="<?php echo $enemy_team[0]->getSpecies()->getSpecies(); ?>" /><?php echo $enemy_team[0]->getName(); ?></li>
			<li class="enemy_petimg"><img src=<?php echo "images/species/". $enemy_team[1]->getSpecies()->getSpecies() . ".png"; ?> width="50" height="50" alt="<?php echo $enemy_team[1]->getSpecies()->getSpecies(); ?>" /><?php echo $enemy_team[1]->getName(); ?></li>
			<li class="enemy_petimg"><img src=<?php echo "images/species/". $enemy_team[2]->getSpecies()->getSpecies() . ".png"; ?> width="50" height="50" alt="<?php echo $enemy_team[2]->getSpecies()->getSpecies(); ?>" /><?php echo $enemy_team[2]->getName(); ?></li>
		</ul>
		<ul class="enemy_stat">
			<li><h2>Enemy Battler: <?php echo $enemy->getUsername();?></h2></li>
			<li><h2>Enemy Pet: <?php echo $enemy_Pet->getName(); ?></h2></li>
			<li><h2>Enemy Level: <?php echo floor(($enemy_Pet->getExperience()/100)+1); ?></h2></li>
			<li class="enemy_petimg"><h2>Enemy Health:</h2> <?php echo $enemy_health[0] . "/" . $enemy_health[1]; ?></li>
		</ul>
	</section>

	<section class="battlefield">
		<img src=<?php echo "images/species/". $user_Pet->getSpecies()->getSpecies() . ".png"; ?> width="350" height="350" alt="<?php echo $user_Pet->getSpecies()->getSpecies(); ?>" style="position: absolute; top: 70px; left: 300px;" />
		<img src=<?php echo "images/species/". $enemy_Pet->getSpecies()->getSpecies() . ".png"; ?> width="350" height="350" alt="<?php echo $enemy_Pet->getSpecies()->getSpecies(); ?>" style="position: relative; top: 70px; left: 200px;" />
		<img src="images/field.png" alt="field" style="position: relative; top: 0; left: 0; z-index: -1;" />
	</section>

	<p id="game_alert" class="game_alert"><?php echo $alert; ?></p>
	<p id="hidden"></p>

	<section class="player_stats">
		<ul>
			<li><h2>Pet: <?php echo $user_Pet->getName(); ?></h2></li>
			<li><h2>Level: <?php echo floor(($user_Pet->getExperience()/100)+1); ?></h2></li>
			<li><h2>Health:</h2> <?php echo $user_health[0] . "/" . $user_health[1]; ?></li>
		</ul>
	</section>

	<section class="player_actions" <?php if($conclusion[0] == true) {  echo "style = 'visibility: hidden;'"; } ?>>
		<table>
			<tr>
				<td><div class="btn"><a href="battle.php?attack=true" >Attack</a></div></td>
				<td><div class="btn" ><a href="battle.php?magic=true" >Magic Attack</a></div></td>
				<td><div class="btn" ><a href="battle.php?defend=true" >Defend</a></div></td>
			</tr>
			<tr>
				<td><h2>Switch Pet:</h2></td>
				<td><a href="battle.php?switch=0"><img src=<?php echo "images/species/". $user_team[0]->getSpecies()->getSpecies() . ".png"; ?> height="50" width="50" alt="<?php echo $user_team[0]->getSpecies()->getSpecies(); ?>" /></td>
				<td><a href="battle.php?switch=1"><img src=<?php echo "images/species/". $user_team[1]->getSpecies()->getSpecies() . ".png"; ?> height="50" width="50" alt="<?php echo $user_team[1]->getSpecies()->getSpecies(); ?>" /></td>
				<td><a href="battle.php?switch=2"><img src=<?php echo "images/species/". $user_team[2]->getSpecies()->getSpecies() . ".png"; ?> height="50" width="50" alt="<?php echo $user_team[2]->getSpecies()->getSpecies(); ?>" /></td>
			</tr>
		</table>
	</section>
<?php else : ?>
	<p id='game_alert' class='game_alert'> Not enough active pets for a battle to occur. Please go back to the home page and add more pets to your active team.</p>
<?php endif; ?>
