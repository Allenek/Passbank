<?php
namespace Exceptions;

/**
 * wyjątek aplikacji
 */
class Query extends General {
  public function __construct($previousException = null){
    parent::__construct($previousException, \Messages\Error::$query);
  }
}
