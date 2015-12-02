<?php

  class User implements JsonSerializable
  {
    private $id;

    private $username;

    private $password_hash;

    private $email_address;

    private $description;

    /**
     * User constructor.
     *
     * @param string $user_name
     * @param string $email_address
     * @param string $description
     */
    public function __construct( $user_name, $email_address, $description )
    {
      $this->id            = 0;
      $this->username      = $user_name;
      $this->email_address = $email_address;
      $this->description   = $description;
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
    public function getUsername()
    {
      return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername( $username )
    {
      $this->username = $username;
    }

    /**
     * Hashes the password and sets the password hash
     *
     * @param string $password
     */
    function setPassword( $password )
    {
      $this->password_hash = password_hash( $password, PASSWORD_DEFAULT );
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
      return $this->password_hash;
    }

    /**
     * Sets the password hash (USE ONLY when retrieving hash from database!)
     *
     * @param string $password_hash
     */
    function setPasswordHash( $password_hash )
    {
      $this->password_hash = $password_hash;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
      return $this->email_address;
    }

    /**
     * @param string $email_address
     */
    public function setEmailAddress( $email_address )
    {
      $this->email_address = $email_address;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription( $description )
    {
      $this->description = $description;
    }

    /**
     * Verify that the provided password matches the user's password
     *
     * @param $password
     *
     * @return bool
     */
    function verifyPassword( $password )
    {
      return password_verify( $password, $this->password_hash );
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
        'id'            => $this->id,
        'username'      => $this->username,
        'email_address' => $this->email_address,
        'description'   => $this->description
      ];

      return $array;
    }
  }
