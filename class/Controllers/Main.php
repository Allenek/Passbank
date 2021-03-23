<?php
  namespace Controllers;

  /**
   * Główny kontroler aplikacji
   */
  final class Main extends Controller {
    public function __construct() {
        try {

          //\Tools\Roles::initialize();
          \Tools\Session::initialize();
          $this->getFlashMessageFromSession();

          $router = \Tools\Router::getRouter();
          $match = $router->match();
          // Kontroler / akcja / parametr_id
          $controller = isset($match['target']['controller'])  ? $match['target']['controller'] : '';
          $action     = isset($match['target']['action'])      ? $match['target']['action']     : '';
          $id         = isset($match['params']['id'])          ? $match['params']['id']         : null;
          // Dodanie do nazwy kontrolera przestrzeni nazw
      		$fullController = 'Controllers\\'.$controller;

      		// Utworzenie kontrolera (jeśli istnieje)
      		if (!class_exists($fullController)) {
            \Tools\FlashMessage::addError(\Messages\Error::$page );
              $this->redirect('');
            throw new \Exceptions\Application();
          }

      		$appController = new $fullController();
          // Utworzenie obiektu widoku
          $appController->view = $this->createView('TwigView');
          $result = [];

        	if (\Tools\Access::islogin() !== true) {
              // Logowanie do systemu lub rejestracja
              if ($controller === 'Access' && (
                      $action === 'login'   ||
                      $action === 'register'     ||
                      $action === 'regForm' ||
                      $action === 'logForm' )) {
                  $result = $appController->$action();
              }
               else {
                   \Tools\FlashMessage::addWarning(\Messages\Warning::$nologin);

                  if (preg_match('/^ajax/', $action) === 1) // Zapytanie asynchroniczne
                    $appController->view->setTemplate('ajaxModals/notAllow');
                  else // To nie jest zapytanie asynchroniczne
                    $this->redirect('formularz-logowania/');
              }

        	} else {
        		// Sprawdzamy, czy akcja kontrolera istnieje
        		if (!\method_exists($appController, $action))
                throw new \Exceptions\Application();
            // Uruchamiamy akcję kontrolera
            $result = $appController->$action($id);
          }


          // Przekazujemy zwrócone dane do widoku
          $appController->view->setData($result);
          // Ustawiamy dla widoku komunikaty
          $appController->view->set('warning', \Tools\FlashMessage::getWarning());
          $appController->view->set('success', \Tools\FlashMessage::getSuccess());
          $appController->view->set('error', \Tools\FlashMessage::getError());
          // Renderujemy widok
          $appController->view->render();
        } catch (\Exceptions\DatabaseConnection $e) {

          //d($e);
          $this->redirect('404.html');
        } catch(\Exceptions\General $e) {
          d($e);
          $this->redirect('404.html');
        } catch(\Exception $e) {
          d($e);
          $this->redirect('404.html');
        }
    }
        /**
        * Pobranie FlashMessage z sesji i dodanie do zbioru FlashMessage
        */
        private function getFlashMessageFromSession() {
          //pobieramy informacje z sesji
          $warning = \Tools\Session::get('warning');
          \Tools\Session::clear('warning');
          $success = \Tools\Session::get('success');
          \Tools\Session::clear('success');
          $error = \Tools\Session::get('error');
          \Tools\Session::clear('error');

          if(isset($warning))
            \Tools\FlashMessage::addWarningSet($warning);
          if(isset($success))
            \Tools\FlashMessage::addSuccessSet($success);
          if(isset($error))
              \Tools\FlashMessage::addErrorSet($error);
            }
}
