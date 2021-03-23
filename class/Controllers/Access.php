<?php
	namespace Controllers;

	use \Tools\FlashMessage;

	class Access extends Controller {
		// formularz logowania
		/**
		 * [logForm description]
		 * @return [type] [description]
		 */
		public function logForm() {
      $this->view->setTemplate('Access/logForm');
		}

		/**
		 * [regForm description]
		 * @return [type] [description]
		 */
		public function regForm()	{
			$this->view->setTemplate('ajaxModals/addUser');
		}
		/**
		 * [register description]
		 * @return [type] [description]
		 */
		public function register() {
			$model = $this->createModel('Access');
			$counter= $model->register($_POST['login'],
																hash('sha256', $this->getPost('pwd')),
																$_POST['Imie'],
																$_POST['Nazwisko']);

			FlashMessage::addMessage($counter, 'register');
			$this->redirect('');
		}
			/**
			 * loguje do systemu
			 * @return [type] [description]
			 */
		public function login() {
			$model = $this->createModel('Access');
			if($this->getPost('login')  !== null && $this->getPost('password') !== null) {
				if($model->login($this->getPost('login'),hash('sha256',$this->getPost('password')))) {
					FlashMessage::addSuccess(\Messages\Success::$loginsuccess);
					$this->redirect('');
				} else {
					$model->countFails($this->getPost('login'));
				}
				$this->redirect('formularz-logowania/');
			}
		}
			/**
			 * wylogowywuje z systemu
			 * @return [type] [description]
			 */
			public function logout(){
				$this->createModel('Access')->logout();
				FlashMessage::addSuccess(\Messages\Success::$logoutsuccess);
				$this->redirect('formularz-logowania/');
			}
	}
