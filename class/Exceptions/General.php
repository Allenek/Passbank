<?php
namespace Exceptions;

/**
 * wyjątek ogólny
 */
class General extends \Exception {
  public function __construct($previousException = null, $message = null) {
    parent::__construct($message);
    if(isset($previousException))
      ;//d($previousException);
  }
}
