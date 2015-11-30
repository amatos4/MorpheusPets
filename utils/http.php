<?php

  class HTTPUtils
  {
    /**
     * Redirect page via HTTP header. Make sure no content was sent previously
     *
     * @param string $path_rel_to_root Path relative to root
     */
    public static function my_http_redirect( $path_rel_to_root )
    {
      $host  = $_SERVER[ 'HTTP_HOST' ];
      $uri   = rtrim( dirname( $_SERVER[ 'PHP_SELF' ] ), '/\\' );
      $extra = $path_rel_to_root;
      header( "Location: http://$host$uri/$extra" );
      die();
    }
  }
