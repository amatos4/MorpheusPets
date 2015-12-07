<?php

  class StringUtils
  {
    /**
     * Trims and strips HTML tags from a string
     *
     * @param $str
     *
     * @return string
     */
    public static function sanitize( $str )
    {
      return trim( strip_tags( $str ) );
    }

    /**
     * Returns whether the string is empty or only contains whitespace
     *
     * @param $str
     *
     * @return bool
     */
    public static function whitespaceOnly( $str )
    {
      return isset( $str ) && ( $str === "" || ctype_space( $str ) );
    }
  }
