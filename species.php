<?php
  require_once 'utils/http.php';

  // GET keys
  $json_key = 'json';

  if ( isset( $_GET[ $json_key ] ) )
  {
    // Getting JSON data
    require_once 'actions/species/json.php';
  }
  else
  {
    HTTPUtils::my_http_redirect( 'index.php' );
  }



