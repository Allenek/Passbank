<?php
	namespace Models;

  /**
   * abstrakcyjna klasa modelu
   */
	abstract class Model {
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
		
	}
