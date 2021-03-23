<?php
	namespace Models;
	use \PDO;

  class Accounts extends PDODatabase {
		public function __construct() {
      	$this->table = 'sites';
				parent::__construct();
    }

    public function selectPasswords() {
      $user_id = \Tools\Access::get(\Tools\Access::$id);
      $data = [];
      $this->testConnection();
      $this->testTable($this->table);

      try	{
          $query = 'SELECT id,website,login, password FROM `'.$this->table.'` WHERE user_id= :user_id';
          $stmt = $this->pdo->prepare($query);
          $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
          if($stmt->execute())
               $data = $stmt->fetchAll();
          $stmt->closeCursor();
      }
      catch(\PDOException $e)	{
          throw new \Exceptions\Query($e);
      }
      return $data;
    }

		public function insertAccount($website, $login, $password) {
			$id = -1;
			$this->testConnection();
			$this->testTable($this->table);
			if (!isset($website, $login, $password)) {
				throw new AppException(ErrorName::$empty);
			}
			try {
				$query = 'INSERT INTO `'.$this->table.'` (`user_id`, `website`, `login`, `password`)';
					$query .= ' VALUES (:userId,:website,:login,:password)';
					$stmt = $this->pdo->prepare($query);
					$stmt->bindValue(':userId',\Tools\Access::get('id') , PDO::PARAM_STR);
					$stmt->bindValue(':website', $website, PDO::PARAM_STR);
					$stmt->bindValue(':login', $login, PDO::PARAM_STR);
					$stmt->bindValue(':password', $password, PDO::PARAM_STR);
					if($stmt->execute())
						$id = $this->pdo->lastInsertId();
					$stmt->closeCursor();

			} catch (\PDOException $e) {
				d($e);
				throw new \Exceptions\Query($e);
			}
			return $id;
		}

		public function passwordVerify($insertedPwd)
		{
			try {
				$query = "SELECT Password FROM user WHERE id = :userId";
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':userId',\Tools\Access::get('id') , PDO::PARAM_STR);
				if($stmt->execute())
					$pwd = $stmt->fetchAll();
				$stmt->closeCursor();

			} catch (\PDOException $e) {
				throw new \Exceptions\Query($e);
			}

			if (hash('sha256',$insertedPwd) == $pwd[0]['Password']) {
				return true;
			}
			return false;
		}
  }
