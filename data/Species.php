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
     * @return mixed
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId( $id )
    {
      $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSpecies()
    {
      return $this->species;
    }

    /**
     * @param mixed $species
     */
    public function setSpecies( $species )
    {
      $this->species = $species;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType( $type )
    {
      $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getStats()
    {
      return $this->stats;
    }

    /**
     * @param mixed $stats
     */
    public function setStats( $stats )
    {
      $this->stats = $stats;
    }
  }
