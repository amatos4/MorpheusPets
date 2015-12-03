<?php
	require_once 'battle_logic.php';
	session_start();
	if(isset($_SESSION['battle'])){
		$battle = $_SESSION['battle'];
	}
	else {
		$_SESSION['battle'] = new Battle();
		$battle = $_SESSION['battle'];
	}
	
	//Remember at end of battle to reset battle session variables
	
	$battle->Setup();
	$user_team = $battle->getUser();
	$enemy_team = $battle->getEnemy();
	
	#print_r($user_team);
	
	$activeUser = $battle->getActivePet();
	$activeEnemy = $battle->getEnemyPet();
	
	$enemy_Pet = $enemy_team[$activeEnemy];
	$user_Pet =  $user_team[$activeUser];

	$user = $user_team[$activeUser]->getOwner();
	$enemy = $enemy_team[$activeEnemy]->getOwner();
?>
<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="Title">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <link rel="stylesheet" href="battle.css">
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="static/css/ie.css" />
    <![endif]-->

    <script src="static/js/lib/modernizr.js"></script>

    <title>Battle!</title>
</head>

<body>
	<?php
		$alert = "Make your move!";
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
	?>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="#">My Profile</a></li>
            <input id="search-bar" name="search" type="text" placeholder="Search...">
            <input id="search-button" name="search_submit" type="submit" value="Go">
            <li class="logout"><a href="#">Logout</a></li>
        </ul>
    </nav>

    <div id="container">
		
		<section class="enemy-info">
			<h1>Enemy Team</h1>
			<ul class="enemy_team">
				<li class="enemy_petimg"><img src= <?php echo "images/species/". $enemy_team[0]->getSpecies()->getSpecies() . ".png"; ?> width="50" height="50" />Darius</li>
				<li class="enemy_petimg"><img src=<?php echo "images/species/". $enemy_team[1]->getSpecies()->getSpecies() . ".png"; ?> width="50" height="50" />Arcanine</li>
				<li class="enemy_petimg"><img src=<?php echo "images/species/". $enemy_team[2]->getSpecies()->getSpecies() . ".png"; ?> width="50" height="50" />Poliwhirl</li>
			</ul>
			<ul class="enemy_stat">
				<li><h2>Enemy Battler: <?php echo $enemy->getUsername();?></h2></li>
				<li><h2>Enemy Pet: <?php echo $enemy_Pet->getName(); ?></h2></li>
				<li class="enemy_petimg"><h2>Enemy Health:</h2> <?php echo $enemy_health[0] . "/" . $enemy_health[1]; ?></li>
			</ul>
		</section>
		
		<section class="battlefield">
			<img src=<?php echo "images/species/". $user_Pet->getSpecies()->getSpecies() . ".png"; ?> width="350" height="350" style="position: absolute; top: 70px; left: 300px;" />
			<img src=<?php echo "images/species/". $enemy_Pet->getSpecies()->getSpecies() . ".png"; ?> width="350" height="350" style="position: relative; top: 70px; left: 200px;" />
			<img src="images/field.png" style="position: relative; top: 0; left: 0; z-index: -1;" />
		</section>
		
		<p id="game_alert" class="game_alert"><?php echo $alert; ?></p>
		<p id="hidden"></p>
		
		<section class="player_stats">
			<ul>
				<li><h2>Pet: <?php echo $user_Pet->getName(); ?></h2></li>
				<li><h2>Health:</h2> <?php echo $user_health[0] . "/" . $user_health[1]; ?></li>
				<li><h2>Experience</h2> <img src="images/experience.png" /></li>
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
					<td><a href="battle.php?switch=0"><img src=<?php echo "images/species/". $user_team[0]->getSpecies()->getSpecies() . ".png"; ?> height="50" width="50" /></td>
					<td><a href="battle.php?switch=1"><img src=<?php echo "images/species/". $user_team[1]->getSpecies()->getSpecies() . ".png"; ?> /></td>
					<td><a href="battle.php?switch=2"><img src=<?php echo "images/species/". $user_team[2]->getSpecies()->getSpecies() . ".png"; ?> height="50" width="50"  /></td>
				</tr>
			</table>
		</section>
	
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="static/js/lib/jquery.js"><\/script>')
    </script>
    <script src="static/js/plugins.js"></script>
    <script src="static/js/base.js"></script>
	<script type="text/javascript" src="battle.js" ></script>

</body>

</html>