<?php
	namespace Models;
	use \PDO;

  /**
   * klasa modelu wykorzystująca bibliotekę PDO
   */
	class PDODatabase extends \Models\Model {
		/**
		 * obiekt do połączenia z bazą danych
		 * @var PDO
		 */
		protected $pdo;
		/**
		 * nazwa tabeli
		 * @var String
		 */
		protected $table = null;

    protected $type = array(
			'null'   => PDO::PARAM_NULL,
      'int'    => PDO::PARAM_INT,
			'string' => PDO::PARAM_STR

		);
    public function __construct($handle = null) {
      if(isset($handle))
        $this->pdo = $handle;
      else
        $this->pdo = \Handles\MySQL::getHandle();
			
    }


		/**
		 * testuje połączenie z bazą danych na podstwie obiektu PDO
		 */
    public function testConnection() {
      if($this->pdo === null) throw new \Exceptions\DatabaseConnection();
    }

		/**
		 * testuje nazwę tabeli
		 */
    public function testTable($table) {
      if($table === null || \strlen($table) === 0) throw new \Exceptions\DatabaseConnection();
    }

		/**
		 * sprawdza czy określono nazwę tabeli
		 */
    protected function getTableName($table = null) {
        if($table !== null && \strlen($table) > 0)
          return $table;
        return $this->table;
    }

		/**
		 * zwraca wszystkie rekordy tablic
		 * @param  $table nazwa tablicy
		 * @return array rekordy
		 */
		public function selectAll($table = null){
				return $this->selectAllOrderBy(null, 'ASC', $table);
		}
		/**
		 * zwraca wszystkie rekordy tablic posortowane
		 * @param  $table nazwa tablicy
		 * @param  String $orderColumn nazwa kolumny wg. której sortujemy
		 * @param  String $orderType rodzaj sortowania
		 * @return array rekordy
		 */
		public function selectAllOrderBy($orderColumn = null, $orderType = 'ASC', $table = null){
				$data = array();
				$this->testConnection();
				$table = $this->getTableName($table);

				$this->testTable($table);
	      try	{
						$query = 'SELECT * FROM '.$table;
						if(isset($orderColumn)){
							$query .= ' ORDER BY :orderColumn';
							$query .= ' '.$orderType;
						}

						$stmt = $this->pdo->prepare($query);
						$stmt->bindValue(':orderColumn', $orderColumn, PDO::PARAM_STR);
						if($stmt->execute())
						     $data = $stmt->fetchAll();
						$stmt->closeCursor();
	      }
	      catch(\PDOException $e)	{
	          throw new \Exceptions\Query($e);
	      }

	      return $data;
		}

		/**
		 * zwraca rekord o wybranym id
		 * @param  $table nazwa tablicy
		 * @param  int $id wartość identyfikatora
		 * @return array rekord
		 */
    public function selecteOneById($id, $table = null) {
				$this->testConnection();
				$table = $this->getTableName($table);
				$this->testTable($table);
				try	{
						$query = 'SELECT * FROM `'.$table.'` WHERE id = :id';
						$stmt = $this->pdo->prepare($query);
          	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
						if($stmt->execute())
						  $data = $stmt->fetchAll();
						$stmt->closeCursor();
  					if(isset($data[0]) && count($data) === 1)
            	return $data[0];
				}
				catch(\PDOException $e)	{
					throw new \Exceptions\Query($e);
				}
				return array();
		}


		/**
		 * usuwa rekord o wybranym id z tabeli
		 * @param  $table nazwa tablicy
		 * @param  int $id wartość identyfikatora
		 * @return int ilość usuniętych rekordów lub -1 w przypadku błędu
		 */
    public function deleteOneById($id, $table = null) {
				$this->testConnection();
				$table = $this->getTableName($table);
				$this->testTable($table);
				$counter = 0;
				try	{
						$query = 'DELETE FROM `'.$table.'` WHERE id = :id';
						$stmt = $this->pdo->prepare($query);
          	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
						if($stmt->execute())
						  $counter = $stmt->rowCount();
	          else
	            $counter = -1;
						$stmt->closeCursor();
					}
					catch(\PDOException $e)	{
						//throw new \Exceptions\Query($e);
					}
					return $counter;
		}


		/**
		 * zmienia tablicę do postaci tablicy asocjacyjnej, gdzie jedna z kolumn jest kluczem
		 * @param  array $data       tablice wejściowa
		 * @param  string $keyColumn kolumna, będąca kluczem
		 * @return array 						 tablica asocjacyjna
		 */
		public function transferByColumn($data, $keyColumn = 'id') {
			if(count($data) > 0)
			{
					$tmp = array();
					foreach ($data as $item) {
						$tmp[$item[$keyColumn]] = $item;
						unset($tmp[$item[$keyColumn]][$keyColumn]);
					}
					$data = $tmp;
			}

			return $data;
		}

		/**
		 * zmienia tablicę do postaci tablic asocjacyjnej jednowymiarowej
		 * @param  array $data          tablica wejściowa
		 * @param  array $valueColumns 	lista kolumna scalanaych jako wartość
		 * @param  string $separator    searator scalonych do wartości kolumn
		 * @param  string $keyColumn    kolumna użyta jako klucz
		 * @return array 								jednowymiarowa tablica asocjacyjna
		 */
		public function transferToSelectable($data, $valueColumns, $separator = ' ', $keyColumn = 'id'){
      $amount = count($valueColumns);
			if(count($data) > 0)
			{
					$tmp = array();
					foreach ($data as $item) {
            if(!isset($item[$keyColumn])) continue;
						$tmp[$item[$keyColumn]] = '';
            $it = 0;
            foreach ($valueColumns as $columnName) {
              $it++;
              if(isset($item[$columnName]))
                $tmp[$item[$keyColumn]] .= $item[$columnName];
              if($it < $amount)
                $tmp[$item[$keyColumn]] .= $separator;
            }
					}
					return $tmp;
			}
			return array();
		}
	}
