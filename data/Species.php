<?php

  class Species
  {
    private $id;

    private $species;

    private $type;

    private $stats;

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


  }
