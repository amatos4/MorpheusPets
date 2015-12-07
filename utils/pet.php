<?php

  class PetUtils
  {
    /**
     * @param User $user
     * @param Pet  $pet
     *
     * @return bool whether user can edit the pet
     */
    public static function userCanEditPet( $user, $pet )
    {
      $res = false;
      if ( $user && $pet && $pet->getOwner() )
      {
        $res = $pet->getOwner()->getId() === $user->getId();
      }

      return $res;
    }
  }
