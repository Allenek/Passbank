<?php
	namespace Tools;
	use PhpRbac\Rbac;

	/**
	 * Klasa do obsługi sesji z logowaniem
	 */
	class Access extends Session {
		// klucze sesji
		public static 	$logged 		='logged';
		public static 	$login 			= 'user';
		public static 	$name 			= 'name';
		public static 	$id 				= 'id';
		private static 	$loginTime 	= 'logintime';
		// czas, po którym nastapi wylogowanie [sek]
		private static $sessionTime = 10;


	  private function __construct() {}

		public static function init() {
				self::$sessionTime = \Config\Application\Session::$sessionTime;
		}
		/**
		 * Logowanie
		 * @param  string $login 				login użytkownika
		 * @param  string $name  				nazwisko użytkownika
		 * @param  int $id    					identyfikator użytkownika
		 */
		public static function login($login, $name, $id) {
			// sprawdzenie istniejącej sesji
			if(parent::check() === true)
			{
				// zmieniając poziom dostępu regenerujemy sesję
				parent::regenerate();
				parent::set(self::$logged,'true');
				parent::set(self::$login, $login);
				parent::set(self::$name, $name);
				parent::set(self::$id, $id);
				parent::set(self::$loginTime, time());

			}
		}
		// wyloguj
		public static function logout() {
			parent::clear(self::$logged);
			parent::clear(self::$login);
			parent::clear(self::$name);
			parent::clear(self::$id);
			parent::clear(self::$loginTime);
			parent::regenerate();
		}
		// sprawdź czy jest zalogowany
		public static function islogin() {
			if(parent::is(self::$login) === true) {

				if(time() > parent::get(self::$loginTime) + self::$sessionTime) {
					// przekroczono czas sesji, wyloguj
					self::logout();
					return false;
				}
				parent::set(self::$loginTime, time());
				return true;
			}
			return false;
		}
	}
	Access::init();
