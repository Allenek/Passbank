<?php
namespace Exceptions;

/**
 * wyjątek aplikacji
 */
class DatabaseConnection extends General {
  public function __construct($previousException = null){
    parent::__construct($previousException, \Messages\Error::$databaseConnection);
  }
}
