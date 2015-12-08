<?php
  // POST keys
  $id_key         = 'pet_id';
  $delete_pet_key = 'delete_pet';

  // Route to delete pet page
  if ( isset( $_POST[ $delete_pet_key ] ) && isset( $_POST[ $id_key ] ) )
  {
    require_once 'actions/pet/delete.php';
  }
  // Route to edit pet page if pet id is given
  elseif ( isset( $_POST[ $id_key ] ) )
  {
    require_once 'actions/pet/edit.php';
  }
  // Route to create pet page
  else
  {
    require_once 'actions/pet/create.php';
  }
