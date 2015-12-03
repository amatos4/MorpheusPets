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

    /** @var bool whether stats were rolled */
    private $rolled_stats;

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
      $this->rolled_stats = true;
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
      $this->rolled_stats = true;
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
      $this->rolled_stats = true;
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
      $this->rolled_stats = true;
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
      $this->rolled_stats = true;
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
      $this->rolled_stats = true;
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
     * Creates the initial stats for a new pet using the
     * stats priority from the species
     */
    public function rollStats()
    {
      // Do not roll stats if they were manually set
      if ( !$this->rolled_stats && isset( $this->species ) )
      {
        $priority = $this->species->getStats();

        srand( time() );

        $starter_stats = [ 0, 0, 0, 0, 0, 0 ];
        $points        = 126; // ((6+5+...+1) * 6)

        for ( $cur_stat = 0; $cur_stat < 6; $cur_stat++ ) // for each stat
        {
          $spent = 0;
          for ( $dice_rolled = 0; $dice_rolled < ( 7 - $cur_stat ); $dice_rolled++ ) // Rolls 6 dice for the primary stat
            $spent += rand( 1, 6 );
          $starter_stats[ $cur_stat ] = $spent;
          $points -= $spent;
        }
        // We are now done with the initial rolls. Now to distribute the left over points
        while ( $points > 0 )
          for ( $cur_stat = 0; $cur_stat < 6; $cur_stat++ )
            if ( $points > 0 )
            {
              $starter_stats[ $cur_stat ]++;
              $points--;
            }

        // Apply using priority
        for ( $cur_stat = 0; $cur_stat < 6; $cur_stat++ )
        {
          switch ( $priority[ $cur_stat ] )
          {
            case 'b':
              $this->brawn = $starter_stats[ $cur_stat ];
              break;
            case 'g':
              $this->guts = $starter_stats[ $cur_stat ];
              break;
            case 'e':
              $this->essence = $starter_stats[ $cur_stat ];
              break;
            case 's':
              $this->speed = $starter_stats[ $cur_stat ];
              break;
            case 'f':
              $this->focus = $starter_stats[ $cur_stat ];
              break;
            case 'r':
              $this->grit = $starter_stats[ $cur_stat ];
              break;
          }
        }
      }
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
