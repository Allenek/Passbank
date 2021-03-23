<?php
	namespace Tools;

	/**
	 * Klasa do obsługi routingu
	 */
	class Router  {
    protected static $router = null;
    protected function __clone() {}
    protected function __construct() {}
    public static function getRouter() {
        $className = get_called_class();
        if(!isset(self::$router) || self::$router === null) {
          self::$router = new \AltoRouter();
          self::configure();
        }
        return self::$router;
    }
    protected static function configure() {
          self::$router->setBasePath(\Config\Application\Config::$subdir);
          foreach (\Config\Application\Routing::$routes as $route) {
            self::$router->map($route[0],$route[1], $route[2], $route[3]);
          }
    }
  }
