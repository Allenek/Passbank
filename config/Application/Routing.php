<?php
    namespace Config\Application;
final class Routing {
    public static $routes = [
      ['GET','/', array('controller' => 'Accounts', 'action' => 'getPasswords'), 'mainpage'],
      //Akcje Banku haseł
      ['GET','/konto-formularz/?', array('controller' => 'Accounts', 'action' => 'ajaxAddAccountForm'), 'formularz konta'],
      ['POST','/konto-dodaj/?', array('controller' => 'Accounts', 'action' => 'addAccount'), 'dodawanie konta'],
      ['GET','/pokaz-haslo/[i:id]/?', array('controller' => 'Accounts', 'action' => 'ajaxDecryptPassword'), 'wyswietlenie hasla'],
      ['GET','/konto-usun/[i:id]/?', array('controller' => 'Accounts', 'action' => 'delete'), 'usuwanie hasla'],
      //konfiguracja logowania
      ['POST','/zarejestruj/?', array('controller' => 'Access', 'action' => 'register'), 'reg'],
      ['GET','/formularz-rejestracja/?', array('controller' => 'Access', 'action' => 'regForm'), 'reg_form'],
      ['GET','/formularz-logowania/?', array('controller' => 'Access', 'action' => 'logForm'), 'login_form'],
      ['POST','/zaloguj/?', array('controller' => 'Access', 'action' => 'login'), 'login'],
      ['GET','/wyloguj/?', array('controller' => 'Access', 'action' => 'logout'), 'logout']







    ];
}
