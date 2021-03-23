<?php
		namespace Config\Database;

		use Config\Config as Conf;
	  /**
	   * Klasa konfiguracyjna bazy MySQL
	   */
		final class MySQL extends Conf {
	    //nazwa bazy danych
	    public static $database = '';
	    //dane dostępowe do bazy danych
	    public static $hostname = '';
	    public static $type 		= '';
	    public static $port 		= '';
	    public static $user 		= '';
	    public static $password = '';

	  }
		MySQL::init('MySQL');
