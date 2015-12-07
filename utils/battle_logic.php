<?php
require_once 'data/data.php';

class Battle {
	private $enemy_team;
	private $user_team;
	private $user;
	private $enemy;
	private $activePet;
	private $activeEnemyPet;
	private $setup;
	private $user_health;
	private $enemy_health;

	public function Setup($user, $enemy) {
		$data = MorpheusPetsData::getInstance();
		if($this->setup != 1) {
			//session_start();
			//$_SESSION['enemy'] = 2;
			//$_SESSION['user'] = 1;
			$this->user = $user;
			$this->enemy = $enemy;

			$this->enemy_team = $data->getActivePetsForUser($this->enemy);
			$this->user_team = $data->getActivePetsForUser($this->user);

			if((count($this->user_team) == 3) && (count($this->enemy_team) == 3)) {

				//echo "success";
				$this->activePet = 0;
				$this->activeEnemyPet = 0;
				$this->user_health = [];
				$this->enemy_health = [];

				for($x = 0; $x < 3; $x++) {
					$user_pet = $this->user_team[$x];
					$pet_health = $this->createHealth($user_pet);
					$this->user_health[$x] = array($pet_health, $pet_health);

					$enemy_pet = $this->enemy_team[$x];
					$e_pet_health = $this->createHealth($enemy_pet);
					$this->enemy_health[$x] = array($e_pet_health, $e_pet_health);
				}
			}
			else {
				//echo "Setting up";
				return -1;
			}

			$this->setup = 1;
			return "Make your move!";
		}
	}

	public function createHealth($pet) {
		$brawn = $pet->getBrawn();
		$exp = $pet->getExperience();
		$speed= $pet->getSpeed();
		$guts = $pet->getGuts();
		$focus = $pet->getFocus();
		$grit = $pet->getGrit();
		$essence = $pet->getEssence();

		$health = floor((20 + (($exp/100)+1) + ($essence/3) + (($brawn + $guts + $focus + $speed + $grit)/10)));
		return $health;
	}

	public function getUserHealth() {
		return $this->user_health[$this->activePet];
	}

	public function getPetHealth($id) {
		return $this->user_health[$id];
	}

	public function getEnemyHealth() {
		return $this->enemy_health[$this->activeEnemyPet];
	}

	public function getActivePet() {
		return $this->activePet;
	}

	public function getEnemyPet() {
		return $this->activeEnemyPet;
	}

	public function getEnemy() {
		return $this->enemy_team;
	}

	public function getUser() {
		return $this->user_team;
	}

	public function bestPick($pet) {
		$brawn = $pet->getBrawn();
		$speed= $pet->getSpeed();
		$guts = $pet->getGuts();
		$focus = $pet->getFocus();
		$grit = $pet->getGrit();

		if ($brawn > $focus && $brawn > $grit) {
			return 'a';}
		else if ($focus > $grit) {
			return 'm';}
		else {
			return 'd';}
	}

	public function computeMove() {
		//This computes the enemy's move

		$e_pet = $this->enemy_team[$this->activeEnemyPet];
		$brawn = $e_pet->getBrawn();
		$exp = $e_pet->getExperience();
		$speed= $e_pet->getSpeed();
		$guts = $e_pet->getGuts();
		$focus = $e_pet->getFocus();
		$grit = $e_pet->getGrit();
		$essence = $e_pet->getEssence();
		$health = $this->getEnemyHealth($e_pet);


		if($health[0] <= 0) {
			for($x = 0; $x < 3; $x++) {
				if($this->enemy_health[$x][0] > 0) {
					$this->switchPet(1, $x);
					return array('s', 0);
				}
			}
		}
		else if (($health[0]/$health[1]) <= .10) {
			for($x = 0; $x < 3; $x++) {
				if($this->enemy_health[$x][0] == $this->enemy_health[$x][1]) {
					$this->switchPet(1, $x);
					return array('s', 0);
				}
			}
		}

		switch(rand(1, 5)) {
			case 1:
				$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($brawn / 4) + ($speed / 8))));
				return array(0 => 'a', 1 => $dmg);
			case 2:
				$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($focus / 4) + ($speed / 8))));
				return array(0 => 'm', 1 => $dmg);
			case 3:
				$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($guts / 4) + ($speed / 8)))/2);
				return array(0 => 'd', 1 => $dmg);
			case 4:
				$u_pet = $this->user_team[$this->activePet];
				$move = $this->bestPick($u_pet);
				if($move == 'a') {
					$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($brawn / 4) + ($speed / 8))));
					return array(0 => 'a', 1 => $dmg);
				}
				else if($move == 'm') {
					$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($focus / 4) + ($speed / 8))));
					return array(0 => 'm', 1 => $dmg);
				}
				else {
					$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($guts / 4) + ($speed / 8)))/2);
					return array(0 => 'd', 1 => $dmg);
				}
			case 5:
				$move = $this->bestPick($e_pet);
				if($move == 'a') {
					$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($brawn / 4) + ($speed / 8))));
					return array(0 => 'a', 1 => $dmg);
				}
				else if($move == 'm') {
					$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($focus / 4) + ($speed / 8))));
					return array(0 => 'm', 1 => $dmg);
				}
				else {
					$dmg = floor(rand(($exp / 100)+1, ((($exp / 100)+1) + ($guts / 4) + ($speed / 8)))/2);
					return array(0 => 'd', 1 => $dmg);
				}
		}
	}

	public function switchPet($player, $pet) {
		if($pet < 4 && $pet > -1) {
			if($player == 0) {
				$this->activePet = $pet;
				$move = $this->computeMove();
				//print_r($move);
				if($move[0] == 'd') {
					return "You switched your pet, but your opponent defended!";
				}
				else if($move[0] == 'm') {
					$this->user_health[$this->activePet][0] -= $move[1];
					$ret = "You switched your pet, but your opponent casts a spell for " . $move[1] . " damage!";
					return $ret;
				}
				else if($move[0] == 'a') {
					$this->user_health[$this->activePet][0] -= $move[1];
					$ret = "You switched your pet, but your opponent attacked you for " . $move[1] . " damage!";
					return $ret;
				}
				else {
					return "You and your opponent switched your active pets!";
				}
			}
			else if($player == 1) {
				$this->activeEnemyPet = $pet;
			}
		}
	}

	//Computes if there are type weaknesses in the battle. Returns 0 if the user is weak, 1 if the enemy is weak, 2 if they are both weak, and -1 if neither are weak.
	public function computeWeakness($u_pet, $e_pet) {
		$u_type = $u_pet->getSpecies()->getType();
		$e_type = $e_pet->getSpecies()->getType();
		$weaknesses = ["Fire" => "Water", "Water" => "Air", "Air" => "Earth", "Earth" => "Fire", "Dark" => "Light", "Light" => "Dark"];

		if(($weaknesses[$u_type] == $e_type) && ($weaknesses[$e_type] == $u_type)) {
			return 2;
		}
		else if($weaknesses[$u_type] == $e_type) {
			return 0;
		}
		else if($weaknesses[$e_type] == $u_type) {
			return 1;
		}
		else {
			return -1;
		}
	}

	public function attack() {
		$user_pet = $this->user_team[$this->activePet];
		$enemy_pet = $this->enemy_team[$this->activeEnemyPet];
		$move = $this->computeMove();
		$weak = $this->computeWeakness($user_pet, $enemy_pet);
		//echo $weak;

		$u_brawn = $user_pet->getBrawn();
		$u_exp = $user_pet->getExperience();
		$u_speed = $user_pet->getSpeed();
		$e_brawn = $enemy_pet->getBrawn();
		$e_exp = $enemy_pet->getExperience();
		$e_speed = $enemy_pet->getSpeed();

		$user_red = rand(((($u_exp / 100)+1) / 10), ((($u_exp / 100)+1) / 10) + ($u_brawn / 10) + ($u_speed / 20));
		$enemy_red = rand(((($e_exp / 100)+1) / 10), ((($e_exp / 100)+1) / 10) + ($e_brawn / 10) + ($e_speed / 20));
		$dmg = floor(rand(($u_exp / 100)+1, ((($u_exp / 100)+1) + ($u_brawn / 4) + ($u_speed / 8))));

		if($weak == 2) {
			$dmg += 1;
			$dmg *= 2;
			$move[1] += 1;
			$move[1] *= 2;
		}
		else if($weak == 1) {
			$dmg += 1;
			$dmg *= 2;
		}
		else if($weak == 0) {
			$move[1] += 1;
			$move[1] *= 2;
		}

		//Computing damage reduction
		if(($dmg - $enemy_red) < 0) {
			$dmg = 0;
		}
		else {
			$dmg -= $enemy_red;
		}
		if(($move[1] - $user_red) < 0) {
			$move[1] = 0;
		}
		else {
			$move[1] -= $user_red;
		}

		//Rock Paper Scissors check
		if($move[0] == 'a') {
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			$this->user_health[$this->activePet][0] -= $move[1];
			$ret = "You and your opponent bash into each other! You lost " .  $move[1] . " health! He lost " . $dmg . " health!";
			return $ret;
		}
		else if($move[0] == 'm') {
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			$ret = "You disrupt his spell with a flying kick dealing " . $dmg . " damage!";
			return $ret;
		}
		else if($move[0] == 'd') {
			$this->user_health[$this->activePet][0] -= $move[1];
			$ret = "You smash into his block and he counters for " . $move[1] . " damage!";
			return $ret;
		}
		else if($move[0] == 's') {
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			$ret = "Your opponent switched his pet and you attack for " . $dmg . " damage!";
			return $ret;
		}
	}

	public function magic() {
		$user_pet = $this->user_team[$this->activePet];
		$enemy_pet = $this->enemy_team[$this->activeEnemyPet];
		$move = $this->computeMove();
		$weak = $this->computeWeakness($user_pet, $enemy_pet);
		//echo $weak;

		$u_brawn = $user_pet->getBrawn();
		$u_focus = $user_pet->getFocus();
		$u_exp = $user_pet->getExperience();
		$u_speed = $user_pet->getSpeed();
		$e_brawn = $enemy_pet->getBrawn();
		$e_exp = $enemy_pet->getExperience();
		$e_speed = $enemy_pet->getSpeed();

		$user_red = rand(((($u_exp / 100)+1) / 10), ((($u_exp / 100)+1) / 10) + ($u_brawn / 10) + ($u_speed / 20));
		$enemy_red = rand(((($e_exp / 100)+1) / 10), ((($e_exp / 100)+1) / 10) + ($e_brawn / 10) + ($e_speed / 20));
		$dmg = floor(rand(($u_exp / 100)+1, ((($u_exp / 100)+1) + ($u_focus / 4) + ($u_speed / 8))));

		if($weak == 2) {
			$dmg += 1;
			$dmg *= 2;
			$move[1] += 1;
			$move[1] *= 2;
		}
		else if($weak == 1) {
			$dmg += 1;
			$dmg *= 2;
		}
		else if($weak == 0) {
			$move[1] += 1;
			$move[1] *= 2;
		}

		//Computing damage reduction
		if(($dmg - $enemy_red) < 0) {
			$dmg = 0;
		}
		else {
			$dmg -= $enemy_red;
		}
		if(($move[1] - $user_red) < 0) {
			$move[1] = 0;
		}
		else {
			$move[1] -= $user_red;
		}

		//Rock Paper Scissors check
		if($move[0] == 'm') {
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			$this->user_health[$this->activePet][0] -= $move[1];
			$ret = "You and your opponent cast spells into each other! You lost " .  $move[1] . " health! He lost " . $dmg . " health!";
			return $ret;
		}
		else if($move[0] == 'd') {
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			$ret = "You break his block with a magic burst dealing " . $dmg . " damage!";
			return $ret;
		}
		else if($move[0] == 'a') {
			$this->user_health[$this->activePet][0] -= $move[1];
			$ret = "He attacks and disrupts your spell for  " . $move[1] . " damage!";
			return $ret;
		}
		else if($move[0] == 's') {
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			$ret = "Your opponent switched his pet and you blast him with a spell for " . $dmg . " damage!";
			return $ret;
		}
	}

	public function defend() {
		$user_pet = $this->user_team[$this->activePet];
		$enemy_pet = $this->enemy_team[$this->activeEnemyPet];
		$move = $this->computeMove();
		$weak = $this->computeWeakness($user_pet, $enemy_pet);
		//echo $weak;

		$u_brawn = $user_pet->getBrawn();
		$u_guts = $user_pet->getGuts();
		$u_exp = $user_pet->getExperience();
		$u_speed = $user_pet->getSpeed();
		$e_brawn = $enemy_pet->getBrawn();
		$e_exp = $enemy_pet->getExperience();
		$e_speed = $enemy_pet->getSpeed();

		$user_red = rand(((($u_exp / 100)+1) / 10), ((($u_exp / 100)+1) / 10) + ($u_brawn / 10) + ($u_speed / 20));
		$enemy_red = rand(((($e_exp / 100)+1) / 10), ((($e_exp / 100)+1) / 10) + ($e_brawn / 10) + ($e_speed / 20));
		$dmg = floor(rand(($u_exp / 100)+1, ((($u_exp / 100)+1) + ($u_guts / 4) + ($u_speed / 8)))/2);

		if($weak == 2) {
			$dmg += 1;
			$dmg *= 2;
			$move[1] += 1;
			$move[1] *= 2;
		}
		else if($weak == 1) {
			$dmg += 1;
			$dmg *= 2;
		}
		else if($weak == 0) {
			$move[1] += 1;
			$move[1] *= 2;
		}

		//Computing damage reduction
		if(($dmg - $enemy_red) < 0) {
			$dmg = 0;
		}
		else {
			$dmg -= $enemy_red;
		}
		if(($move[1] - $user_red) < 0) {
			$move[1] = 0;
		}
		else {
			$move[1] -= $user_red;
		}

		//Rock Paper Scissors check
		if($move[0] == 'd') {
			$ret = "You and your opponent both blocked!";
			return $ret;
		}
		else if($move[0] == 'a') {
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			$ret = "You block and counter his attack for " . $dmg . " damage!";
			return $ret;
		}
		else if($move[0] == 'm') {
			$this->user_health[$this->activePet][0] -= $move[1];
			$ret = "He breaks your block with a spell for " . $move[1] . " damage!";
			return $ret;
		}
		else if($move[0] == 's') {
			$ret = "Your opponent switched his pet and you blocked!";
			return $ret;
		}
	}

	//for each pet, sets new exp value and levels up if applicable. Returns a string with the pets that leveled up
	public function checkLevelUp($exp_gain) {
		$orig_exp = 0;
		$ret = "";

		for($x = 0; $x < 3; $x++) {
			$orig_exp = $this->user_team[$x]->getExperience();  //get the old exp value
			$orig_level = floor($orig_exp / 100) + 1;           //get the old level
			$new_exp = $orig_exp + $exp_gain;                   //add the gained exp to get the new exp value
			$new_level = floor($new_exp / 100) + 1;             //get the new level
			if($new_level > $orig_level) {                       //if the pet leveled up
				$ret = $ret . "<br /><br />" . $this->user_team[$x]->getName() . " leveled up, and is now level " . strval(floor($new_exp / 100) + 1) . "!";

				//level up procedure
				$statincrease = [0, 0, 0, 0, 0, 0];     //one per stat
				$points = 21;                           //6 + 5 + ... + 1.
				$species = $this->user_team[$x]->getSpecies();  //gets the species of the pet leveling up
				$priority = $species->getStats(); //gets the species' stat priority

				for($i = 0; $i < 6; $i++) { //for all six stats
					$spent = rand(1, (6 - $i)); //pick a number between 1 and a decreasing max
					$statincrease[$i] = $spent; //this number is how much the stat will increase
					$points -= $spent;          //take it off of the lvlup points total
				}

				while($points > 0)              //If there are (maybe still) points left over
					for($i = 5; $i >= 0; $i--)   //Counts down, we're increasing the stats in reverse order to make it slightly more even
						if ($points > 0) {       //just in case we run out during the loop
							$statincrease[$i]++;
							$points--;
						}


				for ($curstat = 0; $curstat < 6; $curstat ++) {
					//echo $priority[$curstat];
					switch($priority[$curstat]){
						case 'b':
							$this->user_team[$x]->setBrawn($this->user_team[$x]->getBrawn() + $statincrease[$curstat]);
							break;
						case 'g':
							$this->user_team[$x]->setGuts($this->user_team[$x]->getGuts() + $statincrease[$curstat]);
							break;
						case 'e':
							$this->user_team[$x]->setEssence($this->user_team[$x]->getEssence() + $statincrease[$curstat]);
							break;
						case 's':
							$this->user_team[$x]->setSpeed($this->user_team[$x]->getSpeed() + $statincrease[$curstat]);
							break;
						case 'f':
							$this->user_team[$x]->setFocus($this->user_team[$x]->getFocus() + $statincrease[$curstat]);
							break;
						case 'r':
							$this->user_team[$x]->setGrit($this->user_team[$x]->getGrit() + $statincrease[$curstat]);
							break;
					}
				}
			}
			//regardless of level up or not
			$this->user_team[$x]->setExperience($new_exp);                           //set the new exp value
			//update pet
			$data = MorpheusPetsData::getInstance();
			$data->updatepet($this->user_team[$x]);
		}

		return $ret;
	}

	//Checks for the end of the battle. Returns a tuple first saying true if the battle is over, second saying the outcome and experience gained.
	public function checkConclusion() {
		$e_out = 0;
		$u_out = 0;
		$e_levels = 0;
		$u_levels = 0;
		$u_expgain = 0;

		/*only exp for fainted pets counts
        for($x = 0; $x < 3; $x++) {
            if($this->user_health[$x][0] <= 0) {
                $u_out++;
                $u_exp = $this->user_team[$x]->getExperience();
                $u_levels += floor(($u_exp / 100)+1);
            }
            if($this->enemy_health[$x][0] <= 0) {
                $e_out++;
                $e_exp = $this->enemy_team[$x]->getExperience();
                $e_levels += floor(($e_exp / 100)+1);
            }
        }*/

		for($x = 0; $x < 3; $x++) {
			if($this->user_health[$x][0] <= 0) { //check how many player pets are koed
				$u_out++;
			}

			//Counts the user's pet's levels regardless of if they were koed
			$u_exp = $this->user_team[$x]->getExperience();
			$u_levels += floor(($u_exp / 100)+1);

			if($this->enemy_health[$x][0] <= 0) { //check how many enemy pets are koed, and adds up their levels
				$e_out++;
				$e_exp = $this->enemy_team[$x]->getExperience();
				$e_levels += floor(($e_exp / 100)+1);
			}
		}

		if($e_out == 3) {
			//echo $u_levels;
			$u_expgain = floor(sqrt($e_levels/$u_levels)*20);
			/*for($x = 0;$x < 3; $x++) {
                $p_exp = $this->user_team[$x]->getExperience();
                $this->user_team[$x]->setExperience(($p_exp + $u_expgain)); //need to add exp to the db
            }*/
			$ret = "<br /><br />You've won! Your pets each gained " . $u_expgain . " experience!";
			$ret = $ret . $this->checkLevelUp($u_expgain);
			return array(true, $ret);
		}
		else if($u_out == 3) {
			$u_expgain = floor(sqrt($e_levels/$u_levels)*10);
			/*for($x = 0;$x < 3; $x++) {
                $p_exp = $this->user_team[$x]->getExperience();
                $this->user_team[$x]->setExperience(($p_exp + $u_expgain));
            }*/
			$ret = "<br /><br />You've lost! Your pets each gained " . $u_expgain . " experience!";
			$ret = $ret . $this->checkLevelUp($u_expgain);
			return array(true, $ret);
		}
		else {
			return array(false, false);
		}
	}


}

?>