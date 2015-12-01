<?php

  require_once 'data/connection.php';
  require_once 'data/User.php';
  require_once 'data/Pet.php';
  require_once 'data/Species.php';

  class MorpheusPetsData
  {
    private $dbConnection;

    private $addPetStatement;
    private $getPetStatement;
    private $getAllPetsForUserStatement;
    private $getActivePetsForUserStatement;
    private $updatePetStatement;

    private $addUserStatement;
    private $getUserStatement;
    private $getUserByUserNameStatement;
    private $updateUserStatement;

    private $addSpeciesStatement;
    private $getSpeciesStatement;
    private $getSpeciesByNameStatement;
    private $getAllSpeciesStatement;
    private $updateSpeciesStatement;

    private static $instance;

    /**
     * Add a pet
     *
     * @param Pet $pet
     *
     * @return bool|int
     */
    public function addPet( $pet )
    {
      $ret = false;

      if ( $pet->getOwner() !== null && $pet->getSpecies() !== null )
      {
        $owner_id   = $pet->getOwner()->getId();
        $species_id = $pet->getSpecies()->getId();
        $name       = $pet->getName();
        $experience = $pet->getExperience();
        $brawn      = $pet->getBrawn();
        $guts       = $pet->getGuts();
        $essence    = $pet->getEssence();
        $speed      = $pet->getSpeed();
        $focus      = $pet->getFocus();
        $grit       = $pet->getGrit();
        $active     = intval( $pet->isActive() );

        $this->addPetStatement->bind_param( "iiiiiiiiiii", $owner_id, $species_id, $name, $experience, $brawn, $guts, $essence, $speed, $focus, $grit, $active );
        if ( $this->addPetStatement->execute() )
        {
          $ret = $this->dbConnection->last_insert_id();
        }
      }

      return $ret;
    }

    /**
     * Get a pet by id
     *
     * @param int $id
     *
     * @return null|Pet
     */
    public function getPet( $id )
    {
      $ret = null;

      // Pet variables
      $res_id     = null;
      $owner_id   = null;
      $species_id = null;
      $name       = null;
      $experience = null;
      $brawn      = null;
      $guts       = null;
      $essence    = null;
      $speed      = null;
      $focus      = null;
      $grit       = null;
      $active     = null;

      // User variables
      $username      = null;
      $email_address = null;
      $description   = null;

      // Species variables
      $species = null;
      $type    = null;
      $stats   = null;

      $this->getPetStatement->bind_param( "i", $id );
      $this->getPetStatement->execute();
      $this->getPetStatement->bind_result( $res_id, $owner_id, $species_id, $name, $experience, $brawn, $guts, $essence, $speed, $focus, $grit, $active, $username, $description, $species, $type, $stats );

      // Expecting only 1 result
      if ( $this->getPetStatement->fetch() )
      {
        $newUser = new User( $username, $email_address, $description );
        $newUser->setId( $owner_id );

        $newSpecies = new Species( $species, $type, $stats );
        $newSpecies->setId( $species_id );

        $ret = new Pet( $newUser, $newSpecies, $name );
        $ret->setId( $res_id );
        $ret->setExperience( $experience );
        $ret->setBrawn( $brawn );
        $ret->setGuts( $guts );
        $ret->setEssence( $essence );
        $ret->setSpeed( $speed );
        $ret->setFocus( $focus );
        $ret->setGrit( $grit );
        $ret->setActive( boolval( $active ) );

        // Another fetch to not leave query in progress
        $this->getPetStatement->fetch();
      }

      return $ret;
    }

    /**
     * Get all pets owned by a user
     *
     * @param int $id
     *
     * @return array
     */
    public function getAllPetsForUser( $id )
    {
      $ret = [ ];

      // Pet variables
      $res_id     = null;
      $owner_id   = null;
      $species_id = null;
      $name       = null;
      $experience = null;
      $brawn      = null;
      $guts       = null;
      $essence    = null;
      $speed      = null;
      $focus      = null;
      $grit       = null;
      $active     = null;

      // User variables
      $username      = null;
      $email_address = null;
      $description   = null;

      // Species variables
      $species = null;
      $type    = null;
      $stats   = null;

      $this->getAllPetsForUserStatement->bind_param( "i", $id );
      $this->getAllPetsForUserStatement->execute();
      $this->getAllPetsForUserStatement->bind_result( $res_id, $owner_id, $species_id, $name, $experience, $brawn, $guts, $essence, $speed, $focus, $grit, $active, $username, $email_address, $description, $species, $type, $stats );

      while ( $this->getAllPetsForUserStatement->fetch() )
      {
        $newUser = new User( $username, $email_address, $description );
        $newUser->setId( $owner_id );

        $newSpecies = new Species( $species, $type, $stats );
        $newSpecies->setId( $species_id );

        $newPet = new Pet( $newUser, $newSpecies, $name );
        $newPet->setId( $res_id );
        $newPet->setExperience( $experience );
        $newPet->setBrawn( $brawn );
        $newPet->setGuts( $guts );
        $newPet->setEssence( $essence );
        $newPet->setSpeed( $speed );
        $newPet->setFocus( $focus );
        $newPet->setGrit( $grit );
        $newPet->setActive( boolval( $active ) );

        array_push( $ret, $newPet );
      }

      return $ret;
    }

    /**
     * Get all active pets owned by a user
     *
     * @param int $id
     *
     * @return array
     */
    public function getActivePetsForUser( $id )
    {
      $ret = [ ];

      // Pet variables
      $res_id     = null;
      $owner_id   = null;
      $species_id = null;
      $name       = null;
      $experience = null;
      $brawn      = null;
      $guts       = null;
      $essence    = null;
      $speed      = null;
      $focus      = null;
      $grit       = null;
      $active     = null;

      // User variables
      $username      = null;
      $email_address = null;
      $description   = null;

      // Species variables
      $species = null;
      $type    = null;
      $stats   = null;

      $this->getActivePetsForUserStatement->bind_param( "i", $id );
      $this->getActivePetsForUserStatement->execute();
      $this->getActivePetsForUserStatement->bind_result( $res_id, $owner_id, $species_id, $name, $experience, $brawn, $guts, $essence, $speed, $focus, $grit, $active, $username, $description, $species, $type, $stats );

      while ( $this->getActivePetsForUserStatement->fetch() )
      {
        $newUser = new User( $username, $email_address, $description );
        $newUser->setId( $owner_id );

        $newSpecies = new Species( $species, $type, $stats );
        $newSpecies->setId( $species_id );

        $newPet = new Pet( $newUser, $newSpecies, $name );
        $newPet->setId( $res_id );
        $newPet->setExperience( $experience );
        $newPet->setBrawn( $brawn );
        $newPet->setGuts( $guts );
        $newPet->setEssence( $essence );
        $newPet->setSpeed( $speed );
        $newPet->setFocus( $focus );
        $newPet->setGrit( $grit );
        $newPet->setActive( boolval( $active ) );

        array_push( $ret, $newPet );
      }

      return $ret;
    }

    /**
     * Update a pet by id
     *
     * @param Pet $pet
     *
     * @return bool
     */
    public function updatePet( $pet )
    {
      $id         = $pet->getId();
      $name       = $pet->getName();
      $experience = $pet->getExperience();
      $brawn      = $pet->getBrawn();
      $guts       = $pet->getGuts();
      $essence    = $pet->getEssence();
      $speed      = $pet->getSpeed();
      $focus      = $pet->getFocus();
      $grit       = $pet->getGrit();
      $active     = intval( $pet->isActive() );

      $this->updatePetStatement->bind_param( "iiiiiiiiii", $name, $experience, $brawn, $guts, $essence, $speed, $focus, $grit, $active, $id );

      return $this->updatePetStatement->execute();
    }

    /**
     * Add a user
     *
     * @param User $user
     *
     * @return mixed|null
     */
    public function addUser( $user )
    {
      $ret = null;

      $username      = $user->getUsername();
      $password_hash = $user->getPasswordHash();
      $email_address = $user->getEmailAddress();
      $description   = $user->getDescription();

      $this->addUserStatement->bind_param( "ssss", $username, $password_hash, $email_address, $description );
      if ( $this->addUserStatement->execute() )
      {
        $ret = $this->dbConnection->last_insert_id();
      }

      return $ret;
    }

    /**
     * Get a user by id
     *
     * @param int $id
     *
     * @return null|User
     */
    public function getUser( $id )
    {
      $ret = null;

      $res_id        = null;
      $username      = null;
      $password_hash = null;
      $email_address = null;
      $description   = null;

      $this->getUserStatement->bind_param( "i", $id );
      $this->getUserStatement->execute();
      $this->getUserStatement->bind_result( $res_id, $username, $password_hash, $email_address, $description );

      // Expecting only 1 result
      if ( $this->getUserStatement->fetch() )
      {
        $ret = new User( $username, $email_address, $description );
        $ret->setPasswordHash( $password_hash );
        $ret->setId( $res_id );

        // Another fetch to not leave query in progress
        $this->getUserStatement->fetch();
      }

      return $ret;
    }

    /**
     * Get a user by username
     *
     * @param string $username
     *
     * @return null|User
     */
    public function getUserByUserName( $username )
    {
      $ret = null;

      $id            = null;
      $res_username  = null;
      $password_hash = null;
      $email_address = null;
      $description   = null;

      $this->getUserByUserNameStatement->bind_param( "s", $username );
      $this->getUserByUserNameStatement->execute();
      $this->getUserByUserNameStatement->bind_result( $id, $res_username, $password_hash, $email_address, $description );

      // Expecting only 1 result
      if ( $this->getUserByUserNameStatement->fetch() )
      {
        $ret = new User( $res_username, $email_address, $description );
        $ret->setPasswordHash( $password_hash );
        $ret->setId( $id );

        // Another fetch to not leave query in progress
        $this->getUserByUserNameStatement->fetch();
      }


      return $ret;
    }

    /**
     * Add a species
     *
     * @param Species $species
     *
     * @return mixed|null
     */
    public function addSpecies( $species )
    {
      $ret = null;

      $species_name = $species->getSpecies();
      $type         = $species->getType();
      $stats        = $species->getStats();

      $this->addSpeciesStatement->bind_param( "sss", $species_name, $type, $stats );
      if ( $this->addSpeciesStatement->execute() )
      {
        $ret = $this->dbConnection->last_insert_id();
      }

      return $ret;
    }

    /**
     * Get a species by id
     *
     * @param int $id
     *
     * @return null|Species
     */
    public function getSpecies( $id )
    {
      $ret = null;

      $res_id       = null;
      $species_name = null;
      $type         = null;
      $stats        = null;

      $this->getSpeciesStatement->bind_param( "i", $id );
      $this->getSpeciesStatement->execute();
      $this->getSpeciesStatement->bind_result( $res_id, $species_name, $type, $stats );

      // Expecting only 1 result
      if ( $this->getSpeciesStatement->fetch() )
      {
        $ret = new Species( $species_name, $type, $stats );
        $ret->setId( $res_id );

        // Another fetch to not leave query in progress
        $this->getSpeciesStatement->fetch();
      }

      return $ret;
    }

    /**
     * Get a species by name
     *
     * @param string $name
     *
     * @return null|Species
     */
    public function getSpeciesByName( $name )
    {
      $ret = null;

      $id       = null;
      $res_name = null;
      $type     = null;
      $stats    = null;

      $this->getSpeciesByNameStatement->bind_param( "s", $name );
      $this->getSpeciesByNameStatement->execute();
      $this->getSpeciesByNameStatement->bind_result( $id, $res_name, $type, $stats );

      // Expecting only 1 result
      if ( $this->getSpeciesByNameStatement->fetch() )
      {
        $ret = new Species( $res_name, $type, $stats );
        $ret->setId( $id );

        // Another fetch to not leave query in progress
        $this->getSpeciesByNameStatement->fetch();
      }

      return $ret;
    }

    /**
     * Get all species
     *
     * @return array
     */
    public function getAllSpecies()
    {
      $ret = [ ];

      // Species variables
      $id      = null;
      $species = null;
      $type    = null;
      $stats   = null;

      $this->getAllSpeciesStatement->execute();
      $this->getAllSpeciesStatement->bind_result( $id, $species, $type, $stats );

      while ( $this->getAllSpeciesStatement->fetch() )
      {
        $newSpecies = new Species( $species, $type, $stats );
        $newSpecies->setId( $id );

        array_push( $ret, $newSpecies );
      }

      return $ret;
    }

    /**
     * MorpheusPetsData constructor.
     * Initialize prepared statements
     */
    private function __construct()
    {
      $this->dbConnection = new DatabaseConnection();

      $this->addPetStatement               = $this->dbConnection->prepare_statement( "INSERT INTO `user_pets` (`owner_id`, `species_id`, `name`, `experience`, `brawn`, `guts`, `essence`, `speed`, `focus`, `grit`, `active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
      $this->getPetStatement               = $this->dbConnection->prepare_statement( "SELECT `user_pets`.`id`, `user_pets`.`owner_id`, `user_pets`.`species_id`, `user_pets`.`name`, `user_pets`.`experience`, `user_pets`.`brawn`, `user_pets`.`guts`, `user_pets`.`essence`, `user_pets`.`speed`, `user_pets`.`focus`, `user_pets`.`grit`, `user_pets`.`active`, `users`.`username`, `users`.`email_address`, `users`.`description`, `species`.`species`, `species`.`type`, `species`.`stats` FROM `user_pets` INNER JOIN `users` ON `user_pets`.`owner_id` = `users`.`id` INNER JOIN `species` ON `user_pets`.`species_id` = `species`.`id` WHERE `user_pets`.`id`=?" );
      $this->getAllPetsForUserStatement    = $this->dbConnection->prepare_statement( "SELECT `user_pets`.`id`, `user_pets`.`owner_id`, `user_pets`.`species_id`, `user_pets`.`name`, `user_pets`.`experience`, `user_pets`.`brawn`, `user_pets`.`guts`, `user_pets`.`essence`, `user_pets`.`speed`, `user_pets`.`focus`, `user_pets`.`grit`, `user_pets`.`active`, `users`.`username`, `users`.`email_address`, `users`.`description`, `species`.`species`, `species`.`type`, `species`.`stats` FROM `user_pets` INNER JOIN `users` ON `user_pets`.`owner_id` = `users`.`id` INNER JOIN `species` ON `user_pets`.`species_id` = `species`.`id` WHERE `users`.`id`=?" );
      $this->getActivePetsForUserStatement = $this->dbConnection->prepare_statement( "SELECT `user_pets`.`id`, `user_pets`.`owner_id`, `user_pets`.`species_id`, `user_pets`.`name`, `user_pets`.`experience`, `user_pets`.`brawn`, `user_pets`.`guts`, `user_pets`.`essence`, `user_pets`.`speed`, `user_pets`.`focus`, `user_pets`.`grit`, `user_pets`.`active`, `users`.`username`, `users`.`email_address`, `users`.`description`, `species`.`species`, `species`.`type`, `species`.`stats` FROM `user_pets` INNER JOIN `users` ON `user_pets`.`owner_id` = `users`.`id` INNER JOIN `species` ON `user_pets`.`species_id` = `species`.`id` WHERE `user_pets`.`id`=? AND `user_pets`.`active`=TRUE" );
      $this->updatePetStatement            = $this->dbConnection->prepare_statement( "UPDATE `user_pets` SET `name`=?, `experience`=?, `brawn`=?, `guts`=?, `essence`=?, `speed`=?, `focus`=?, `grit`=?, `active`=? WHERE `id`=?" );

      $this->addUserStatement           = $this->dbConnection->prepare_statement( "INSERT INTO `users` (`username`, `password_hash`, `email_address`, `description`) VALUES(?, ?, ?, ?)" );
      $this->getUserStatement           = $this->dbConnection->prepare_statement( "SELECT * FROM `users` WHERE `id`=?" );
      $this->getUserByUserNameStatement = $this->dbConnection->prepare_statement( "SELECT * FROM `users` WHERE `username`=?" );
      $this->updateUserStatement        = $this->dbConnection->prepare_statement( "UPDATE `users` SET `username`=?, `password_hash`=?, `email_address`=?, `description`=? WHERE `id`=?" );

      $this->addSpeciesStatement       = $this->dbConnection->prepare_statement( "INSERT INTO `species` (`species`, `type`, `stats`) VALUES(?, ?, ?)" );
      $this->getSpeciesStatement       = $this->dbConnection->prepare_statement( "SELECT * FROM `species` WHERE `id`=?" );
      $this->getSpeciesByNameStatement = $this->dbConnection->prepare_statement( "SELECT * FROM `species` WHERE `species`=?" );
      $this->getAllSpeciesStatement    = $this->dbConnection->prepare_statement( "SELECT * FROM `species`" );
      $this->updateSpeciesStatement    = $this->dbConnection->prepare_statement( "UPDATE `species` SET `species`=?, `type`=?, `stats`=? WHERE `id`=?" );
    }

    /**
     * @return MorpheusPetsData The single shared instance
     */
    public static function getInstance()
    {
      if ( !self::$instance )
      {
        self::$instance = new self();
      }

      return self::$instance;
    }

    /**
     * Empty clone method to prevent connection duplication
     */
    private function __clone()
    {

    }

    /**
     * Close resources on destruct
     */
    function __destruct()
    {
      if ( $this->addPetStatement )
      {
        $this->addPetStatement->close();
      }
      if ( $this->getPetStatement )
      {
        $this->getPetStatement->close();
      }
      if ( $this->getAllPetsForUserStatement )
      {
        $this->getAllPetsForUserStatement->close();
      }
      if ( $this->getActivePetsForUserStatement )
      {
        $this->getActivePetsForUserStatement->close();
      }
      if ( $this->updatePetStatement )
      {
        $this->updatePetStatement->close();
      }

      if ( $this->addUserStatement )
      {
        $this->addUserStatement->close();
      }
      if ( $this->getUserStatement )
      {
        $this->getUserStatement->close();
      }
      if ( $this->getUserByUserNameStatement )
      {
        $this->getUserByUserNameStatement->close();
      }
      if ( $this->updateUserStatement )
      {
        $this->updateUserStatement->close();
      }

      if ( $this->addSpeciesStatement )
      {
        $this->addSpeciesStatement->close();
      }
      if ( $this->getSpeciesStatement )
      {
        $this->getSpeciesStatement->close();
      }
      if ( $this->getSpeciesByNameStatement )
      {
        $this->getSpeciesByNameStatement->close();
      }
      if ( $this->getAllSpeciesStatement )
      {
        $this->getAllSpeciesStatement->close();
      }
      if ( $this->updateSpeciesStatement )
      {
        $this->updateSpeciesStatement->close();
      }
    }
  }
