<?php
  // POST keys
  $id_key = 'pet_id';
  $preview_key = 'preview';

  // Route to edit pet page if pet id is given
  if ( isset( $_GET[ $id_key ] ) )
  {
    require_once 'actions/pet/edit.php';
  }
  // Route to create pet page
  else
  {
    require_once 'actions/pet/create.php';
  }
