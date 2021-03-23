<?php
	namespace Controllers;

  /**
   * abstrakcyjna klasa kontrolera
   */
	abstract class Controller {
		/**
     * funkcja przekierowywująca akcję na inną
     * @param  string $url adres przekierowania
     */

		public function redirect($url) {
			//pobiera z FlashMessage tablice warning,success, error i dodaje do sesji
			\Tools\Session::set('warning', \Tools\FlashMessage::getWarning());
      \Tools\Session::set('success', \Tools\FlashMessage::getSuccess());
			\Tools\Session::set('error', \Tools\FlashMessage::getError());
		//	d(\Tools\Session::get('success'));
		//	d($_SESSION);
			if(preg_match('/^http:/', $url) === 1)
				header('location: '.$url);
			else
				header('location: '.\Config\Application\Config::$protocol.$_SERVER["SERVER_NAME"].':'.\Config\Application\Config::$port.'/'.\Config\Application\Config::$subdir.$url);
      exit(0);
		}
		public function redirectBack() {
			$this->redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
	}

		/**
     * zwraca nowy obiekt modelu
     * @param  string $name nazwa typu modelu
     * @return Model obiekt modelu
     */
		public function createModel($name){
			$fullname = 'Models\\'.$name;
			if(class_exists($fullname))
				return new $fullname();
			throw new \Exceptions\Application();
		}
		/**
     * zwraca nowy obiekt widoku
     * @param  string $name nazwa typu widoku
     * @return View obiekt widoku
     */
		public function createView($name){
			$name = 'Views\\'.$name;
			if(!class_exists($name))
				throw new \Exceptions\Application();
      $view = new $name();
      //$view->setAssets();
			return $view;
		}
	  /**
	   * sprawdza, czy tablica inputArray posiada ustawione wszystkie klucze
	   * @param  array $keys       tablica kluczy
	   * @param  array $inputArray sprawdzane tablica
	   * @return array             uzupełniona tablica
	   */
	  protected function check($keys, &$inputArray) {
	    if(is_array($inputArray))
	    foreach ($keys as $value) {
	      if(!array_key_exists($value, $inputArray))
	        $inputArray[$value] = null;
	    }
	  }
		public function protectXss($var) {
			if(\is_array($var))
				foreach ($var as &$value) {
					$value = $this->protectXss($value);
				}
			else
				$var = $this->checkVariable($var);
			return $var;
		}

		/**
		 * filtrowanie stringów pod kątem niebezpiecznych danych
		 * @param  string $var
		 * @return string
		 */
		public function checkVariable($var) {
			return \is_string($var) ? \htmlspecialchars($var) : $var;
		}

		public function getPost($key, $default = null) {
			return isset($_POST[$key]) ? $this->protectXss($_POST[$key]) : $default;
		}

		public function getGet($key, $default = null) {
			return isset($_GET[$key]) ? $this->protectXss($_GET[$key]) : $default;
		}
  }
