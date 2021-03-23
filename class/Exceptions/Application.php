<?php
namespace Exceptions;

/**
 * wyjątek aplikacji
 */
class Application extends General {
  public function __construct($previousException = null){
    parent::__construct($previousException, \Messages\Error::$unkonwn);
  }
}
