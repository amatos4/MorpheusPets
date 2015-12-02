<?php

  class Pet implements JsonSerializable
  {
    /** @var int unique id */
    private $id;

    /** @var User owner */
    private $owner;

    /** @var Species species */
    private $species;

    /** @var string name */
    private $name;

    /** @var int experience level */
    private $experience;

    /** @var int brawn stat */
    private $brawn;

    /** @var int guts stat */
    private $guts;

    /** @var int essence stat */
    private $essence;

    /** @var int speed stat */
    private $speed;

    /** @var int focus stat */
    private $focus;

    /** @var int grit stat */
    private $grit;

    /** @var bool whether pet is active */
    private $active;

    /**
     * Pet constructor.
     *
     * @param User    $owner
     * @param Species $species
     * @param string  $name
     */
    public function __construct( $owner, $species, $name )
    {
      $this->id         = 0;
      $this->owner      = $owner;
      $this->species    = $species;
      $this->name       = $name;
      $this->experience = 0;
      $this->brawn      = 0;
      $this->guts       = 0;
      $this->essence    = 0;
      $this->speed      = 0;
      $this->focus      = 0;
      $this->grit       = 0;
      $this->active     = false;
    }

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId( $id )
    {
      $this->id = $id;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
      return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner( $owner )
    {
      $this->owner = $owner;
    }

    /**
     * @return Species
     */
    public function getSpecies()
    {
      return $this->species;
    }

    /**
     * @param Species $species
     */
    public function setSpecies( $species )
    {
      $this->species = $species;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name )
    {
      $this->name = $name;
      unset( $this->image_url );
    }

    /**
     * @return int
     */
    public function getExperience()
    {
      return $this->experience;
    }

    /**
     * @param int $experience
     */
    public function setExperience( $experience )
    {
      $this->experience = $experience;
    }

    /**
     * @return int
     */
    public function getBrawn()
    {
      return $this->brawn;
    }

    /**
     * @param int $brawn
     */
    public function setBrawn( $brawn )
    {
      $this->brawn = $brawn;
    }

    /**
     * @return mixed
     */
    public function getGuts()
    {
      return $this->guts;
    }

    /**
     * @param mixed $guts
     */
    public function setGuts( $guts )
    {
      $this->guts = $guts;
    }

    /**
     * @return int
     */
    public function getEssence()
    {
      return $this->essence;
    }

    /**
     * @param int $essence
     */
    public function setEssence( $essence )
    {
      $this->essence = $essence;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
      return $this->speed;
    }

    /**
     * @param int $speed
     */
    public function setSpeed( $speed )
    {
      $this->speed = $speed;
    }

    /**
     * @return int
     */
    public function getFocus()
    {
      return $this->focus;
    }

    /**
     * @param int $focus
     */
    public function setFocus( $focus )
    {
      $this->focus = $focus;
    }

    /**
     * @return int
     */
    public function getGrit()
    {
      return $this->grit;
    }

    /**
     * @param int $grit
     */
    public function setGrit( $grit )
    {
      $this->grit = $grit;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
      return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive( $active )
    {
      $this->active = $active;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
      $array = [
        'id'         => $this->id,
        'owner_id'   => $this->owner->getId(),
        'species_id' => $this->species->getId(),
        'name'       => $this->name,
        'experience' => $this->experience,
        'brawn'      => $this->brawn,
        'guts'       => $this->guts,
        'essence'    => $this->essence,
        'speed'      => $this->speed,
        'focus'      => $this->focus,
        'grit'       => $this->grit,
        'active'     => $this->active
      ];

      return $array;
    }
  }
