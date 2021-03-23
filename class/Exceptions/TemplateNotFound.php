<?php
	namespace Exceptions;
  /**
   * Klas błędu nieodnalezienia szablonu
   */
  class TemplateNotFound extends General
  {
    protected $templateName;
    public function __construct($previousException = null, $template = null){
      $this->templateName = $template;
      parent::__construct($previousException, \Messages\Error::$templateNotFound);
    }
  }
