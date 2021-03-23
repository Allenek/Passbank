<?php
    namespace Config\Application;

    use Config\Config as Conf;
	 	/**
     * Klasa konfiguracyjna aplikacji internetowej
   	 */
    final class Session extends Conf {
        public static $regenerateTime    = '';     // czas do regenracji sesji
        public static $regenerateRequest = '';     // ilość zapytań do regenracji sesji
        public static $sessionTime       = '';     // czas automatycznego wylogowania
    }
    Session::init('Session');
