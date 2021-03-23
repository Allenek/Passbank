<?php

namespace Views;
use \Config\Application\Config;
/**
 *
 */
class TwigView extends View
{
  /**
   * Ścieżka do szablonu
   * @var string
   */
  protected $template;
  /**
   * ścieżki plików js
   * @var [type]
   */
  protected $js;
  /**
   * ścieżki plików css
   * @var [type]
   */
  protected $css;
  /**
   * Obiekt Twig
   * @var [type]
   */
  protected $twig;
  /**
   * dane przekazywane do widoku - dane do tabel, informacja o tym czy jest user jest zalogowany
   * @var [type]
   */
  protected $data;

  function __construct()
  {
    $this->js = ['js/ext/jquery.min.js',
                'js/ext/bootstrap.min.js',
                'js/ext/datatables.min.js',
                'js/ext/validator.min.js',
                'js/ext/components/core-min.js',
                'js/ext/rollups/sha1.js',
                'js/ext/rollups/aes.js',
                'js/ext/client_captcha.js',
                'js/main.js',
                'js/load-modal.js',
                'js/crypt.js',
                'js/environment.js',
                'js/modals.js',
                'js/captcha.js'
              ];

    $this->css = ['css/bootstrap.min.css','css/main.css'];
    $this->data = ['url' => Config::$protocol . $_SERVER["SERVER_NAME"] .':81/' . Config::$subdir];
    $loader = new \Twig_Loader_Filesystem('./templates/');
    $this->twig = new \Twig_Environment($loader, []);

     if(\Tools\Access::isLogin()===true)
    {
      $this->data['isLogin']=true;
    }
  }

  public function setTemplate($template)
  {
    if (is_file('./templates/' . $template . '.html.twig')) {
      $this->template = $template . '.html.twig';
      return true;
    } else {
      return false;
    }
  }

  public function render()
  {
    if (isset($this->template)) {
      $this->setData(['JavaScriptFiles' => $this->js]);
      $this->setData(['StyleSheetFiles' => $this->css]);
      echo $this->twig->render($this->template, $this->data);
    }
  }

  /**
   * Ustawienie danych widoku
   * @param [type] $data [description]
   */
  public function setData($data)
  {
    if (is_array($data)) {
      $this->data = array_merge($this->data, $data);
    }

  }

  public function addJSFile($file){
      if(file_exists('./js/'.$file.'.js'))
        $this->js[] = 'js/'.$file.'.js';
      else if(file_exists('./js/'.$file.'.min.js'))
        $this->js[] = $file.'.min.js';

    }
    public function addJSSet($files){

      foreach($files as $file)
         $this->addJSFile($file);

    }
    public function addCSSFile($file){
      if(file_exists('./css/'.$file.'.css'))
        $this->css[] = 'css/'.$file.'.css';
      else if(file_exists('./css/'.$file.'.min.css'))
        $this->css[] = $file.'.min.css';

    }
    public function addCSSSet($files){

      foreach($files as $file)
         $this->addCSSFile($file);
    }
    public function set($name,$value)
    {
    $this->data[$name]=$value;

    }
}
