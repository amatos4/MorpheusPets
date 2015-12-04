<?php
  // GET keys
  $pet_id_key = 'pet_id';

  if ( isset( $_GET[ $pet_id_key ] ) )
  {
    // Route to pet view page
    require_once 'actions/pet/view.php';
  }
