<?php
  require_once 'data/data.php';

  // GET keys
  $species_id_key = 'species_id';

  header( 'Content-Type: application/json' );

  $data = MorpheusPetsData::getInstance();

  if ( isset( $_GET[ $species_id_key ] ) )
  {
    // Return specific species
    $species_id = intval( $_GET[ $species_id_key ] );
    $species    = $data->getSpecies( $species_id );

    if ( isset( $species ) )
    {
      echo json_encode( $species );
    }
  }
  else
  {
    // Return all species
    $species = $data->getAllSpecies();
    if ( isset( $species ) )
    {
      echo json_encode( $species );
    }
  }
