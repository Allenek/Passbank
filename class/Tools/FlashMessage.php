<?php
namespace Tools;

class FlashMessage {

  protected static $separator = '##';
  /**
   * kolekcja ostrzeżeń/komunikatów
   * @var array of string
   */
  protected static $warning = array();
  protected static $success = array();
  protected static $error = array();

	private function __construct() {}

  /**
   * Przygotowanie komunikatu poprzez zastąpienia ciągów specjalnych
   * @param  string $text    komunikat wejściowy
   * @param  array $replace zastępowane ciągi: string szukany => nowy string
   * @return string
   */
  public static function prepareString($text, $replace = null) {
    if(isset($replace) && \is_array($replace))
      foreach ($replace as $key => $value)
          $text = \str_replace(self::$separator.$key.self::$separator, $value, $text);
    return $text;
  }

  public static function addErrorSet($errorSet){
    foreach ($errorSet as $error){
      self::addError($error);
    }
  }
  public static function addError($text, $replace = null) {
    if(isset($replace) && \is_array($replace)) {
        $text = self::prepareString($text, $replace);
    }
    self::$error[] = $text;
  }


  public static function addWarningSet($warningSet){
    foreach ($warningSet as $warning){
      self::addWarning($warning);
    }
  }
  /**
   * dodaj ostrzeżenie/komunikat do kolekcji
   * @param string $text
   */
  public static function addWarning($text, $replace = null) {
    if(isset($replace) && \is_array($replace)) {
        $text = self::prepareString($text, $replace);
    }
    self::$warning[] = $text;
  }


  public static function addSuccessSet($successSet){
    foreach ($successSet as $success){
      self::addSuccess($success);
    }
  }
  /**
   * dodaj ostrzeżenie/komunikat do kolekcji
   * @param string $text
   */
  public static function addSuccess($text, $replace = null) {
    if(isset($replace) && \is_array($replace)) {
        $text = self::prepareString($text, $replace);
    }
    self::$success[] = $text;
  }

  //// TODO:
  /**
   * dodaj wiadomość do kolekcji w zależności od wartości
   * @param int     $value  wartość
   * @param string  $type   typ operacji
   */
  public static function addMessage($value, $type = 'add', $replace = null) {
    //d($value);
    if ($value < 0) {
      if (\property_exists('\Messages\Warning', $type))
        self::addWarning(\Messages\Warning::$$type, $replace);
    } elseif ($value === 0) {
      if (\property_exists('\Messages\Warning', $type))
        self::addWarning(\Messages\Warning::$nochanges, $replace);
    } else {
      if (\property_exists('\Messages\Success', $type))
        self::addSuccess(\Messages\Success::$$type, $replace);
    }
  }

  /**
   * zwróć wszystkie ostrzeżenia/komunikaty
   * @return array of string
   */
  public static function getWarning(){
      return self::$warning;
  }
  /**
   * zwróć wszystkie ostrzeżenia/komunikaty
   * @return array of string
   */
  public static function getSuccess(){
      return self::$success;
  }
  public static function getError(){
      return self::$error;
  }
  /**
   * czyście wszystkie ostrzeżenia/komunikaty
   * @return array of string
   */
  public static function clearWarning(){
      self::$warning = array();
  }
  public static function clearSuccess(){
      self::$success = array();
  }
  public static function clearError(){
      self::$error = array();
  }


  public static function countWarning(){
      return count(self::$warning);
  }
  public static function countSuccess(){
      return count(self::$success);
  }
  public static function countError(){
      return count(self::$error);
  }


}
