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
		
		public function Setup() {
			$data = MorpheusPetsData::getInstance();
			if($this->setup != 1) {
				//session_start();
				$_SESSION['enemy'] = 2;
				$_SESSION['user'] = 1;
				if(isset($_SESSION['user'])){
					$this->user = $_SESSION['user'];
				} if(isset($_SESSION['enemy'])){
					$this->enemy = $_SESSION['enemy'];
				}
				
				$this->enemy_team = $data->getActivePetsForUser($this->enemy);
				$this->user_team = $data->getActivePetsForUser($this->user);
				
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
				//echo "Setting up";
				
				$this->setup = 1;
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
			
			if(($health[0]/$health[1]) <= .10) {
				
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
					$this->activeEnemyPet = $switch;
				}
			}
		}
		
		public function attack() {
			$user_pet = $this->user_team[$this->activePet];
			$enemy_pet = $this->enemy_team[$this->activeEnemyPet];
			
			$u_brawn = $user_pet->getBrawn();
			$u_exp = $user_pet->getExperience();
			$u_speed = $user_pet->getSpeed();
			
			$dmg = floor(rand(($u_exp / 100)+1, ((($u_exp / 100)+1) + ($u_brawn / 4) + ($u_speed / 8))));
			$ret = "You attacked for " . $dmg . "!!";
			
			$this->enemy_health[$this->activeEnemyPet][0] -= $dmg;
			
			return $ret;
		}
	}
	
?>