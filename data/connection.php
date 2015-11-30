<?php
  require_once 'data/settings.php';

  /*****************************************************
   **                                                 **
   **  Class database written by Steven A. Gabarró    **
   **  Modified by Phil Barresi, MorpheusPets         **
   **                                                 **
   ****************************************************/
  class DatabaseConnection
  {
    private $host     = "localhost";
    private $username = "username";
    private $password = "password";
    private $database = "";

    /**
     * @var mysqli MySQLi database connection object
     */
    private $mysqli;

    // This is your constructor
    public function __construct()
    {
      global $db_connection;

      $host     = $db_connection[ 'host' ];
      $username = $db_connection[ 'username' ];
      $password = $db_connection[ 'password' ];
      $database = $db_connection[ 'database' ];

      $this->setup( $host, $username, $password, $database );
    }

    // When the object is destroyed, disconnect from the database to free up sources
    public function __destruct()
    {
      $this->disconnect();
    }

    // If you had multiple databases or are using a non default database, you would need to change the database
    public function change_database( $newDb )
    {
      $this->database = $newDb;
      if ( isset( $this->mysqli ) )
      {
        $this->mysqli->select_db( $newDb );
      }
      else
      {
        $this->connect();
      }
    }

    // sets user, pass and host and connects
    public function setup( $host, $username, $password, $db )
    {
      $this->host     = $host;
      $this->username = $username;
      $this->password = $password;
      $this->database = $db;

      if ( isset( $this->mysqli ) )
      {
        $this->disconnect();
      }

      $this->connect();
    }

    //Closes the connection to the DB
    public function disconnect()
    {
      if ( isset( $this->mysqli ) )
      {
        $this->mysqli->close();
      }
      if ( isset( $this->res ) && gettype( $this->res ) == "object" )
      {
        $this->res->free();
      }
      unset( $this->res );
      unset( $this->mysqli );
    }

    // connects to the DB or disconnects/reconnects if a connection already existed
    public function connect()
    {
      if ( isset( $this->mysqli ) )
      {
        $this->disconnect();
      }
      try
      {
        if ( !$this->mysqli = new mysqli( $this->host, $this->username, $this->password, $this->database ) )
        {
          throw new Exception( "Cannot Connect to " . $this->host );
        }
      }
      catch ( Exception $e )
      {
        echo $e->getMessage();
        exit;
      }
    }

    public function prepare_statement( $statement )
    {
      if ( !isset( $this->mysqli ) )
      {
        $this->connect();
      }

      return $this->mysqli->prepare( $statement );
    }

    public function send_sql( $statement )
    {
      if ( !isset( $this->mysqli ) )
      {
        $this->connect();
      }

      return $this->mysqli->query( $statement );
    }

    public function last_insert_id()
    {
      return $this->mysqli->insert_id;
    }

    public function error()
    {
      return $this->mysqli->error;
    }
  }
