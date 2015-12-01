<?php
  class PetUtils
  {
    /**
     * @param User $user
     * @param Pet $pet
     *
     * @return bool whether user can edit the pet
     */
    public static function userCanEditPet( $user, $pet )
    {
      if ( $user && $pet && $pet->getOwner() )
      {
        return $pet->getOwner()->getId() === $user->getId();
      }
    }
  }
