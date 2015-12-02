<?php

  class Species implements JsonSerializable
  {
    // Mapping between stat abbreviations and stat names
    private static $stat_abbr_to_stat_name = [
      'b' => 'Brawn',
      'g' => 'Guts',
      'e' => 'Essence',
      's' => 'Speed',
      'f' => 'Focus',
      'r' => 'Grit'
    ];

    private $id;

    /** @var string species name */
    private $species;

    /** @var string type */
    private $type;

    /** @var string stat priorities using abbreviations */
    private $stats;

    /** @var string stat priorities using full stat names */
    private $stats_readable;

    /**
     * Species constructor.
     *
     * @param string $species
     * @param string $type
     * @param string $stats
     */
    public function __construct( $species, $type, $stats )
    {
      $this->id      = 0;
      $this->species = $species;
      $this->type    = $type;
      $this->stats   = $stats;
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
     * @return string
     */
    public function getSpecies()
    {
      return $this->species;
    }

    /**
     * @param string $species
     */
    public function setSpecies( $species )
    {
      $this->species = $species;
    }

    /**
     * @return string
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType( $type )
    {
      $this->type = $type;
    }

    /**
     * @return string
     */
    public function getStats()
    {
      return $this->stats;
    }

    /**
     * @param string $stats
     */
    public function setStats( $stats )
    {
      $this->stats = $stats;
    }

    /**
     * @return array stat names in order of priority
     */
    public function getReadableStatPriorities()
    {
      if ( !isset( $this->stats_readable ) )
      {
        $array = [ ];

        $length = strlen( $this->stats );

        for ( $i = 0; $i < $length; $i++ )
        {
          array_push( $array, self::$stat_abbr_to_stat_name[ $this->stats[ $i ] ] );
        }

        $this->stats_readable = $array;
      }

      return $this->stats_readable;
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
        'id'      => $this->id,
        'species' => $this->species,
        'type'    => $this->type,
        'stats'   => $this->getReadableStatPriorities()
      ];

      return $array;
    }
  }
