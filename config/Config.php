<?php
    namespace Config;

   	/**
     * Klasa konfiguracyjna
   	 */
    class Config {
        public static $confdir = './';        // podfolder pliku konfiguracyjnego ini
        public static $filename = 'conf.ini'; // nazwa pliku konfiguracyjnego ini (domyślnie conf.ini)
        // Inicjalizacja zmiennych wybranej sekcji
        static function init($section) {
            $class = get_called_class();
            $data = parse_ini_file(self::$confdir . self::$filename, true, INI_SCANNER_TYPED);
            if (isset($data[$section])) {
                $data = $data[$section];
            }
            foreach ($data as $key => $value) {
                if (property_exists($class, $key))
                    $class::$$key = $value;
            }
        }
    }
