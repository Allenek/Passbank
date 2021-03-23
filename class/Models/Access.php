<?php
	namespace Models;
	use \PDO;

	/**
	 * Obsługa procesu logowania
	 */
	class Access extends PDODatabase{
		/**
		 * logowanie do systemu
		 */
		public function login($login, $password) {
			//pobranie z bazy informacji o użytkowniku posiadającym login
			$datauser=self::dataquery($login);
			 if(isset($datauser)){
			 // Poprawne zalogowanie się użytkownika
				 if($this->checkPassword($datauser['Password'], $password))
				 {
					 if (!isset($datauser['banned_at'])) {
						 //zainicjalizowanie sesji
						
						 \Tools\Access::login($login, $datauser['Nazwisko'].' '.$datauser['Imie'] , $datauser['id']);
						 return true;
					 } else {
						 $date = new \DateTime($datauser['banned_at']);
						 if(new \DateTime() > date_modify($date,'+1 hour'))
						 {
							 
							 //zainicjalizowanie sesji
							 \Tools\Access::login($login, $datauser['Nazwisko'].' '.$datauser['Imie'] , $datauser['id']);
							 return true;
						 } else {
							 	\Tools\FlashMessage::addError('Konto zostało zablokowane do: ' . $date->format('Y-m-d H:i:s'));
								return false;
						 }
					 }
				 }
			 }
		 return false;
		}
		public function register($login,$password,$imie,$nazwisko)
				{
						$id=-1;
						$this->testConnection();
						$this->testTable('user');

						try
						{
							$query = 'INSERT INTO `user` (
												`Login`,`Password`,`Imie`,`Nazwisko`)';
							$query .= ' VALUES (:Login,:Password,:Imie,:Nazwisko)';
							$stmt = $this->pdo->prepare($query);
							$stmt->bindValue(':Login', $login, PDO::PARAM_STR);
							$stmt->bindValue(':Password', $password, PDO::PARAM_STR);
							$stmt->bindValue(':Imie', $imie, PDO::PARAM_STR);
							$stmt->bindValue(':Nazwisko', $nazwisko, PDO::PARAM_STR);

							if($stmt->execute())
									$id = $this->pdo->lastInsertId();
								$stmt->closeCursor();
			      }
			      catch(\PDOException $e)
						{

			         throw new \Exceptions\Query($e);
			      }
			      return $id;

				}
		public function dataquery($login) {
				$data;
				$this->testConnection();
				$this->testTable('user');

	      try	{
						$query = 'SELECT * FROM `user` WHERE Login= :login';

						$stmt = $this->pdo->prepare($query);
						$stmt->bindValue(':login', $login, PDO::PARAM_STR);
						if($stmt->execute())
						     $data = $stmt->fetch();
						$stmt->closeCursor();
	      }
	      catch(\PDOException $e)	{
	          throw new \Exceptions\Query($e);
	      }

	      return $data;
		}
		public function unbanUser($id)
		{
			try {
					$query = "UPDATE `user` SET `login_fails`= null ,`banned_at` = null  WHERE id=:id ";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':id',$id, PDO::PARAM_INT);
					if($stmt->execute())
							$data = $stmt->rowCount();
						$stmt->closeCursor();
			} catch(\PDOException $e)	{
					throw new \Exceptions\Query($e);
			}

		}
		public function countFails($login)
		{
			$userData = $this->dataquery($login);
			try {
				if ($userData['login_fails'] < 3) {
					$query = "UPDATE `user` SET login_fails = :loginFail WHERE id=:id ";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':loginFail', $userData['login_fails'] + 1, PDO::PARAM_STR);
					$stmt->bindValue(':id', $userData['id'], PDO::PARAM_STR);
					if($stmt->execute())
							$data = $stmt->rowCount();
						$stmt->closeCursor();
					if ($data > 0) {
						$fails = 3 - $userData['login_fails'];
						\Tools\FlashMessage::addWarning('Pozostała liczba logowań ' . $fails);
					}
				} else if(!isset($userData['banned_at'])) {
					$query = "UPDATE `user` SET `banned_at` = CURRENT_TIMESTAMP()  WHERE id=:id ";
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':id', $userData['id'], PDO::PARAM_INT);
					if($stmt->execute())
							$data = $stmt->rowCount();
						$stmt->closeCursor();
				$date = date_modify(new \DateTime(), '+1 hour');
				\Tools\FlashMessage::addError('Konto zostało zablokowane do: ' . $date->format('Y-m-d H:i:s'));
				}

			} catch (\Exception $e) {
				throw new \Exceptions\Query($e);
			}
			return $data;
		}
		/**
		 * Sprawdza zgodność hasła i jego powtórzenia
		 */
		public function checkPassword($password, $password2) {
			return $password === $password2;
		}
		/**
		 * Wylogowanie użytkownika z systemu
		 */
		public function logout(){
			\Tools\Access::logout();
		}
	}
